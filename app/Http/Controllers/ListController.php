<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Sector;
use App\Type;
use App\Location;
use App\Group;
use App\Percentage;
use App\User;
use App\Partner;
use App\Bill;

class ListController extends Controller
{
    public function listsector()
    {
    	$sectors = Sector::all();
        return view('lists.sector', ['sectors' => $sectors]);
    }

    public function listtype()
    {
    	$types = Type::all();
        return view('lists.type', ['types' => $types]);
    }

    public function listlocation()
    {
    	$locations = Location::all();
        return view('lists.location', ['locations' => $locations]);
    }

    public function listgroup()
    {
    	$groups = Group::all();
        return view('lists.group', ['groups' => $groups]);
    }

    public function listadmin()
    {
        $admins = User::where('is_admin', true)->get();
        return view('lists.admin', ['admins' => $admins]);
    }

    public function listpartner()
    {
        $partners = Partner::all();
        return view('lists.partners', ['partners' => $partners]);
    }

    public function listbill()
    {
        $bills = Bill::all();
        return view('lists.bills', ['bills' => $bills]);
    }
}
