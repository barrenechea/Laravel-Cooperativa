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
    	$admin = User::where('is_admin', true)->get();
        return view('lists.admin', ['admins' => $admin]);
    }
}
