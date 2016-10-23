<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        if(Auth::user()->is_admin)
        {
            //todo
        }
        return view('home');
    }

    public function init()
    {
        if(Auth::user()->initialized)
            return redirect('/home');

        return view('init');
    }

    public function initsave(Request $request)
    {
        // ToDo validate form
        Auth::user()->password = bcrypt($request->input('password'));
        // ToDo include Partner addition
        Auth::user()->initialized = true;
        Auth::user()->save();

        return redirect('/home');
    }
}