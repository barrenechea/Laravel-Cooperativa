<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mail\Password;
use App\User;
use App\Role;

class UpdateController extends Controller
{
    public function newpassword($id)
    {
    	if(Auth::user()->id == $id)
    	{
    		Session::flash('warning', '¡No puede alterar su propio perfil desde aquí!');
    		return redirect()->back();
    	}
    	$user = User::where('id', $id)->firstOrFail();
    	$password = str_random(8);
    	$user->password = bcrypt($password);
    	$user->initialized = false;
        $user->save();

        Mail::to($user)->queue(new Password($user, $password, false));

        Session::flash('success', '¡La nueva contraseña ha sido enviada al administrador!');
        return redirect()->back();
    }

    public function data($id)
    {
    	if(Auth::user()->id == $id)
    	{
    		Session::flash('warning', '¡No puede alterar su propio perfil desde aquí!');
    		return redirect()->back();
    	}

    	$user = User::where('id', $id)->firstOrFail();
        $roles = Role::all();
        return view('update.admin.data', ['user' => $user, 'roles' => $roles]);
    }

    public function savedata(Request $request, $id)
    {
    	if(Auth::user()->id == $id)
    	{
    		Session::flash('warning', '¡No puede alterar su propio perfil desde aquí!');
    		return redirect()->back();
    	}

        $user = User::where('id', $id)->firstOrFail();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if($request->input('roles'))
            $user->roles()->sync($request->input('roles'));
        else
            $user->roles()->detach();

        $user->save();

    	Session::flash('success', '¡El perfil ha sido actualizado exitosamente!');
        return redirect('/list/admin');
    }
}
