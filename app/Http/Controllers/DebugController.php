<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill;
use App\Billdetail;
use App\Payment;

class DebugController extends Controller
{
    public function debug(Request $request)
    {
    	$bills = Bill::all();
    	return json_encode($bills);
    }
}
