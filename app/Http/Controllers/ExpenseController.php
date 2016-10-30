<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Expense;
use App\MaeCue;

class ExpenseController extends Controller
{
    public function index()
	{
		$maecue = MaeCue::distinct('codigo')->orderBy('codigo')->get();
		$actives = Expense::pluck('vfpcode')->toArray();
		return view('expenses.index', ['cuentas' => $maecue, 'activas' => $actives]);
	}

	public function save(Request $request)
	{
		$actives = Expense::pluck('vfpcode')->toArray();

		// Add new codes
		foreach ($request->input('vfpcode') as $code) {
			if(in_array($code, $actives))
				continue;
			$expense = new Expense;
			$expense->vfpcode = $code;
			$expense->save();
		}

		// Delete removed codes
		foreach ($actives as $active) {
			if(in_array($active, $request->input('vfpcode')))
				continue;
			$delete = Expense::where('vfpcode', $active)->first();
			$delete->delete();
		}

		Session::flash('success', '¡El consolidado ha sido actualizado exitosamente!');
		return redirect()->back();
	}
}
