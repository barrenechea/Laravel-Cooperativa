<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Tabaux10;
use App\Role;
use App\Mail\Password;

use Validator;

class RegisterController extends Controller
{
    public function partner()
    {
    	$users = User::pluck('username');

    	$data = Tabaux10::select('kod', 'desc')->distinct('kod')->where('tipo', '<>', 'P')->where('tipo', '<>', 'F')->whereNotIn('kod', $users)->orderBy('desc')->get()->toArray();

        return view('register.partner', ['data' => $data]);
    }

    public function registerpartner(Request $request)
    {
        // Validar form
        $password = str_random(8);
        $user = new User($request->all());
        $user->is_admin = false;
        $user->password = bcrypt($password);
        $user->save();

        $user->roles()->sync($request->input('roles'));

        Mail::to($user)->queue(new Password($user, $password, true));

        \Session::flash('success', 'La cuenta ha sido ingresada exitosamente!');

        return redirect('/register/partner');
    }

    public function admin()
    {
        $roles = Role::all();

        return view('register.admin', ['roles' => $roles]);
    }

    public function registeradmin(Request $request)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
            'email' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $password = str_random(8);
        $user = new User($request->all());
        $user->is_admin = true;
        $user->password = bcrypt($password);

        $user->save();
        if($request->input('roles'))
            $user->roles()->sync($request->input('roles'));

        Mail::to($user)->queue(new Password($user, $password, true));
        Session::flash('success', 'La cuenta ha sido ingresada exitosamente y se ha enviado un mail al nuevo administrador!');

        return redirect('/register/admin');
    }
}