<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Sesion;
use App\Location;
use App\Sector;
use App\Bill;
use App\Billdetail;
use App\Payment;

use Carbon\Carbon;

class SesionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->input('vfptable') == null) return Sesion::all();
        return Sesion::where('vfptable', $request->input('vfptable'))->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sesion = Sesion::create($request->input());

        // Try to sync to a BillDetail
        $this->attemptToSync($sesion);

        return response()->json(['status' => true, 'id' => $sesion->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $sesion = Sesion::find($id);

        if (!$sesion)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        return $sesion;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sesion = Sesion::find($id);

        if (!$sesion)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);
        
        $sesion->fill($request->input())->save();

        // Check if exists any payment related to that Sesion
        $payment = Payment::where('vfpsesion_id', $sesion->id)->first();
        if($payment)
            $payment->delete();
        
        $this->attemptToSync($sesion);

        return response()->json(['status' => true, 'id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $sesion = Sesion::find($id);

        if (!$sesion)
            return response()->json(['status' => false, 'message' => 'Record not found'], 404);

        $payment = Payment::where('vfpsesion_id', $sesion->id)->first();
        if($payment)
            $payment->delete();

        $sesion->delete();
        return response()->json(['status' => true, 'id' => $id]);
    }

    private function attemptToSync(Sesion $sesion)
    {
        // This means it's not a detail, so we'll jump it if it is
        if($sesion->debe > 0) return;

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
        if(!isset($supposedDate)) return;
        // We have a supposed date inside the Sesion description!
        // Now check parameters inside that "date"
        $exploded = explode('-', $supposedDate);
        foreach ($exploded as $part) {
            if(strlen($part) === 4) $year = $part;
            elseif(strlen($part) === 1 || strlen($part) === 2) $month = $part;
        }
        if(!isset($year) || !isset($month)) return;
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
                            // Everything done! :D now stop running the foreach
                            break;
                        }
                    }
                }
            }
        }
    }
}
