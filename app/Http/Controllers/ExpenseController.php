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
		$cuentas = MaeCue::distinct('codigo')->orderBy('codigo')->get();
		$activas = Expense::pluck('vfpcode')->toArray();
		return view('expenses.index', ['cuentas' => $cuentas, 'activas' => $activas]);
	}

	public function save(Request $request)
	{
		Expense::getQuery()->delete();
		foreach ($request->input('vfpcode') as $code) {
			$expense = new Expense;
			$expense->vfpcode = $code;
			$expense->save();
		}

		Session::flash('success', '¡El consolidado ha sido actualizado exitosamente!');
		return redirect()->back();
	}
}
