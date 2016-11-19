<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\Mail;
use App\Mail\StorageWarning;
use App\Mail\EndBillNotification;

use App\Bill;
use App\Billdetail;
use App\Location;
use App\Logic;
use App\Mailing;

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
        // This will send mails if the server is running low on storage
        $schedule->call(function ()
        {
            $logic = Logic::first();

            $path = '/';
            $total = number_format(disk_total_space($path) / pow(1024, 3), 2);
            $free = number_format(disk_free_space($path) / pow(1024, 3), 2);
            $pct = number_format(((($total - $free) * 100) / $total), 2);

            if($pct < 90 && $logic->ssd_warning != 0)
            {
                $logic->ssd_warning = 0;
                $logic->save();
            }
            elseif($pct >= 90 && $logic->ssd_warning == 0)
            {
                $mailings = Mailing::where('reason', 1)->get();
                $mails = [];

                foreach ($mailings as $mailing)
                {
                    if($mailing->user->roles()->count())
                        $mails[] = $mailing->user->email;
                }

                if(count($mails))
                {
                    Mail::to('noresponder@alamedamaipu.cl')
                        ->bcc($mails)
                        ->queue(new StorageWarning());
                }

                $logic->ssd_warning = 1;
                $logic->save();
            }
        })->dailyAt(\App::isLocal() ? Carbon::now()->format('H:i') : '05:30');

        // This will send mails if any bill is about to finish
        $schedule->call(function ()
        {
            $logic = Logic::first();

            $bills = Bill::whereNotNull('end_bill')
            ->where('end_bill_notified', false)
            ->whereDate('end_bill', '<=', Carbon::today()->addDays($logic->endbill_notificationdays)->toDateString())
            ->get();

            $billdescriptions = [];

            foreach($bills as $bill)
            {
                $billdescriptions[] = ['description' => $bill->description, 'end_bill' => $bill->end_bill->copy()];
                $bill->end_bill_notified = true;
                $bill->save();
            }

            if(count($billdescriptions))
            {
                $mailings = Mailing::where('reason', 2)->get();
                $mails = [];

                foreach ($mailings as $mailing)
                {
                    if($mailing->user->roles()->count())
                        $mails[] = $mailing->user->email;
                }

                if(count($mails))
                {
                    Mail::to('noresponder@alamedamaipu.cl')
                        ->bcc($mails)
                        ->queue(new EndBillNotification($billdescriptions));
                }
            }
        })->dailyAt(\App::isLocal() ? Carbon::now()->format('H:i') : '05:35');

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
        })->dailyAt(\App::isLocal() ? Carbon::now()->format('H:i') : '05:45');

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
        })->dailyAt(\App::isLocal() ? Carbon::now()->format('H:i') : '06:00');

        // This will generate Overdue stuff where not daily
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
                            // Overdue only one payment, not daily
                            $newBillDetail = new BillDetail;
                            $newBillDetail->bill_id = $billdetail->bill->id;
                            $newBillDetail->location_id = $billdetail->location_id;
                            $newBillDetail->partner_id = $billdetail->partner_id;
                            $newBillDetail->vfpcode = $billdetail->bill->overdue_vfpcode;
                            if($billdetail->bill->overdue_is_uf)
                            {
                                $uf = $this->fetchUFValue();
                                $amount = $billdetail->bill->overdue_amount * $uf;
                            }
                            else
                                $amount = $billdetail->bill->overdue_amount;
                            $newBillDetail->amount = $amount;
                            $newBillDetail->overdue_date = null;
                            if(isset($billdetail->bill->overdue_is_daily) && $billdetail->bill->overdue_is_daily)
                            {
                                $newBillDetail->overdue_billed = false;
                                $newBillDetail->overdue_is_daily = true;
                            }
                            else
                            {
                                $newBillDetail->overdue_billed = null;
                                $newBillDetail->overdue_is_daily = null;
                            }
                            $newBillDetail->save();
                        }
                    }
                    $billdetail->overdue_billed = true;
                    $billdetail->save();
                }
            }
        })->dailyAt(\App::isLocal() ? Carbon::now()->format('H:i') : '06:15');

        // This will generate Overdue stuff where not daily
        $schedule->call(function ()
        {
            $billdetails = Billdetail::whereNull('overdue_date')
            ->whereNotNull('overdue_billed')
            ->whereNotNull('overdue_is_daily')
            ->where('overdue_billed', false)
            ->where('overdue_is_daily', true)
            ->whereDate('created_at', '<>', Carbon::today()->toDateString())
            ->get();
            if($billdetails->count())
            {
                foreach ($billdetails as $billdetail) {
                    if($billdetail->amount > $billdetail->payments->sum('amount'))
                    {
                        if($billdetail->bill->overdue_is_uf)
                        {
                            $uf = $this->fetchUFValue();
                            $amount = $billdetail->bill->overdue_amount * $uf;
                        }
                        else
                            $amount = $billdetail->bill->overdue_amount;
                        
                        $billdetail->amount += $amount;
                    }
                    else
                        $billdetail->overdue_billed = true;
                    $billdetail->save();
                }
            }
        })->dailyAt(\App::isLocal() ? Carbon::now()->format('H:i') : '06:20');
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
