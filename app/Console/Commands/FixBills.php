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
        $date = Carbon::createFromFormat('Y-m-d', '2016-12-01');

        $dateEstacionamiento = '10-12-2016';
        $dateLoc18 = '02-01-2017';
        $dateLoc26 = '06-02-2017';
        // 6 = Estacionamiento | 33 = Loc 18 | 24 = Loc 18 GC | 46 = Loc 26 | 47 = Loc 26 GC
        $toFixBills = [6,33,34,46,47];

        $bills = Bill::whereIn('id', $toFixBills)->get();
            
            foreach ($bills as $bill)
            {
                if($bill->id == 6){
                    $originalDate = Carbon::createFromFormat('Y-m-d', '2016-12-10');
                    $uf = $this->fetchUFValue($dateEstacionamiento);
                }
                elseif($bill->id == 33){
                    $originalDate = Carbon::createFromFormat('Y-m-d', '2017-01-02');
                    $uf = $this->fetchUFValue($dateLoc18);
                }
                elseif($bill->id == 34){
                    $originalDate = Carbon::createFromFormat('Y-m-d', '2017-01-02');
                    $uf = $this->fetchUFValue($dateLoc18);
                }
                elseif($bill->id == 46){
                    $originalDate = Carbon::createFromFormat('Y-m-d', '2017-02-06');
                    $uf = $this->fetchUFValue($dateLoc26);
                }
                elseif($bill->id == 47){
                    $originalDate = Carbon::createFromFormat('Y-m-d', '2017-02-06');
                    $uf = $this->fetchUFValue($dateLoc26);
                }
                //Logic for Sector Bills
                if($bill->sectors->count())
                {
                    foreach($bill->sectors as $sector)
                    {
                        foreach($sector->locations as $location)
                        {
                            if(!$location->partner_id)
                                continue;
                            if(!($bill->types()->where('id', $location->type->id)->count()))
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
                            $billdetail->created_at = $originalDate;
                            $billdetail->save();
                        }
                    }
                }
                // Logic for Location bills
                if($bill->locations->count())
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
                        $billdetail->created_at = $originalDate;
                        $billdetail->save();
                    }
                }
                // Logic for Group bills
                if($bill->groups->count())
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
                            $billdetail->created_at = $originalDate;
                            $billdetail->save();
                        }
                    }
                }
            }
        

            

        // $billdetails = Billdetail::all();
        // foreach ($billdetails as $billdetail) {
        //     $payments = $billdetail->payments()->get();
        //     if($payments->count() > 1){
        //         $sum = 0;
        //         foreach ($payments as $payment) {
        //             $sum += $payment->amount;
        //         }
        //         $difference = $sum - $billdetail->amount;

        //         if($difference == $billdetail->amount){
        //             foreach ($payments as $payment) {
        //                 if($payment->user_id == null)
        //                     continue;
        //                 echo $payment->id . "\n";
        //                 $payment->delete();
        //                 break;
        //             }
        //         }
        //     }
        // }
    }

    protected function fetchUFValue($date = null)
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
