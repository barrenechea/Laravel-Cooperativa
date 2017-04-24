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
