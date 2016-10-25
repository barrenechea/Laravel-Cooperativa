<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Fileentry;
use App\Message;

use Validator;

class FileEntryController extends Controller
{
    public function index()
	{
		return view('fileentries.index');
	}

	public function add(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'message' => 'required|max:255',
            'filefield' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

		$file = $request->file('filefield');
		$extension = $file->getClientOriginalExtension();
		Storage::disk('local')->put($file->getFilename().'.'.$extension, File::get($file));

		$message = new Message();
		$message->user_id = Auth::user()->id;
		$message->message = $request->input('message');
		$message->has_file = true;
		$message->save();

		$entry = new Fileentry();
		$entry->message_id = $message->id;
		$entry->mime = $file->getClientMimeType();
		$entry->original_filename = $file->getClientOriginalName();
		$entry->filename = $file->getFilename().'.'.$extension;
		$entry->save();

		Session::flash('success', 'El archivo ha sido subido exitosamente!');

		return redirect('fileentry');
		
	}

	public function get($filename)
	{
		$entry = Fileentry::where('filename', $filename)->firstOrFail();
		$pathToFile = storage_path().'/app/'.$entry->filename;
		
		return response()->download($pathToFile, $entry->original_filename, ['Content-Type' => $entry->mime]);
	}
}