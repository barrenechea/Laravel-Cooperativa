<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function debug(Request $request)
    {
    	return "debug!";
    }
}
