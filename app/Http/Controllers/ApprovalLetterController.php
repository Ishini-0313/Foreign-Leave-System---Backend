<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApprovalLetter;
use App\Models\Application;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;


class ApprovalLetterController extends Controller{
    public function viewApprovalLetter($application_no) {
        $application = Application::where('application_no', $application_no)->first();
        
        if(!$application){
            return response()->json([
                'message' => 'Application not found.'
            ]);
        }

        $approvalLetter =ApprovalLetter::where('application_id', $application->id)->first();

        if (!$approvalLetter) {
            return response()->json([
                'message' =>'Approval letter has not been generated yet.'
            ], 404);
        }

       // $path = storage_path('app/' . $approvalLetter->pdf_path);

        $path = Storage::disk('public')->path($approvalLetter->pdf_path);

        if (!file_exists($path)) {
            return response()->json([
                'message' =>'Approval letter file not found.'
            ], 404);
        }

        return response()->file(
            $path,
            [
                'Content-Type' =>'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="' .
                    pathinfo($approvalLetter->file_name, PATHINFO_FILENAME) .
                    '.pdf"',
            ]
        );
    }

    public function downloadApprovalLetter($application_no){
        $application = Application::where('application_no', $application_no)->first();

        if(!$application){
            return response()->json([
                'message' => 'Application not found.'
            ]);
        }

        $approvalLetter = ApprovalLetter::where('application_id',$application->id)->first();

        if (!$approvalLetter) {
            return response()->json([
                'message' =>'Approval letter has not been generated yet.'
            ], 404);
        }

        // $path = storage_path(
        //     'app/' . $approvalLetter->pdf_path
        // );

        $path = Storage::disk('public')->path($approvalLetter->pdf_path);


        if (!file_exists($path)) {
            return response()->json([
                'message' =>
                    'Approval letter file not found.'
            ], 404);
        }

        return response()->download(
            $path,
            $approvalLetter->file_name,
            [
                'Content-Type' =>
                    'application/pdf'
            ]
        );
    }
}
