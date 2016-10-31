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
use Validator;

class UpdateController extends Controller
{
    public function profile()
    {
        return view('update.profile');
    }

    public function saveprofile(Request $request)
    {
        if(Auth::user()->is_admin)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|max:255',
                'newpassword' => 'min:6|max:255|confirmed',
            ]);
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|max:255',
                'address' => 'required|max:255',
                'phone' => 'required|max:255',
                'newpassword' => 'min:6|max:255|confirmed',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Auth::user()->name = $request->input('name');
        Auth::user()->email = $request->input('email');

        if(!Auth::user()->is_admin)
        {
            Auth::user()->address = $request->input('address');
            Auth::user()->phone = $request->input('phone');
        }

        if($request->input('newpassword'))
            Auth::user()->password = bcrypt($request->input('newpassword'));

        Auth::user()->save();

        Session::flash('success', '¡Su perfil ha sido actualizado exitosamente!');
        return redirect('/home');
    }

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
