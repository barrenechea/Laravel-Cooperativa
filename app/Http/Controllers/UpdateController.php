<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Mail\Password;
use App\Location;
use App\Partner;
use App\User;
use App\Role;

use Validator;

class UpdateController extends Controller
{
    public function profile()
    {
        if(Auth::user()->id === 1)
            return redirect('/home')->withErrors(['No puede modificar esta cuenta!']);
        return view('update.profile');
    }

    public function saveprofile(Request $request)
    {
        if(Auth::user()->id === 1)
            return redirect('/home')->withErrors(['No puede modificar esta cuenta!']);
        
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

    public function newadminpassword($id)
    {
        if($id == 1)
            return redirect('/home')->withErrors(['No puede modificar esta cuenta!']);

        if(Auth::user()->id == $id)
        {
            Session::flash('warning', '¡No puede alterar su propio perfil desde aquí!');
            return redirect()->back();
        }
        $user = User::findOrFail($id);
        $password = str_random(8);
        $user->password = bcrypt($password);
        $user->initialized = false;
        $user->save();

        Mail::to($user)->queue(new Password($user, $password, false));

        Session::flash('success', '¡La nueva contraseña ha sido enviada al administrador!');

        $this->addlog('Generó nueva contraseña para la cuenta de administrador: '.$user->username);

        return redirect()->back();
    }

    public function admindata($id)
    {
        if($id == 1)
            return redirect('/home')->withErrors(['No puede modificar esta cuenta!']);

        if(Auth::user()->id == $id)
        {
            Session::flash('warning', '¡No puede alterar su propio perfil desde aquí!');
            return redirect()->back();
        }

        $user = User::findOrFail($id);
        $roles = Role::where('id', '<>', 1)->get();
        return view('update.admin.data', ['user' => $user, 'roles' => $roles]);
    }

    public function saveadmindata(Request $request, $id)
    {
        if($id == 1)
            return redirect('/home')->withErrors(['No puede modificar esta cuenta!']);

        if(Auth::user()->id == $id)
        {
            Session::flash('warning', '¡No puede alterar su propio perfil desde aquí!');
            return redirect()->back();
        }

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if($request->input('roles'))
        {
            $user->roles()->sync($request->input('roles'));
            $this->addlog('Actualizó los datos y/o permisos de la cuenta de administrador: '.$user->username);
        }
        else
        {
            $user->roles()->detach();
            $this->addlog('Deshabilitó la cuenta de administrador: '.$user->username);
        }

        $user->save();

        Session::flash('success', '¡El perfil ha sido actualizado exitosamente!');

        return redirect('/list/admin');
    }

    public function newpartnerpassword($id)
    {
        $partner = Partner::findOrFail($id);
        $password = str_random(8);
        $partner->user->password = bcrypt($password);
        $partner->user->initialized = false;
        $partner->user->save();

        $user = User::findOrFail($partner->user_id);

        Mail::to($user)->queue(new Password($user, $password, false));

        Session::flash('success', '¡La nueva contraseña ha sido enviada al socio!');

        $this->addlog('Generó nueva contraseña para la cuenta de socio: '.$user->username);

        return redirect()->back();
    }

    public function partnerdata($id)
    {
        $partner = Partner::findOrFail($id);
        $locations = Location::where('partner_id', null)->orWhere('partner_id', $partner->id)->get();
        return view('update.partner.data', ['partner' => $partner, 'locations' => $locations]);
    }

    public function savepartnerdata(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->user->name = $request->input('name');
        $partner->user->email = $request->input('email');
        $partner->user->save();

        $locations = Location::where('partner_id', $partner->id)->get();
        foreach ($locations as $location)
        {
            $location->partner_id = null;
            $location->save();
        }

        if($request->input('locations'))
        {
            $new = Location::whereIn('id', $request->input('locations'))->get();
            foreach ($new as $location)
            {
                $location->partner_id = $partner->id;
                $location->save();
            }
            $this->addlog('Actualizó los datos y/o ubicaciones del socio: '.$partner->user->username);
        }
        else
        {
            $this->addlog('Desvinculó todas las ubicaciones del socio: '.$partner->user->username);
        }

        Session::flash('success', '¡El perfil ha sido actualizado exitosamente!');

        return redirect('/list/partner');
    }
}
