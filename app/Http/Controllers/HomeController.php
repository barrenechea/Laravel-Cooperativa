<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Message;
use App\User;
use App\Partner;
use App\Group;
use App\Sector;
use App\Type;
use App\Location;
use Carbon\Carbon;
use App\Sesion;
use App\Bill;
use App\Payment;
use App\Mailing;

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
        //Last message
      $lastMsg = Message::latest()->where('has_file', false)->first();

        //Egresos logic
      setlocale(LC_TIME, 'es_ES.utf8');
      $months = array();
      for ($i=6; $i > 0; $i--) {
        $name = ucfirst(Carbon::now()->subMonths($i)->formatLocalized('%B %Y'));
        $start = Carbon::now()->subMonths($i)->startOfMonth();
        $end = Carbon::now()->subMonths($i)->endOfMonth();

        $income = Sesion::where('linea', '1')->where('tipo', 'I')->whereDate('fecha', '>=', $start)->whereDate('fecha', '<=', $end)->sum('debe');
        $income += Payment::whereNull('vfpsesion_id')->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->sum('amount');
        $outcome = Sesion::where('linea', '1')->where('tipo', 'E')->whereDate('fecha', '>=', $start)->whereDate('fecha', '<=', $end)->sum('debe');

        $months[] = ['name' => $name, 'income' => $income, 'outcome' => $outcome];
      }

        //dd($months[0]['name']);

      if(Auth::user()->is_admin)
      {
            // Boxes data
        $sectors = Sector::all()->count();
        $types = Type::all()->count();
        $locations = Location::all()->count();
        $groups = Group::all()->count();
        $partners = Partner::all()->count();
        $bills = Bill::where('active', true)->count();

        return view('home', ['msg' => $lastMsg, 'months' => $months, 'groups' => $groups, 'sectors' => $sectors, 'types' => $types, 'locations' => $locations, 'bills' => $bills, 'partners' => $partners]);
      }

      return 'Partner';
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
  Auth::user()->initialized = true;
  Auth::user()->save();
  if(!Auth::user()->is_admin)
  {
    Auth::user()->partner->address = $request->input('address');
    Auth::user()->partner->phone = $request->input('phone');
    Auth::user()->partner->save();
  }

  return redirect('/home');
}

public function systemstatus()
{
  $admins = 0;
  $mailing = 0;
  if(Auth::user()->can('mail_ssd_warning'))
  {
    $admins = User::where('is_admin', true)->where('id', '<>', 1)->get();
    $mailing = Mailing::where('reason', 1)->get();
  }
  $path = '/';
  $total = number_format(disk_total_space($path) / pow(1024, 3), 2);
  $free = number_format(disk_free_space($path) / pow(1024, 3), 2);
  $used = $total - $free;
  $pct = number_format((($used * 100) / $total), 2);

  $data = ['total' => $total, 'free' => $free, 'used' => $used, 'pct' => $pct];

  $dbengine = DB::connection()->getPdo()->query('select version()')->fetchColumn();
  $dbengine = explode('-', str_replace('-1~xenial', '', $dbengine));
  $dbengine = $dbengine[1] . ' ' .$dbengine[0];
  $webengine = str_replace('/', ' ', ucfirst($_SERVER["SERVER_SOFTWARE"]));

  return view('system', ['data' => $data, 'dbengine' => $dbengine, 'webengine' => $webengine, 'admins' => $admins, 'mailing' => $mailing]);
}

public function updatesystemstatus(Request $request)
{
  $mailing = Mailing::where('reason', 1)->get();
  foreach ($mailing as $mail) {
    $mail->delete();
  }

  foreach ($request->input('admins') as $user_id) {
    $mail = new Mailing;
    $mail->user_id = $user_id;
    $mail->reason = 1;
    $mail->save();
  }

  Session::flash('success', 'Las alertas de almacenamiento se han actualizado exitosamente!');
  return redirect()->back();
}
}