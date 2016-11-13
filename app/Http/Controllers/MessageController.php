<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Message;

use Validator;

class MessageController extends Controller
{
	public function add(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'message' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

		$message = new Message();
		$message->user_id = Auth::user()->id;
		$message->message = $request->input('message');
		$message->has_file = false;
		$message->save();

		Session::flash('success', 'El mensaje ha sido publicado exitosamente!');

		return redirect()->back();
	}

	public function delete($id)
	{
		$message = Message::findOrFail($id);
		if($message->created_at->diffInMinutes(\Carbon\Carbon::now()) > 10)
			return redirect()->back()->withErrors(['Han transcurrido más de 10 minutos desde que envió el mensaje. No se puede eliminar.']);
		
		if($message->has_file)
			return redirect()->back()->withErrors(['No se puede eliminar este tipo de mensaje desde acá.']);

		$message->delete();
		Session::flash('success', 'El mensaje ha sido eliminado exitosamente!');
		return redirect()->back();
	}
}