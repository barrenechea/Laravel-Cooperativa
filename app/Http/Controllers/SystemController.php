<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Sector;
use App\Type;
use App\Location;

class SystemController extends Controller
{
    public function index()
    {
    	$sectors = Sector::all();
    	$types = Type::all();
    	$locations = Location::all()->count();
        return view('system\index', ['sectors' => $sectors, 'types' => $types, 'locations' => $locations]);
    }

    public function addsector(Request $request)
    {
    	$sector = new Sector($request->all());
    	$sector->save();

    	Session::flash('success', 'El sector ha sido ingresado exitosamente!');
        return redirect('/system');
    }

    public function addtype(Request $request)
    {
    	$type = new Type($request->all());
    	$type->save();

    	Session::flash('success', 'El tipo ha sido ingresado exitosamente!');
        return redirect('/system');
    }

    public function addlocation(Request $request)
    {
    	$location = new Location($request->all());
    	$location->save();

    	Session::flash('success', 'La ubicación ha sido ingresada exitosamente!');
        return redirect('/system');
    }
}
