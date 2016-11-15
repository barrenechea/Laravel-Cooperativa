<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Log;
use App\Logic;
use App\Billdetail;
use App\Payment;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $paymentsArray = [];
        $paymentsArray[] = [1, 'nigga', 'asdsad@asd', '20000', Carbon::today()->toDateString()];
        $paymentsArray[] = [2, 'nigga2', 'asdsad@asd', '30000', Carbon::today()->addDays(-1)->toDateString()];

        Excel::create(Carbon::now(), function($excel) use ($paymentsArray) {
            $excel->sheet('Planilla', function($sheet) use ($paymentsArray) {
                $sheet->appendRow(['id', 'customer','email','total','created_at']);
                foreach ($paymentsArray as $row) {
                    $sheet->appendRow($row);
                }
                $sheet->setAutoFilter();
                $sheet->setAutoSize(true);
            });

        })->download('xlsx');
    }

    public function accounting()
    {
        return view('reports.accounting');
    }

    public function getaccounting(Request $request)
    {
    }

    public function log()
    {
        return view('reports.log');
    }

    public function getlog(Request $request)
    {
    }

    public function overdue()
    {
        $logic = Logic::first();
        return view('reports.overdue', ['logic' => $logic]);
    }

    public function getoverdue(Request $request)
    {
        $logic = Logic::first();
        $billdetails = Billdetail::orderBy('partner_id')->get();

        $overdue = [];
        if($request->input('report_type') == 1)
        {
            //Reporte de socios con pérdida de derechos
            foreach ($billdetails as $billdetail)
            {
                if($billdetail->amount <= $billdetail->payments()->sum('amount'))
                    continue;
                if($billdetail->created_at->diffInDays(Carbon::now()) > $logic->firstoverdue && $billdetail->created_at->diffInDays(Carbon::now()) <= $logic->secondoverdue)
                    $overdue[] = $billdetail;
            }
        }
        else
        {
            //Reporte de socios en proceso de exclusión
            foreach ($billdetails as $billdetail)
            {
                if($billdetail->amount <= $billdetail->payments()->sum('amount'))
                    continue;
                if($billdetail->created_at->diffInDays(Carbon::now()) > $logic->secondoverdue)
                    $overdue[] = $billdetail;
            }
        }

        if(count($overdue) === 0)
            return redirect()->back()->withErrors(['No se han encontrado socios morosos para el reporte seleccionado.']);

        if($request->input('return_mode') == 1)
        {
            //Desplegar en pantalla
            return view('lists.overdue', ['billdetails' => $overdue]);
        }
        else
        {
            $dataArray = [];
            foreach($billdetails as $billdetail)
            {
                $dataArray[] = [
                $billdetail->partner->user->name, // Nombre
                $billdetail->location->code, // Cod. Ubicacion
                $billdetail->bill->description, // Descripcion del cobro
                $billdetail->created_at->toDateString(), // Fecha de emisión del cobro
                $billdetail->created_at->diffInDays(Carbon::now()), // Dias transcurridos
                $billdetail->amount, // Monto a pagar
                $billdetail->payments()->sum('amount'), // Monto pagado
                $billdetail->partner->phone === ' ' ? 'No llenado' : $billdetail->partner->phone, // Teléfono
                $billdetail->partner->address === ' ' ? 'No llenado' : $billdetail->partner->address
                ]; //Dirección
            }

            Excel::create(($request->input('report_type') == 1 ? 'DERECHOS' : 'EXCLUSION').'-'.Carbon::now(), function($excel) use ($dataArray) {
                $excel->sheet('Planilla', function($sheet) use ($dataArray) {
                    $sheet->setColumnFormat(array(
                        'F' => '$#,##0',
                        'G' => '$#,##0',
                        ));
                    $sheet->appendRow(['Nombre', 'Ubicación','Cobro','Fecha emisión','Días transcurridos', 'Monto a pagar', 'Monto pagado', 'Teléfono', 'Dirección']);
                    foreach ($dataArray as $row) {
                        $sheet->appendRow($row);
                    }
                    $sheet->setAutoFilter();
                    $sheet->setAutoSize(true);
                });
            })->download('xlsx');
        }
    }
}
