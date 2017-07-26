<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Sector;
use App\Type;
use App\Location;
use App\Group;
use App\Percentage;
use App\User;
use App\Partner;
use App\Bill;
use App\Message;
use App\Fileentry;
use App\Mailing;
use App\Logic;
use App\Billdetail;
use App\Payment;

use Carbon\Carbon;
use Excel;

class ListController extends Controller
{
    public function listsector()
    {
    	$sectors = Sector::all();
        return view('lists.sector', ['sectors' => $sectors]);
    }

    public function listtype()
    {
    	$types = Type::all();
        return view('lists.type', ['types' => $types]);
    }

    public function listlocation(Request $request)
    {
        $sectors = Sector::all();
        $types = Type::all();

        if($request->input('sector'))
            $locations = Location::where('sector_id', $request->input('sector'))->get();
        elseif($request->input('type'))
            $locations = Location::where('type_id', $request->input('type'))->get();
        else
            $locations = Location::all();
        return view('lists.location', ['locations' => $locations, 'sectors' => $sectors, 'types' => $types]);
    }

    public function listgroup()
    {
    	$groups = Group::all();
        return view('lists.group', ['groups' => $groups]);
    }

    public function listadmin()
    {
        $admins = User::where('is_admin', true)->where('id', '!=', 1)->get();
        return view('lists.admin', ['admins' => $admins]);
    }

    public function listpartner()
    {
        $partners = Partner::all();
        return view('lists.partners', ['partners' => $partners]);
    }

    public function listbill()
    {
        $bills = Bill::all();
        $admins = 0;
        $mailing = 0;
        $logic_days = 0;
        if(Auth::user()->can('nofify_bill'))
        {
            $admins = User::with('roles')->has('roles')->where('id', '<>', 1)->get();
            $mailing = Mailing::where('reason', 2)->get();
            $logic_days = Logic::first()->endbill_notificationdays;
        }
        return view('lists.bills', ['bills' => $bills, 'admins' => $admins, 'mailing' => $mailing, 'logic_days' => $logic_days]);
    }

    public function listmessage()
    {
        $messages = Message::latest()->where('has_file', false)->get();
        return view('lists.messages', ['messages' => $messages]);
    }

    public function listfile()
    {
        $messages = Message::latest()->where('has_file', true)->get();
        return view('lists.fileentries', ['messages' => $messages]);
    }

    public function partner_mybills()
    {
        if(Auth::user()->is_admin)
            return redirect()->back()->withErrors(['Sólo los socios pueden acceder a esta área!']);

        $billdetails = Auth::user()->partner->billdetails()->orderBy('id', 'desc')->get();
        return view('partner.listbills', ['billdetails' => $billdetails]);
    }

    public function partner_paymentdetails($id)
    {
        $billdetail = Billdetail::find($id);
        return view('partner.paymentdetails', ['billdetail' => $billdetail]);
        
        Session::flash('warning', 'No hay detalle disponible para el cobro seleccionado');
        return redirect()->back();
    }

    public function downloadlist()
    {
        $locations = Location::all();
        $dataArray = [];
        foreach ($locations as $location) {
            $dataArray[] = [$location->sector->name, $location->sector->code, $location->type->name, $location->code, ($location->partner_id ? $location->partner->user->username : ''), ($location->partner_id ? $location->partner->user->name : ''), (($location->partner_id && $location->partner->user->email != 'secretaria@alamedamaipu.cl') ? $location->partner->user->email : '')];
        }
        Excel::create(('UBICACIONES-'.Carbon::today()->format('d-m-Y')), function($excel) use ($dataArray)
        {
            $excel->sheet('Ubicaciones', function($sheet) use ($dataArray) {

                $sheet->appendRow(['Sector', 'Código Sector', 'Tipo', 'Código ubicación', 'RUN Socio', 'Socio', 'E-Mail']);
                foreach ($dataArray as $row)
                    $sheet->appendRow($row);

                $sheet->setAutoFilter();
                $sheet->setAutoSize(true);
            });
        })->download('xlsx');
        
        return;
    }
}
