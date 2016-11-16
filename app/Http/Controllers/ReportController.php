<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Excel;
use App\Log;
use App\Logic;
use App\Billdetail;
use App\Payment;
use Carbon\Carbon;
use App\Sesion;

class ReportController extends Controller
{
    public function accounting()
    {
        $first = Sesion::distinct('fecha')->whereDate('fecha', '<', Carbon::now()->startOfMonth())->orderBy('fecha', 'asc')->first()->fecha->startOfMonth();
        $last = Sesion::distinct('fecha')->whereDate('fecha', '<', Carbon::now()->startOfMonth())->orderBy('fecha', 'desc')->first()->fecha->startOfMonth();

        $dates = $this->generateDateRange($first, $last);

        return view('reports.accounting', ['dates' => $dates]);
    }

    public function getaccounting(Request $request)
    {
        $date = Carbon::createFromFormat('Y-m-d', $request->input('month'))->startOfDay();
        $payments = Payment::whereNotNull('vfpsesion_id')->pluck('vfpsesion_id');
        $objects = Sesion::where('tipo', 'I')->whereNotIn('id', $payments)->where('linea', '<>', 1)->whereDate('fecha', '>=', $date->copy()->startOfMonth())->whereDate('fecha', '<=', $date->copy()->endOfMonth())->orderBy('fecha')->get();
        
        $this->addlog('Generó reporte de contabilidad para el mes: '.$request->input('month'));

        dd($objects);
    }

    public function log()
    {
        $logs = Log::all();

        $this->addlog('Visualizó registro de actividad');

        return view('reports.log', ['logs' => $logs]);
    }

    public function logexport()
    {
        $this->addlog('Exportó registro de actividad');
        $logs = Log::all();
        $dataArray = [];

        foreach ($logs as $log) {
            $dataArray[] = [
            $log->created_at->format('d-m-Y'),
            $log->created_at->format('H:i'),
            $log->user->name,
            $log->message
            ];
        }

        Excel::create(('ACTIVIDAD-'.Carbon::now()), function($excel) use ($dataArray) {
            $excel->sheet('Reg. Actividad', function($sheet) use ($dataArray) {
                $sheet->setColumnFormat(array(
                    'A' => 'dd-mm-yyyy',
                    'B' => 'h:mm',
                    ));
                $sheet->appendRow(['Fecha', 'Hora', 'Administrador', 'Actividad']);
                foreach ($dataArray as $row)
                    $sheet->appendRow($row);

                $sheet->setAutoFilter();
                $sheet->setAutoSize(true);
            });
        })->download('xlsx');
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

        $this->addlog('Generó reporte de morosos - '. ($request->input('report_type') == 1 ? 'Pérdida de derechos' : 'Proceso de exclusión'));

        if($request->input('return_mode') == 1)
        {
            //Desplegar en pantalla
            return view('lists.overdue', ['billdetails' => $overdue]);
        }
        else
        {
            // Generar Excel
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

    private function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];

        for($date = $end_date; $date->gte($start_date); $date->addMonths(-1))
            $dates[] = $date->copy();
        
        return $dates;
    }

    private function addlog($message)
    {
        $log = new Log;
        $log->user_id = Auth::user()->id;
        $log->message = $message;
        $log->save();
    }
}
