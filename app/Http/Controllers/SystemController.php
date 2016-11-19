<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Sector;
use App\Type;
use App\Location;
use App\Group;
use App\Percentage;
use App\Logic;
use App\Mailing;

use Validator;

class SystemController extends Controller
{
    public function addsector(Request $request)
    {
    	$sector = new Sector($request->all());
    	$sector->save();

    	Session::flash('success', 'El sector ha sido ingresado exitosamente!');

        $this->addlog('Creó nuevo sector: '.$sector->code);

        return redirect()->back();
    }

    public function addtype(Request $request)
    {
    	$type = new Type($request->all());
    	$type->save();

    	Session::flash('success', 'El tipo ha sido ingresado exitosamente!');

        $this->addlog('Creó nuevo tipo: '.$type->name);

        return redirect()->back();
    }

    public function addlocation(Request $request)
    {
    	$location = new Location($request->all());
    	$location->save();

    	Session::flash('success', 'La ubicación ha sido ingresada exitosamente!');

        $this->addlog('Creó nueva ubicación: '.$location->code);

        return redirect()->back();
    }

    public function group()
    {
        $locations = Location::all();
        return view('system.group', ['locations' => $locations]);
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
            Cache::put('group', $group, 5);
            Cache::put('locations', $locations, 5);

            return redirect('system/grouppct');
        }
        else
        {
            $group->save();
            $group->locations()->sync($locations);

            Session::flash('success', 'El grupo ha sido creado exitosamente!');

            $this->addlog('Creó nuevo grupo: '.$group->description);

            return redirect('/list/group');
        }
    }

    public function grouppct()
    {
        if(!Cache::has('group') || !Cache::has('locations'))
        {
            return redirect('system/group');
        }

        $locations = Location::whereIn('id', Cache::get('locations'))->get();

        return view('system.grouppct', ['locations' => $locations]);
    }

    public function addgrouppct(Request $request)
    {
        $locations = Location::whereIn('id', Cache::get('locations'))->get();
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

        $group = Cache::get('group');
        $group->save();

        $group->locations()->sync($locations);

        foreach ($locations as $location) {
            $percentage = new Percentage();
            $percentage->group_id = $group->id;
            $percentage->location_id = $location->id;
            $percentage->pct = $request->input('pct'.$location->id);
            $percentage->save();
        }

        Cache::forget('locations');
        Cache::forget('group');

        Session::flash('success', 'El grupo ha sido creado exitosamente!');

        $this->addlog('Creó nuevo grupo: '.$group->description);

        return redirect('list/group');
    }

    public function updgroup($id)
    {
        $group = Group::findOrFail($id);
        $locations = Location::all();
        return view('system.update.group', ['group' => $group, 'locations' => $locations]);
    }

    public function updategroup(Request $request)
    {
        $group = Group::findOrFail($request->input('id'));
        $group->description = $request->input('description');

        $locations = $request->input('location_id');

        if($request->input('has_percentage'))
        {
            Cache::put('group', $group, 5);
            Cache::put('locations', $locations, 5);

            return redirect('update/grouppct');
        }
        else
        {
            $group->save();
            if($group->percentages()->count())
            {
                foreach ($group->percentages as $percentage) {
                    $percentage->delete();
                }
            }
            $group->locations()->sync($locations);

            Session::flash('success', 'El grupo ha sido actualizado exitosamente!');

            $this->addlog('Modificó grupo: '.$group->description);

            return redirect('list/group');
        }
    }

    public function updgrouppct()
    {
        if(!Cache::has('group') || !Cache::has('locations'))
        {
            return redirect('list/group');
        }

        $locations = Location::whereIn('id', Cache::get('locations'))->get();

        return view('system.update.grouppct', ['locations' => $locations, 'group' => Cache::get('group')]);
    }

    public function updategrouppct(Request $request)
    {
        $locations = Location::whereIn('id', Cache::get('locations'))->get();
        $group = Cache::get('group');
        $group->save();

        $group->locations()->sync($locations);

        foreach ($group->percentages as $percentage) {
            $percentage->delete();
        }

        foreach ($locations as $location) {
            $percentage = new Percentage();
            $percentage->group_id = $group->id;
            $percentage->location_id = $location->id;
            $percentage->pct = $request->input('pct'.$location->id);
            $percentage->save();
        }

        Cache::forget('locations');
        Cache::forget('group');

        Session::flash('success', 'El grupo ha sido actualizado exitosamente!');

        $this->addlog('Modificó grupo: '.$group->description);

        return redirect('list/group');
    }

    public function updateoverduedates(Request $request)
    {
        $logic = Logic::first();
        $logic->firstoverdue = $request->input('firstoverdue');
        $logic->secondoverdue = $request->input('secondoverdue');
        $logic->save();

        Session::flash('success', 'Los días de clasificación han sido actualizados exitosamente!');

        $this->addlog('Modificó días de clasificación para reportes de morosos');

        return redirect()->back();
    }

    public function updatenotifybill(Request $request)
    {
        $logic = Logic::first();
        $logic->endbill_notificationdays = $request->input('days');
        $logic->save();

        $mailings = Mailing::where('reason', 2)->get();
        foreach($mailings as $mailing)
            $mailing->delete();

        foreach($request->input('admins') as $admin)
        {
            $mailing = new Mailing;
            $mailing->user_id = $admin;
            $mailing->reason = 2;
            $mailing->save();
        }

        Session::flash('success', 'Los administradores a notificar han sido actualizados exitosamente!');

        $this->addlog('Modificó administradores que reciben notificaciones de término de cobros');

        return redirect()->back();
    }
}
