<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Message;
use App\Fileentry;

class ViewController extends Controller
{
    public function messages()
    {
    	$messages = Message::latest()->where('has_file', false)->get();
        return view('messages.view', ['messages' => $messages]);
    }

    public function files()
    {
    	$messages = Message::latest()->where('has_file', true)->get();
        return view('fileentries.view', ['messages' => $messages]);
    }
}
