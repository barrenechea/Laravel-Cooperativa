<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
			$bill->overdue_is_daily = null;
		}
		Cache::put('bill', $bill, 5);

		return redirect('bill/create/' . $request->input('assign'));
	}

	public function createassign($assign)
	{
		if(!Cache::has('bill'))
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
		if(!Cache::has('bill'))
			return redirect('bill/create');

		$bill = Cache::get('bill');
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

		Cache::forget('bill');
		Session::flash('success', '¡El cobro se ha ingresado exitosamente!');

		$this->addlog('Creó nuevo cobro: '.$bill->description);

		return redirect('bill/create');
	}

	// --------------

	public function update($id)
	{
		$bill = Bill::findOrFail($id);
		$data = MaeCue::distinct('codigo')->orderBy('codigo')->get();

		return view('bills.update.index', ['bill' => $bill, 'accounts' => $data]);
	}

	public function updatebill(Request $request)
	{
		$bill = Bill::findOrFail($request->input('id'));
		$bill->fill($request->all());

		if($request->input('active') === null)
			$bill->active = false;
		if($request->input('is_uf') === null)
			$bill->is_uf = false;
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
			$bill->overdue_is_daily = null;
		}
		else
		{
			if($request->input('overdue_is_uf') === null)
				$bill->overdue_is_uf = false;
			if($request->input('overdue_is_daily') === null)
				$bill->overdue_is_daily = false;
		}

		$bill->end_bill_notified = false;
		
		Cache::put('bill', $bill, 5);

		return redirect('bill/updateassign/' . $request->input('assign'));
	}

	public function updateassign($assign)
	{
		if(!Cache::has('bill'))
			return redirect('list/bills');

		$bill = Cache::get('bill');

		if($assign === 'sector')
		{
			$sectors = Sector::all();
			return view('bills.update.assign', ['bill' => $bill, 'sectors' => $sectors, 'assign' => $assign]);
		}
		elseif ($assign === 'group')
		{
			$groups = Group::all();
			return view('bills.update.assign', ['bill' => $bill, 'groups' => $groups, 'assign' => $assign]);
		}
		elseif ($assign === 'location')
		{
			$locations = Location::all();
			return view('bills.update.assign', ['bill' => $bill, 'locations' => $locations, 'assign' => $assign]);
		}
		else
			return redirect('list/bills');
	}

	public function updateall(Request $request, $assign)
	{
		if(!Cache::has('bill'))
			return redirect('list/bills');

		$bill = Cache::get('bill');
		$bill->save();

		$reason = $request->input('reason');

		$bill->sectors()->detach();
		$bill->groups()->detach();
		$bill->locations()->detach();

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
			return redirect('list/bills');

		Cache::forget('bill');
		Session::flash('success', '¡El cobro se ha actualizado exitosamente!');

		$this->addlog('Actualizó cobro: '.$bill->description.'. Motivo: '.$reason);

		return redirect('list/bills');
	}
}