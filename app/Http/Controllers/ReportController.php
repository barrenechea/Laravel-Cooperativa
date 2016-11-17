<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        setlocale(LC_TIME, 'es_ES.utf8');
        $first = Sesion::distinct('fecha')->whereDate('fecha', '<', Carbon::now()->startOfMonth())->orderBy('fecha', 'asc')->first();
        $last = Sesion::distinct('fecha')->whereDate('fecha', '<', Carbon::now()->startOfMonth())->orderBy('fecha', 'desc')->first();

        if(!$first || !$last)
        {
            Session::flash('warning', 'El panel aún no se sincroniza con el sistema contable. No se pueden generar reportes contables.');
            return redirect()->back();
        }

        $dates = $this->generateDateRange($first->fecha->startOfMonth(), $last->fecha->startOfMonth());

        return view('reports.accounting', ['dates' => $dates]);
    }

    public function getaccounting(Request $request)
    {
        setlocale(LC_TIME, 'es_ES.utf8');
        $displayMode = $request->input('display_mode');

        $date = Carbon::createFromFormat('Y-m-d', $request->input('month'))->startOfDay();
        $type = $request->input('report_type');
        $payments = Payment::whereNotNull('vfpsesion_id')->pluck('vfpsesion_id');

        //->whereNotIn('id', $payments)
        $incomes = Sesion::where('tipo', 'I')->whereMonth('fecha', '=', $date->month)->whereYear('fecha', '=', $date->year)->get();
        $outcomes = Sesion::where('tipo', 'E')->whereMonth('fecha', '=', $date->month)->whereYear('fecha', '=', $date->year)->get();
        
        if(!$incomes->count() || !$outcomes->count())
        {
            Session::flash('danger', 'No se pudo generar el informe dado a falta de información contable');
            return redirect()->back();
        }

        $this->addlog('Generó reporte de contabilidad para el período: '. ucfirst($date->formatLocalized('%B %Y')));

        if($displayMode == 1)
        {
            // Mostrar en pantalla
            return redirect()->back()->withErrors(['Función \'Desplegar reporte en pantalla\' aún no implementada']);
        }
        elseif($displayMode == 2)
        {
            // Generar Excel
            Excel::create('CONTABILIDAD_'.$date->format('m-Y'), function($excel) use ($incomes, $outcomes) {
                $excel->sheet('INGRESOS', function($sheet) use ($incomes) {
                    $sheet->setColumnFormat(array(
                        'X' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                        'Y' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                        ));
                    $sheet->appendRow(['NUMERO', 'CORREL', 'VA_IFRS', 'CANBCO', 'BANCO', 'CUENTA', 'CHEQUE', 'FECHA', 'GLOSA', 'BENEFI', 'FECHACH', 'AREA', 'LINEA', 'CODIGO', 'TIPDOC', 'FECHAFAC', 'FAC', 'CORRFAC', 'DETALLE1', 'DETALLE2', 'DETALLE3', 'DETALLE4', 'IMP', 'DEBE', 'HABER', 'ESTADO']);
                    foreach ($incomes as $income) {
                        $row = [$income->numero, $income->correl, $income->va_ifrs, $income->canbco, $income->banco, $income->cuenta, $income->cheque, $income->fecha->format('d-m-Y'), $income->glosa, $income->benefi, $income->fechach->format('d-m-Y'), $income->area, $income->linea, $income->codigo, $income->tipdoc, ($income->fechafac->year == 1899 ? '' : $income->fechafac->format('d-m-Y')), $income->fac, $income->corrfac, $income->detalle1, $income->detalle2, $income->detalle3, $income->detalle4, $income->imp, $income->debe, $income->haber, $income->estado];
                        $sheet->appendRow($row);
                    }
                    $debe = 'X';
                    $debe .= $incomes->count()+2;
                    $sumdebe = '=SUM(X2:X';
                    $sumdebe .= $incomes->count()+1;
                    $sumdebe .= ')';
                    $haber = 'Y';
                    $haber .= $incomes->count()+2;
                    $sumhaber = '=SUM(Y2:Y';
                    $sumhaber .= $incomes->count()+1;
                    $sumhaber .= ')';
                    $sheet->setCellValue($debe, $sumdebe);
                    $sheet->setCellValue($haber, $sumhaber);
                    $sheet->cells($debe.':'.$haber, function($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->setAutoFilter();
                    $sheet->setAutoSize(true);
                });
                $excel->sheet('EGRESOS', function($sheet) use ($outcomes) {
                    $sheet->setColumnFormat(array(
                        'X' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                        'Y' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
                        ));
                    $sheet->appendRow(['NUMERO', 'CORREL', 'VA_IFRS', 'CANBCO', 'BANCO', 'CUENTA', 'CHEQUE', 'FECHA', 'GLOSA', 'BENEFI', 'FECHACH', 'AREA', 'LINEA', 'CODIGO', 'TIPDOC', 'FECHAFAC', 'FAC', 'CORRFAC', 'DETALLE1', 'DETALLE2', 'DETALLE3', 'DETALLE4', 'IMP', 'DEBE', 'HABER', 'ESTADO']);
                    foreach ($outcomes as $outcome) {
                        $row = [$outcome->numero, $outcome->correl, $outcome->va_ifrs, $outcome->canbco, $outcome->banco, $outcome->cuenta, $outcome->cheque, $outcome->fecha->format('d-m-Y'), $outcome->glosa, $outcome->benefi, $outcome->fechach->format('d-m-Y'), $outcome->area, $outcome->linea, $outcome->codigo, $outcome->tipdoc, ($outcome->fechafac->year == 1899 ? '' : $outcome->fechafac->format('d-m-Y')), $outcome->fac, $outcome->corrfac, $outcome->detalle1, $outcome->detalle2, $outcome->detalle3, $outcome->detalle4, $outcome->imp, $outcome->debe, $outcome->haber, $outcome->estado];
                        $sheet->appendRow($row);
                    }
                    $debe = 'X';
                    $debe .= $outcomes->count()+2;
                    $sumdebe = '=SUM(X2:X';
                    $sumdebe .= $outcomes->count()+1;
                    $sumdebe .= ')';
                    $haber = 'Y';
                    $haber .= $outcomes->count()+2;
                    $sumhaber = '=SUM(Y2:Y';
                    $sumhaber .= $outcomes->count()+1;
                    $sumhaber .= ')';
                    $sheet->setCellValue($debe, $sumdebe);
                    $sheet->setCellValue($haber, $sumhaber);
                    $sheet->cells($debe.':'.$haber, function($cells) {
                        $cells->setFontWeight('bold');
                    });
                    $sheet->setAutoFilter();
                    $sheet->setAutoSize(true);
                });
            })->download('xlsx');
}
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
}
