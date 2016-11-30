<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Payment;
use App\Billdetail;
use App\Location;

use Carbon\Carbon;

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

		$payment->created_at = Carbon::createFromFormat('d-m-Y', $request->input('date'));
		$payment->save();

		Session::flash('success', 'El pago se ha agregado exitosamente!');

		$this->addlog('Agregó nuevo pago. ID:'.$payment->id.'. Corresponde a cobro: '.$payment->billdetail->bill->description.' '. $payment->billdetail->created_at->toDateString() .' - '.$payment->billdetail->location->code);

		return redirect('/list/payments/' . $payment->billdetail->location_id);
	}

	public function view($id)
	{
		$payments = Payment::where('billdetail_id', $id)->get();
		if($payments->count() > 0)
			return view('payments.view', ['payments' => $payments]);
		
		Session::flash('warning', 'No hay detalle disponible para el cobro seleccionado');
		return redirect()->back();
	}

	public function deletedetail($id)
	{
		$billdetail = Billdetail::findOrFail($id);
		$billdetail->delete();
		Session::flash('success', 'Cobro eliminado exitosamente!');

		$this->addlog('Eliminó detalle de cobro. Cobro: '.$billdetail->bill->description.' para '.$billdetail->location->code);

		return redirect()->back();
	}

	public function modifydetail($id)
	{
		$billdetail = Billdetail::findOrFail($id);

		return view('payments.modifydetail', ['billdetail' => $billdetail]);
	}

	public function postmodifydetail(Request $request)
	{
		$billdetail = Billdetail::findOrFail($request->input('billdetail_id'));

		$billdetail->fill($request->all());

		$billdetail->save();

		Session::flash('success', 'Monto de cobro modificado exitosamente!');

		$this->addlog('Modificó monto de cobro ya emitido. Cobro: '.$billdetail->bill->description.' para '.$billdetail->location->code.'. Motivo: '.$request->input('reason'));

		return redirect('/list/payments/' . $billdetail->location->id);
	}

	public function deletepayment($id)
	{
		$payment = Payment::findOrFail($id);
		$billdetail = $payment->billdetail;
		$payment->delete();
		Session::flash('success', 'Pago eliminado exitosamente!');

		$this->addlog('Eliminó pago. Corresponde a cobro: '.$payment->billdetail->bill->description.' '. $payment->billdetail->created_at->toDateString().' para '.$payment->billdetail->location->code);
		if($billdetail->payments()->count() == 0)
			return redirect('list/payments/' . $billdetail->location->id);
		return redirect()->back();
	}

	public function modify($id)
	{
		$payment = Payment::findOrFail($id);
		return view('payments.modify', ['payment' => $payment]);
	}

	public function modifypost(Request $request)
	{
		$payment = Payment::findOrFail($request->input('payment_id'));

		$originalAmount = $payment->amount;
		
		$payment->fill($request->all());
		$payment->save();

		Session::flash('success', 'El pago se ha modificado exitosamente!');

		$this->addlog('Modificó pago. Corresponde a cobro: '.$payment->billdetail->bill->description.' '. $payment->billdetail->created_at->toDateString().' para '.$payment->billdetail->location->code.'. Antes: '.$originalAmount.' Ahora: '.$payment->amount);

		return redirect('/list/payments/' . $payment->billdetail->location_id);
	}
}
