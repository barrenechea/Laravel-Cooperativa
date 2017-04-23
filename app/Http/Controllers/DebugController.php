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
    	$text = [];
    	while (true) {
    		if($date->day == 28 && $date->month == 2)
    			break;
    		$text[] = $date->toDateTimeString();
    		$date->addDay();
    	}
    	$bills = Bill::all();
    	return json_encode($text);
    }
}
