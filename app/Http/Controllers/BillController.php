<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\MaeCue;
use App\Bill;
use App\Sector;
use App\Group;
use App\Location;

use Validator;

class BillController extends Controller
{
    public function create()
	{
		$data = MaeCue::distinct('codigo')->orderBy('codigo')->get();

		return view('bills.create.index', ['accounts' => $data]);
	}

	public function createbill(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'description' => 'required|max:255',
            'payment_day' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

		$bill = new Bill($request->all());
		$bill->active = true;
		if($request->input('finish') === null)
		{
			$bill->end_bill = null;
		}

		if($request->input('overdue') === null)
		{
			$bill->overdue_day = null;
			$bill->overdue_amount = null;
			$bill->overdue_is_uf = null;
			$bill->overdue_vfpcode = null;
		}
		Session::put('bill', $bill);

		return redirect('bill/create/' . $request->input('assign'));
	}

	public function createassign($assign)
	{
		if(!Session::has('bill'))
            return redirect('bill/create');

		if($assign === 'sector')
		{
			$sectors = Sector::all();
			return view('bills.create.assign', ['sectors' => $sectors, 'assign' => $assign]);
		}
		elseif ($assign === 'group')
		{
			$groups = Group::all();
			return view('bills.create.assign', ['groups' => $groups, 'assign' => $assign]);
		}
		elseif ($assign === 'location')
		{
			$locations = Location::all();
			return view('bills.create.assign', ['locations' => $locations, 'assign' => $assign]);
		}
		else
			return redirect('bill/create');
	}

	public function createall(Request $request, $assign)
	{
		if(!Session::has('bill'))
            return redirect('bill/create');

		$bill = Session::get('bill');
		$bill->save();

		if($assign === 'sector')
		{
			$sector = Sector::where('id', $request->input('sector_id'))->get();
			$bill->sectors()->sync($sector);
		}
		elseif ($assign === 'group')
		{
			$group = Group::where('id', $request->input('group_id'))->get();
			$bill->groups()->sync($group);
		}
		elseif ($assign === 'location')
		{
			$location = Location::where('id', $request->input('location_id'))->get();
			$bill->locations()->sync($location);
		}
		else
			return redirect('bill/create');

		Session::forget('bill');
		Session::flash('success', '¡El cobro se ha ingresado exitosamente!');

		return redirect('bill/create');
	}
}