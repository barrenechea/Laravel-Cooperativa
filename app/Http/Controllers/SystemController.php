<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Sector;
use App\Type;
use App\Location;
use App\Group;
use App\Percentage;

use Validator;

class SystemController extends Controller
{
    public function base()
    {
    	$sectors = Sector::all();
    	$types = Type::all();
    	$locations = Location::all()->count();
        return view('system\base', ['sectors' => $sectors, 'types' => $types, 'locations' => $locations]);
    }

    public function addsector(Request $request)
    {
    	$sector = new Sector($request->all());
    	$sector->save();

    	Session::flash('success', 'El sector ha sido ingresado exitosamente!');
        return redirect()->back();
    }

    public function addtype(Request $request)
    {
    	$type = new Type($request->all());
    	$type->save();

    	Session::flash('success', 'El tipo ha sido ingresado exitosamente!');
        return redirect()->back();
    }

    public function addlocation(Request $request)
    {
    	$location = new Location($request->all());
    	$location->save();

    	Session::flash('success', 'La ubicación ha sido ingresada exitosamente!');
        return redirect()->back();
    }

    public function group()
    {
        $groups = Group::all()->count();
        $locations = Location::all();
        return view('system\group', ['groups' => $groups, 'locations' => $locations]);
    }

    public function addgroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|max:255',
            'location_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $group = new Group($request->all());
        $locations = $request->input('location_id');

        if($request->input('has_percentage'))
        {
            Session::put('group', $group);
            Session::put('locations', $locations);

            return redirect('system/grouppct');
        }
        else
        {
            $group->save();
            $group->locations()->sync($locations);

            Session::flash('success', 'El grupo ha sido creado exitosamente!');
            return redirect()->back();
        }
    }

    public function grouppct()
    {
        if(!Session::has('group') || !Session::has('locations'))
        {
            return redirect('system/group');
        }

        $locations = Location::whereIn('id', Session::get('locations'))->get();

        return view('system\grouppct', ['locations' => $locations]);
    }

    public function addgrouppct(Request $request)
    {
        $locations = Location::whereIn('id', Session::get('locations'))->get();
        $rules = [];

        foreach ($locations as $location) {
            $rules['pct'.$location->id] = 'required|numeric|min:1|max:100';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $group = Session::get('group');
        $group->save();

        $group->locations()->sync($locations);

        foreach ($locations as $location) {
            $percentage = new Percentage();
            $percentage->group_id = $group->id;
            $percentage->location_id = $location->id;
            $percentage->pct = $request->input('pct'.$location->id);
            $percentage->save();
        }

        Session::forget('locations');
        Session::forget('group');

        Session::flash('success', 'El grupo ha sido creado exitosamente!');
        return redirect('system\group');
    }
}
