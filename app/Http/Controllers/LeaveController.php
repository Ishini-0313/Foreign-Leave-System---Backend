<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\available_leave_info;

class LeaveController extends Controller
{
    public function save(Request $request, $id){
        $application = Application::findOrFail($id);

        available_leave_info::updateOrCreate(
            [
                'application_id' => $application->id
            ],
            [
                'vacation_months' => $request->vacation_months,
                'vacation_days' => $request->vacation_days,
                'commuted_halfpay_months' => $request->commuted_halfpay_months,
                'commuted_halfpay_days' => $request->commuted_halfpay_days,
                'halfpay_months' => $request->halfpay_months,
                'halfpay_days' => $request->halfpay_days,
                'nopay_months' => $request->nopay_months,
                'nopay_days' => $request->nopay_days,
                'total_months' => $request->total_months,
                'total_days' => $request->total_days,
                'filled_by' => auth()->id(),
                'filled_at' => now()
            ]
        );

        return response()->json([
            'message' => 'Saved successfully!'
        ]);
    }
}
