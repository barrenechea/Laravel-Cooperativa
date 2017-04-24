<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;
use App\Billdetail;
use App\Payment;
use Carbon\Carbon;

class DebugController extends Controller
{
    public function debugMissingBilldetails(Request $request)
    {
    	$date = Carbon::createFromFormat('Y-m-d', '2016-12-01');
    	$returnData = [];
    	while (true) {
    		// use $date HERE
    		$bills = Bill::where('payment_day', $date->day)->whereDate('created_at', '<', $date->toDateString())->get();
            if($bills->count()){
            	foreach ($bills as $bill) {
            		if($bill->end_bill != null && $date->gt($bill->end_bill))
            			continue;
            		
            		$billdetails = $bill->billdetails()->whereMonth('created_at', $date->month)->get();
            		if(!$billdetails->count()){
            			$returnData[] = [$date->toDateString(), ('NOT FOUND FOR ' . $bill->description)];
            		}
            	}
            }

    		//leave this alone
    		if($date->day == Carbon::today()->day && $date->month == Carbon::today()->month)
    			break;
    		$date->addDay();
    	}
    	
    	return json_encode($returnData);
    }

    public function debugDuplicatedPayments(Request $request)
    {
    	$billdetails = Billdetail::all();
    	$returnData = [];
    	foreach ($billdetails as $billdetail) {
    		$payments = $billdetail->payments()->get();
    		if($payments->count() > 1){
    			$sum = 0;
    			foreach ($payments as $payment) {
    				$sum += $payment->amount;
    			}
    			$difference = $sum - $billdetail->amount;

    			if($difference == $billdetail->amount){
    				$returnData[] = [$billdetail->bill->description, $payments];
    			}
    		}
    	}
    	
    	return json_encode($returnData);
    }
}
