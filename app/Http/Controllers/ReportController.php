<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;

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
}
