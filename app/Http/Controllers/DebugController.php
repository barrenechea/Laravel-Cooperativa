<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;
use App\Billdetail;
use App\Payment;
use Carbon\Carbon;

class DebugController extends Controller
{
    public function debug(Request $request)
    {
    	$date = Carbon::createFromFormat('Y-m-d', '2016-12-01');
    	$bills = Bill::all();
    	$returnData = [];
    	while (true) {
    		// use this date
    		$bills = Bill::where('payment_day', $date->day)->whereDay('created_at', '<', $date->day)->whereMonth('created_at', '<', $date->month)->whereYear('created_at', '<=', $date->year)->where('active', true)->get();
            if($bills->count()){
            	$returnData[] = $date->toDateTimeString();
            	$returnData[] = $bills;
            }

    		//leave this alone
    		if($date->day == 28 && $date->month == 2)
    			break;
    		$date->addDay();
    	}
    	
    	return json_encode($returnData);
    }
}
