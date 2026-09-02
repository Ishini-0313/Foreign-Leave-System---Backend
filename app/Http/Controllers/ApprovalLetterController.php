<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApprovalLetter;
use App\Models\Application;
use Illuminate\Support\Facades\Response;

class ApprovalLetterController extends Controller{
    public function viewApprovalLetter($applicationId) {
        $approvalLetter =ApprovalLetter::where('application_id', $applicationId)->first();

        if (!$approvalLetter) {
            return response()->json([
                'message' =>'Approval letter has not been generated yet.'
            ], 404);
        }

        $path = storage_path('app/' . $approvalLetter->pdf_path);

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

    public function downloadApprovalLetter(Application $application){
        $approvalLetter = ApprovalLetter::where('application_id',$application->id)->first();

        if (!$approvalLetter) {
            return response()->json([
                'message' =>'Approval letter has not been generated yet.'
            ], 404);
        }

        $path = storage_path(
            'app/' . $approvalLetter->pdf_path
        );

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
