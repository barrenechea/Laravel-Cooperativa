<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Sesion;
use App\Tabaux10;

class RegisterController extends Controller
{
    public function socio()
    {
    	$users = User::pluck('username');

    	$data = Tabaux10::select('kod', 'desc')->distinct('kod')->where('tipo', '<>', 'P')->where('tipo', '<>', 'F')->whereNotIn('kod', $users)->orderBy('desc')->get()->toArray();

        return view('register\socio', ['data' => $data]);
    }

    public function admin()
    {
        return view('register\admin');
    }
}