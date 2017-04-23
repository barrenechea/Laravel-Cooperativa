<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\MaeCue;
use App\Tabanco;
use App\Tabaux10;
use App\Sesion;

use App\Sector;
use App\Location;
use App\Billdetail;
use App\Payment;

use Carbon\Carbon;

class FixDrysoft extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:drysoft';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix Drysoft';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->fix();
    }

    private function fix()
    {
        $day = 10;
        $month = 2;
        echo 'DRYCONA4 FIX';
        echo "\n";
        $tabaux10 = Tabaux10::onlyTrashed()->whereDay('deleted_at', $day)->whereMonth('deleted_at', $month)->restore();
        $sesiones = Sesion::onlyTrashed()->whereDay('deleted_at', $day)->whereMonth('deleted_at', $month)->restore();

        echo 'DRYCONA4 RE-SYNC';
        echo "\n";
        $payments = Payment::whereNotNull('vfpsesion_id')->pluck('vfpsesion_id');
        $sesiones = Sesion::where('vfptable', 'LIKE', 'DRYCONA4%')->whereNotIn('id', $payments)->get();
        foreach ($sesiones as $sesion) {
            if($this->attemptToSync($sesion))
            {
                echo 'Synced: ' . $sesion->detalle2 . ' - Glosa: ' . $sesion->glosa;
                echo "\n";
            }
        }

        echo 'DRYCONA5 RE-SYNC';
        echo "\n";
        $payments = Payment::whereNotNull('vfpsesion_id')->pluck('vfpsesion_id');
        $sesiones = Sesion::where('vfptable', 'LIKE', 'DRYCONA5%')->whereNotIn('id', $payments)->get();
        foreach ($sesiones as $sesion) {
            if($this->attemptToSync($sesion))
            {
                echo 'Synced: ' . $sesion->detalle2 . ' - Glosa: ' . $sesion->glosa;
                echo "\n";
            }
        }
    }

    private function attemptToSync(Sesion $sesion)
    {
        // This means it's not a detail, so we'll jump it if it is
        if($sesion->debe > 0) return false;

        // Split the detail of the recently added Sesion
        $splitted = explode(" ", strtoupper($sesion->detalle2));
        // Attempt to find a date
        foreach ($splitted as $value) {
            if (strpos($value, '-') !== false) {
                $exploded = explode('-', $value);
                foreach ($exploded as $part) {
                    if(!is_numeric($part)) continue 2;
                }
                $supposedDate = $value;
            }
        }
        if(!isset($supposedDate)) return false;
        // We have a supposed date inside the Sesion description!
        // Now check parameters inside that "date"
        $exploded = explode('-', $supposedDate);
        foreach ($exploded as $part) {
            if(strlen($part) === 4) $year = $part;
            elseif(strlen($part) === 1 || strlen($part) === 2) $month = $part;
        }
        if(!isset($year) || !isset($month)) return false;
        // We have a year and a month! We can continue
        // Now obtain an array with all the Sector codes
        $sectors = Sector::pluck('code')->all();
        // Attempt to see if any sector is contained in the Sesion description
        $match_sector=array_intersect($splitted, $sectors);
        if(count($match_sector) > 0)
        {
            // Found a sector match!
            $sector = Sector::where('code', $match_sector)->first();
            $locations = Location::where('sector_id', $sector->id)->pluck('code')->all();
            $match_location=array_intersect($splitted, $locations);
            if(count($match_location) > 0)
            {
                // Found a location match!
                $location = Location::where('sector_id', $sector->id)->where('code', $match_location)->first();
                if($location->partner_id)
                {
                    //Verified that the location has a partner assigned
                    $billdetails = Billdetail::where('location_id', $location->id)->where('vfpcode', $sesion->codigo)->get();
                    foreach ($billdetails as $billdetail) {
                        $sesionDate = Carbon::createFromFormat('d-m-Y', '01-'.$month.'-'.$year)->subMonth();
                        if($billdetail->created_at->year === $sesionDate->year && $billdetail->created_at->month === $sesionDate->month)
                        {
                            // The dates matches correctly!
                            $payment = new Payment();
                            $payment->billdetail_id = $billdetail->id;
                            $payment->vfpsesion_id = $sesion->id;
                            $payment->amount = $sesion->haber;
                            $payment->document_id = $sesion->numero;
                            $payment->save();
                            // Everything done!
                            return true;
                        }
                    }
                    return false;
                }
            }
        }
    }
}
