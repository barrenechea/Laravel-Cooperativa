<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Message;
use App\User;
use App\Partner;
use App\Group;
use App\Sector;
use App\Type;
Use App\Location;

use Validator;

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
        $sectors = Sector::all()->count();
        $types = Type::all()->count();
        $locations = Location::all()->count();
        $groups = Group::all()->count();
        $lastMsg = Message::latest()->where('has_file', false)->first();
        $admins = User::where('is_admin', true)->count();
        $partners = Partner::all()->count();

        if(Auth::user()->is_admin)
        {
            //todo
        }
        return view('home', ['msg' => $lastMsg, 'groups' => $groups, 'sectors' => $sectors, 'types' => $types, 'locations' => $locations, 'admins' => $admins, 'partners' => $partners]);
    }

    public function init()
    {
        if(Auth::user()->initialized)
            return redirect('/home');

        return view('init');
    }

    public function initsave(Request $request)
    {

        if(Auth::user()->is_admin)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'password' => 'required|min:6|max:255',
            ]);
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'address' => 'required|max:255',
                'phone' => 'required|max:255',
                'password' => 'required|min:6|max:255',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        Auth::user()->name = $request->input('name');
        Auth::user()->password = bcrypt($request->input('password'));
        // ToDo include Partner addition
        Auth::user()->initialized = true;
        Auth::user()->save();
        if(!Auth::user()->is_admin)
        {
            $partner = Partner::where('user_id', Auth::user()->id)->firstOrFail();
            $partner->address = $request->input('address');
            $partner->phone = $request->input('phone');
        }

        return redirect('/home');
    }
}