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
    public function addindex()
	{
		return view('messages.addindex');
	}

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
}