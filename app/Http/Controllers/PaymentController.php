<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Payment;
use App\Billdetail;
use App\Location;

class PaymentController extends Controller
{
	public function list($location_id)
	{
		$location = Location::findOrFail($location_id);

		return view('lists.payments', ['location' => $location]);
	}

	public function new($id)
	{
		$billdetail = Billdetail::findOrFail($id);
		if($billdetail->amount === $billdetail->payments->sum('amount'))
		{
			Session::flash('info', 'No puede agregar pagos a cobros que ya han sido pagados');
			return redirect()->back();
		}
		return view('payments.new', ['billdetail' => $billdetail]);
	}

	public function newpost(Request $request)
	{
		$payment = new Payment($request->all());
		$payment->vfpsesion_id = null;
		$payment->save();

		Session::flash('success', 'El pago se ha agregado exitosamente!');
		return redirect('/list/payments/' . $payment->billdetail->location_id);
	}

	public function view($id)
	{
		$payments = Payment::where('billdetail_id', $id)->get();
		if($payments->count() > 0)
			return view('payments.view', ['payments' => $payments]);
		else
		{
			Session::flash('warning', 'No hay detalle disponible para el cobro seleccionado');
			return redirect()->back();
		}
	}

	public function deletedetail($id)
	{
		$billdetail = Billdetail::findOrFail($id);
		$billdetail->delete();
		Session::flash('success', 'Cobro eliminado exitosamente!');
		return redirect()->back();
	}

	public function deletepayment($id)
	{
		$payment = Payment::findOrFail($id);
		$payment->delete();
		Session::flash('success', 'Pago eliminado exitosamente!');
		return redirect()->back();
	}
}
