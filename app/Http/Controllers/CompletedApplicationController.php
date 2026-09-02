<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedApplicationForm;
use App\Models\Application;

class CompletedApplicationController extends Controller
{
    public function view16(Application $application){
        $form = CompletedApplicationForm::where('application_id',$application->id)->where('form_type','form_16')->first();

        if (!$form) {
            return response()->json([
                'message' =>'Completed application form has not been generated yet.'
            ], 404);
        }

        $path = $form->pdf_file_path;

        if (!file_exists($path)) {
            return response()->json([
                'message' =>
                    'Completed application PDF not found.'
            ], 404);
        }

        return response()->file(
            $path,
            [
                'Content-Type' =>
                    'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="' .
                    $form->pdf_file_name .
                    '"',
            ]
        );
    }

    public function download16(Application $application){
        $form = CompletedApplicationForm::where(
            'application_id',
            $application->id
        )
        ->where(
            'form_type',
            'form_16'
        )
        ->first();

        if (!$form) {
            return response()->json([
                'message' =>
                    'Completed application form has not been generated yet.'
            ], 404);
        }

        $path = $form->pdf_file_path;

        if (!file_exists($path)) {
            return response()->json([
                'message' =>
                    'Completed application PDF not found.'
            ], 404);
        }

        return response()->download(
            $path,
            $form->pdf_file_name,
            [
                'Content-Type' =>
                    'application/pdf'
            ]
        );
    }

    public function view126(Application $application){
        $form = CompletedApplicationForm::where('application_id',$application->id)->where('form_type','form_126')->first();

        if (!$form) {
            return response()->json([
                'message' =>'Completed application form has not been generated yet.'
            ], 404);
        }

        $path = $form->pdf_file_path;

        if (!file_exists($path)) {
            return response()->json([
                'message' =>
                    'Completed application PDF not found.'
            ], 404);
        }

        return response()->file(
            $path,
            [
                'Content-Type' =>
                    'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="' .
                    $form->pdf_file_name .
                    '"',
            ]
        );
    }

    public function download126(Application $application){
        $form = CompletedApplicationForm::where('application_id',$application->id)->where('form_type','form_126')->first();

        if (!$form) {
            return response()->json([
                'message' =>'Completed application form has not been generated yet.'
            ], 404);
        }

        $path = $form->pdf_file_path;

        if (!file_exists($path)) {
            return response()->json([
                'message' =>
                    'Completed application PDF not found.'
            ], 404);
        }

        return response()->download(
            $path,
            $form->pdf_file_name,
            [
                'Content-Type' =>
                    'application/pdf'
            ]
        );
    }
}
