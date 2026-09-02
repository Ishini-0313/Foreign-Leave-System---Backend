<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AnnualForeignLeaveExport;
use Maatwebsite\Excel\Facades\Excel;

class AnnualReportController extends Controller
{
    public function export(Request $request){
        $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:'.now()->year],
        ]);

        $year = (int) $request->year;

        $fileName = 'Foreign_Leave_Annual_Report_'.$year.'.xlsx';

        return Excel::download(
            new AnnualForeignLeaveExport($year),
            $fileName
        );
    }
}
