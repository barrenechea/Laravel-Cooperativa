<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Message;
use App\User;
use App\Partner;
use App\Group;
use App\Sector;
use App\Type;
use App\Location;
use Carbon\Carbon;
use App\Sesion;
use App\Expense;
use App\Bill;

use Validator;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        //Last message
    	$lastMsg = Message::latest()->where('has_file', false)->first();

        //Egresos logic
    	setlocale(LC_TIME, 'es_ES.utf8');
    	$expenses = Expense::pluck('vfpcode');
    	$months = array();
    	for ($i=6; $i > 0; $i--) {
    		$name = ucfirst(Carbon::now()->subMonths($i)->formatLocalized('%B %Y'));
    		$start = Carbon::now()->subMonths($i)->startOfMonth();
    		$end = Carbon::now()->subMonths($i)->endOfMonth();

    		$sum = Sesion::whereIn('codigo', $expenses)->whereDate('fecha', '>=', $start)->whereDate('fecha', '<=', $end)->sum('debe');
    		$months[] = ['name' => $name, 'amount' => $sum];
    	}

        //dd($months[0]['name']);

    	if(Auth::user()->is_admin)
    	{
            // Boxes data
    		$sectors = Sector::all()->count();
    		$types = Type::all()->count();
    		$locations = Location::all()->count();
    		$groups = Group::all()->count();
    		$partners = Partner::all()->count();
    		$bills = Bill::all()->count();

    		return view('home', ['msg' => $lastMsg, 'months' => $months, 'groups' => $groups, 'sectors' => $sectors, 'types' => $types, 'locations' => $locations, 'bills' => $bills, 'partners' => $partners]);
    	}

    	return 'Partner';
    }

    public function init()
    {
    	if(Auth::user()->initialized)
    		return redirect('/home');

    	return view('init');
    }

    public function initsave(Request $request)
    {
    	if(Auth::user()->is_admin)
    	{
    		$validator = Validator::make($request->all(), [
    			'name' => 'required|max:255',
    			'password' => 'required|min:6|max:255',
    			]);
    	}
    	else
    	{
    		$validator = Validator::make($request->all(), [
    			'name' => 'required|max:255',
    			'address' => 'required|max:255',
    			'phone' => 'required|max:255',
    			'password' => 'required|min:6|max:255',
    			]);
    	}

    	if ($validator->fails()) {
    		return redirect()->back()
    		->withErrors($validator)
    		->withInput();
    	}

    	Auth::user()->name = $request->input('name');
    	Auth::user()->password = bcrypt($request->input('password'));
        // ToDo include Partner addition
    	Auth::user()->initialized = true;
    	Auth::user()->save();
    	if(!Auth::user()->is_admin)
    	{
    		$partner = Partner::where('user_id', Auth::user()->id)->firstOrFail();
    		$partner->address = $request->input('address');
    		$partner->phone = $request->input('phone');
    	}

    	return redirect('/home');
    }

    public function systemstatus()
    {
    	$path = '/';
    	$total = number_format(disk_total_space($path) / pow(1024, 3), 2);
    	$free = number_format(disk_free_space($path) / pow(1024, 3), 2);
    	$used = $total - $free;
    	$pct = number_format((($used * 100) / $total), 2);
    	
    	return view('system', ['total' => $total, 'free' => $free, 'used' => $used, 'pct' => $pct]);
    }
}