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
use App\Sector;
use App\Location;

class ReportController extends Controller
{
	public function accounting()
	{
		setlocale(LC_TIME, 'es_ES.utf8');
		$first = Sesion::distinct('fecha')->whereDate('fecha', '<', Carbon::now()->startOfMonth())->orderBy('fecha', 'asc')->first();
		$last = Sesion::distinct('fecha')->whereDate('fecha', '<', Carbon::now()->startOfMonth())->orderBy('fecha', 'desc')->first();

		$first = Sesion::distinct('fecha')->orderBy('fecha', 'asc')->first();
		$last = Sesion::distinct('fecha')->orderBy('fecha', 'desc')->first();

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

		$incomes = Sesion::where('tipo', 'I')->whereMonth('fecha', '=', $date->month)->whereYear('fecha', '=', $date->year)->get();
		$outcomes = Sesion::where('tipo', 'E')->whereMonth('fecha', '=', $date->month)->whereYear('fecha', '=', $date->year)->get();
		
		if(!$incomes->count() || !$outcomes->count())
		{
			Session::flash('danger', 'No se pudo generar el informe dado a falta de información contable');
			return redirect()->back();
		}

		$incomes_id = $incomes->pluck('id');
		$payments = Payment::whereIn('vfpsesion_id', $incomes_id)->get();

		$this->addlog('Generó reporte de contabilidad para el período: '. ucfirst($date->formatLocalized('%B %Y')));

		// Generar Excel
		Excel::create('CONTABILIDAD'.$date->format('-m-Y'), function($excel) use ($date, $incomes, $outcomes, $payments) 
		{
			$excel->sheet('INFORMACION', function($sheet) use ($date)
			{
				$sheet->setColumnFormat(array(
						'B' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
						));

				$title = 'Montos estimados de ingresos para el mes: ';
				$title .= ucfirst($date->formatLocalized('%B %Y'));
				$sheet->appendRow([$title]);
				$sheet->mergeCells('A1:H1');
				$sheet->cells('A1:H1', function($cells) {
					$cells->setFontWeight('bold');
				});

				$billdetails = Billdetail::whereMonth('created_at', '=', $date->month)->whereYear('created_at', '=', $date->year)->get();
				$pluckedIds = $billdetails->pluck('location_id');

				$sectors = Sector::all();
				foreach($sectors as $sector)
				{
					$pluckedLocations = $sector->locations->whereIn('id', $pluckedIds)->pluck('id');
					$amount = $billdetails->whereIn('location_id', $pluckedLocations)->sum('amount');
					$row = [$sector->name, $amount];
					$sheet->appendRow($row);
				}
				$sum = '=SUM(B2:B';
				$sum .= $sectors->count()+1;
				$sum .= ')';
				$lastLine = ['Total:', $sum];

				$sheet->appendRow($lastLine);
				$boldArea = 'A';
				$boldArea .= $sectors->count()+2;
				$boldArea .= ':B';
				$boldArea .= $sectors->count()+2;

				$sheet->cells($boldArea, function($cells) {
					$cells->setFontWeight('bold');
				});
			});
			$excel->sheet('INGRESOS', function($sheet) use ($incomes, $payments)
			{
				$sheet->setColumnFormat(array(
						'P' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
						'Q' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
						));
				$sheet->appendRow(['VOUCHER', 'FECHA', 'GLOSA', 'BENEFICIARIO', 'SECTOR', 'TIPO', 'UBICACION', 'LINEA', 'CODIGO', 'CUENTA CONTABLE', 'TIPO DOCUMENTO', 'FECHA FACTURA', 'FACTURA', 'DETALLE', 'DETALLE3', 'DEBE', 'HABER']);

				foreach ($incomes as $income)
				{
					$payment = $payments->where('vfpsesion_id', $income->id)->first();
					if($payment)
					{
						$row = [$income->numero, $income->fecha->format('d-m-Y'), $payment->billdetail->bill->description, $payment->billdetail->partner->user->name, $payment->billdetail->location->sector->name, '', '', '', $payment->billdetail->bill->vfpcode, \App\MaeCue::where('codigo', $income->codigo)->first()->nombre, '', '', $payment->document_id, $income->detalle2, $income->detalle3, $income->debe, $income->haber];
						$sheet->appendRow($row);
					}
					else
					{
						$benefi = \App\Tabaux10::where('kod', $income->detalle3)->first();
						$row = [$income->numero, $income->fecha->format('d-m-Y'), $income->glosa, ($benefi ? $benefi->desc : ''), '', '', '',  $income->linea, $income->codigo, \App\MaeCue::where('codigo', $income->codigo)->first()->nombre, $income->tipdoc, ($income->fechafac->year == 1899 ? '' : $income->fechafac->format('d-m-Y')), ($income->fac != 0 ? $income->fac : ''), $income->detalle2, $income->detalle3, $income->debe, $income->haber];
						$sheet->appendRow($row);
					}
				}
				$debe = 'P';
				$debe .= $incomes->count()+2;
				$sumdebe = '=SUM(P2:P';
				$sumdebe .= $incomes->count()+1;
				$sumdebe .= ')';
				$haber = 'Q';
				$haber .= $incomes->count()+2;
				$sumhaber = '=SUM(Q2:Q';
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
						'R' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
						'S' => '_ $* #,##0_ ;_ $* -#,##0_ ;_ $* "-"_ ;_ @_ ', // Contabilidad
						));
				$sheet->appendRow(['VOUCHER', 'BANCO', 'CUENTA', 'CHEQUE', 'FECHA', 'GLOSA', 'BENEFICIARIO', 'FECHA CHEQUE', 'SECTOR', 'LINEA', 'CODIGO', 'CUENTA CONTABLE', 'TIPO DOCUMENTO', 'FECHA FACTURA', 'FACTURA', 'DETALLE', 'DETALLE3', 'DEBE', 'HABER']);
				$sectors = Sector::pluck('code')->all();
				foreach ($outcomes as $outcome) {
					$splitted = explode(" ", strtoupper($outcome->detalle2));
					$sector = 'General';
			        $match_sector=array_intersect($splitted, $sectors);
			        if(count($match_sector) > 0)
        				$sector = Sector::where('code', $match_sector)->first()->name;
			        
					$row = [$outcome->numero, $outcome->banco, $outcome->cuenta, $outcome->cheque, $outcome->fecha->format('d-m-Y'), $outcome->glosa, $outcome->benefi, $outcome->fechach->format('d-m-Y'), $sector, $outcome->linea, $outcome->codigo, \App\MaeCue::where('codigo', $outcome->codigo)->first()->nombre, $outcome->tipdoc, ($outcome->fechafac->year == 1899 ? '' : $outcome->fechafac->format('d-m-Y')), ($outcome->fac != 0 ? $outcome->fac : ''), $outcome->detalle2, $outcome->detalle3, $outcome->debe, $outcome->haber];
					$sheet->appendRow($row);
				}
				$debe = 'R';
				$debe .= $outcomes->count()+2;
				$sumdebe = '=SUM(R2:R';
				$sumdebe .= $outcomes->count()+1;
				$sumdebe .= ')';
				$haber = 'S';
				$haber .= $outcomes->count()+2;
				$sumhaber = '=SUM(S2:S';
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

		foreach ($logs as $log)
		{
			$dataArray[] = [
			$log->created_at->format('d-m-Y'),
			$log->created_at->format('H:i'),
			$log->user->name,
			$log->message
			];
		}

		Excel::create(('ACTIVIDAD-'.Carbon::now()), function($excel) use ($dataArray)
		{
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
	$ids = [];
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
			if($billdetail->created_at->startOfDay()->diffInDays(Carbon::today()) > $logic->secondoverdue)
			{
				$overdue[] = $billdetail;
				$ids[] = $billdetail->id;
			}
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
		foreach($overdue as $billdetail)
		{
			$dataArray[] = [
					$billdetail->partner->user->name, // Nombre
					$billdetail->location->code, // Cod. Ubicacion
					$billdetail->bill->description, // Descripcion del cobro
					$billdetail->created_at->format('d-m-Y'), // Fecha de emisión del cobro
					$billdetail->created_at->startOfDay()->diffInDays(Carbon::today()), // Dias transcurridos
					$billdetail->amount, // Monto a pagar
					$billdetail->payments()->sum('amount'), // Monto pagado
					$billdetail->partner->phone === ' ' ? 'No llenado' : $billdetail->partner->phone, // Teléfono
					$billdetail->partner->address === ' ' ? 'No llenado' : $billdetail->partner->address //Dirección
				];
			}

			Excel::create(($request->input('report_type') == 1 ? 'DERECHOS' : 'EXCLUSION').Carbon::now()->format('-d-m-Y'), function($excel) use ($dataArray) {
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