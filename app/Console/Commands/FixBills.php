<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Bill;
use App\Billdetail;

use Carbon\Carbon;

class FixBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix billdetails';

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
        $this->fix(21, 12, 2016);
        $this->fix(26, 12, 2016);
        $this->fix(01, 01, 2017);
        $this->fix(02, 01, 2017);
        $this->fix(10, 01, 2017);
        $this->fix(11, 01, 2017);
        $this->fix(21, 01, 2017);
        $this->fix(26, 01, 2017);
    }

    private function fix($day, $month, $year)
    {
        $bills = Bill::where('active', true)->where('payment_day', $day)->get();

        foreach ($bills as $bill)
        {
            $day = strval($day);
            $month = strval($month);
            $year = strval($year);

            $preparedDate = $day . '-' . $month . '-' . $year;
            $uf = $this->fetchUFValue($preparedDate);
            
            echo 'Running bill: ';
            echo $bill->description;
            echo ' (';
            echo $preparedDate;
            echo ')';
            echo "\n";

            if($bill->sectors->count())
            {
                foreach($bill->sectors as $sector)
                {
                    foreach($sector->locations as $location)
                    {
                        if(!($location->partner_id) || !($bill->types->where('id', $location->type->id)->count()))
                            continue;

                        $billdetail = new Billdetail;
                        $billdetail->bill_id = $bill->id;
                        $billdetail->location_id = $location->id;
                        $billdetail->partner_id = $location->partner_id;
                        $billdetail->vfpcode = $bill->vfpcode;
                        $billdetail->amount = $bill->is_uf ? $bill->amount * $uf : $bill->amount;
                        if(isset($bill->overdue_day)
                            && isset($bill->overdue_amount)
                            && isset($bill->overdue_is_uf)
                            && isset($bill->overdue_vfpcode))
                        {
                            // Has overdue settings, make attributes
                            $date = Carbon::now()->addMonth();
                            $date->day = $bill->overdue_day;
                            $billdetail->overdue_date = $date;
                        }
                        $billdetail->overdue_billed = isset($bill->overdue_day) ? false : null;
                        $billdetail->save();

                        $billdetail->created_at = $year . '-' . $month . '-' . $day .' 05:45:00';
                        $billdetail->save();

                        if(isset($bill->overdue_day)
                            && isset($bill->overdue_amount)
                            && isset($bill->overdue_is_uf)
                            && isset($bill->overdue_vfpcode))
                        {
                            // Has overdue settings, make attributes
                            $date = $billdetail->created_at->copy()->addMonth();
                            $date->day = $bill->overdue_day;
                            $billdetail->overdue_date = $date;
                            $billdetail->save();
                        }

                        echo 'ID: ';
                        echo $billdetail->id;
                        echo ' - Saved for partner: ';
                        echo $billdetail->partner->user->name;
                        echo ' (Sector: ' . $billdetail->location->sector->code . ' - Ubicacion: ' . $billdetail->location->code . ')';
                        echo "\n";
                    }
                }
            }
            // Logic for Location bills
            elseif($bill->locations->count())
            {
                // Belongs to Location;
                foreach($bill->locations as $location)
                {
                    if(!$location->partner_id)
                        continue;

                    $billdetail = new Billdetail;
                    $billdetail->bill_id = $bill->id;
                    $billdetail->location_id = $location->id;
                    $billdetail->partner_id = $location->partner_id;
                    $billdetail->vfpcode = $bill->vfpcode;
                    $billdetail->amount = $bill->is_uf ? $bill->amount * $uf : $bill->amount;
                    if(isset($bill->overdue_day)
                        && isset($bill->overdue_amount)
                        && isset($bill->overdue_is_uf)
                        && isset($bill->overdue_vfpcode))
                    {
                        // Has overdue settings, make attributes
                        $date = Carbon::now()->addMonth();
                        $date->day = $bill->overdue_day;
                        $billdetail->overdue_date = $date;
                    }
                    $billdetail->overdue_billed = isset($bill->overdue_day) ? false : null;
                    $billdetail->save();

                    $billdetail->created_at = $year . '-' . $month . '-' . $day .' 05:45:00';
                    $billdetail->save();

                    if(isset($bill->overdue_day)
                            && isset($bill->overdue_amount)
                            && isset($bill->overdue_is_uf)
                            && isset($bill->overdue_vfpcode))
                        {
                            // Has overdue settings, make attributes
                            $date = $billdetail->created_at->copy()->addMonth();
                            $date->day = $bill->overdue_day;
                            $billdetail->overdue_date = $date;
                            $billdetail->save();
                        }

                    echo 'ID: ';
                    echo $billdetail->id;
                    echo ' - Saved for partner: ';
                    echo $billdetail->partner->user->name;
                    echo ' (Sector: ' . $billdetail->location->sector->code . ' - Ubicacion: ' . $billdetail->location->code . ')';
                    echo "\n";
                }
            }
            // Logic for Group bills
            elseif($bill->groups->count())
            {
                foreach($bill->groups as $group)
                {
                    foreach($group->locations as $location)
                    {
                        if(!$location->partner_id)
                            continue;

                        $billdetail = new Billdetail;
                        $billdetail->bill_id = $bill->id;
                        $billdetail->location_id = $location->id;
                        $billdetail->partner_id = $location->partner_id;
                        $billdetail->vfpcode = $bill->vfpcode;
                        $amount = $bill->is_uf ? $bill->amount * $uf : $bill->amount;
                        if($group->percentages->count())
                        {
                            $pct = $group->percentages()->where('location_id', $location->id)->first();
                            $amount = $amount * ($pct->pct * 0.01);
                        }
                        $billdetail->amount = $amount;
                        if(isset($bill->overdue_day)
                            && isset($bill->overdue_amount)
                            && isset($bill->overdue_is_uf)
                            && isset($bill->overdue_vfpcode))
                        {
                            // Has overdue settings, make attributes
                            $date = Carbon::now()->addMonth();
                            $date->day = $bill->overdue_day;
                            $billdetail->overdue_date = $date;
                        }
                        $billdetail->overdue_billed = isset($bill->overdue_day) ? false : null;
                        $billdetail->save();

                        $billdetail->created_at = $year . '-' . $month . '-' . $day .' 05:45:00';
                        $billdetail->save();

                        if(isset($bill->overdue_day)
                            && isset($bill->overdue_amount)
                            && isset($bill->overdue_is_uf)
                            && isset($bill->overdue_vfpcode))
                        {
                            // Has overdue settings, make attributes
                            $date = $billdetail->created_at->copy()->addMonth();
                            $date->day = $bill->overdue_day;
                            $billdetail->overdue_date = $date;
                            $billdetail->save();
                        }

                        echo 'ID: ';
                        echo $billdetail->id;
                        echo ' - Saved for partner: ';
                        echo $billdetail->partner->user->name;
                        echo ' (Sector: ' . $billdetail->location->sector->code . ' - Ubicacion: ' . $billdetail->location->code . ')';
                        echo "\n";
                    }
                }
            }
        }
    }

    private function fetchUFValue($date = null)
    {
        $client = new \GuzzleHttp\Client();
        if($date == null)
        {
            $res = $client->request('GET', 'http://mindicador.cl/api')->getBody();
            return json_decode($res)->uf->valor;
        }

        $url = 'http://mindicador.cl/api/uf/';
        $url .= $date;

        $res = $client->request('GET', $url)->getBody();
        return json_decode($res)->serie[0]->valor;
    }
}
