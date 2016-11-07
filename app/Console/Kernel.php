<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Bill;
use App\Billdetail;
use App\Location;

use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // This will disable bills that reached their limit cycle
        $schedule->call(function ()
        {
            $bills = Bill::where('payment_day', Carbon::today()->day)->where('active', true)->whereNotNull('end_bill')->get();
            if($bills->count())
            {
                foreach ($bills as $bill)
                {
                    if($bill->end_bill->lte(Carbon::today()))
                    {
                        $bill->active = false;
                        $bill->save();
                    }
                }
            }
        })->dailyAt('01:45');

        // This will generate BillDetail objects on database based on Bills
        $schedule->call(function ()
        {
            $bills = Bill::where('payment_day', Carbon::today()->day)->where('active', true)->get();
            if($bills->count())
                $uf = $this->fetchUFValue();
            
            foreach ($bills as $bill)
            {
                //Logic for Sector Bills
                if($bill->sectors->count())
                {
                    foreach($bill->sectors as $sector)
                    {
                        foreach($sector->locations as $location)
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
                        }
                    }
                }
            }
        })->dailyAt('02:00');
        //})->dailyAt(Carbon::now()->hour . ':' . Carbon::now()->minute);

        // This will generate Overdue stuff
        $schedule->call(function ()
        {
            $billdetails = Billdetail::whereNotNull('overdue_date')
                            ->whereNotNull('overdue_billed')
                            ->where('overdue_date', '<', Carbon::today()->toDateString())
                            ->where('overdue_billed', false)
                            ->get();
            if($billdetails->count())
            {
                foreach ($billdetails as $billdetail) {
                    if($billdetail->amount > $billdetail->payments->sum('amount'))
                    {
                        if(isset($billdetail->bill->overdue_day) && isset($billdetail->bill->overdue_amount) && isset($billdetail->bill->overdue_is_uf))
                        {
                            $newBillDetail = new BillDetail;
                            $newBillDetail->bill_id = $billdetail->bill->id;
                            $newBillDetail->location_id = $billdetail->location_id;
                            $newBillDetail->partner_id = $billdetail->partner_id;
                            if($billdetail->bill->overdue_is_uf)
                            {
                                $uf = $this->fetchUFValue();
                                $amount = $billdetail->bill->overdue_amount * $uf;
                            }
                            else
                                $amount = $billdetail->bill->overdue_amount;
                            $newBillDetail->amount = $amount;
                            $newBillDetail->overdue_date = null;
                            $newBillDetail->overdue_billed = null;
                            // SEGUIR AQUI, VER SI TODO ESTA OK CULIAO
                            echo $amount;
                        }
                    }
                    $billdetail->overdue_billed = true;
                    $billdetail->save();
                    
                }
            }
        })->dailyAt(Carbon::now()->hour . ':' . Carbon::now()->minute);
        //})->dailyAt('02:15');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

    /**
     * Fetch the UF value from mindicador.cl API.
     *
     * @return decimal
     */  
    private function fetchUFValue()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://mindicador.cl/api')->getBody();
        return json_decode($res)->uf->valor;
    }
}
