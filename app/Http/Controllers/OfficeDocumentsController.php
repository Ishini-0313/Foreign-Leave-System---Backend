<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ApplicationOfficeDocument;

class OfficeDocumentsController extends Controller{
    public function uploadOfficeDocuments(Request $request,Application $application) {
        $request->validate([
            'documents' => 'required|array',
            'documents.*' => [
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],
        ]);

    $user = auth()->user();

    // Only the Subject Officer assigned to this application
    // can upload office documents.
    if ($application->current_assigned_user_id !== $user->id) {
        return response()->json([
            'message' => 'You are not assigned to this application.'
        ], 403);
    }

    $step = $application->current_step;

    if (!$step || $step->role?->role_name !== 'Subject Officer') {
        return response()->json([
            'message' => 'Only the Subject Officer can upload these documents.'
        ], 403);
    }

    try {
        foreach ($request->file('documents') as $documentType => $file) {

            $path = $file->store(
                'application_office_documents',
                'public'
            );

            ApplicationOfficeDocument::updateOrCreate(
                [
                    'application_id' => $application->id,
                    'document_type' => $documentType,
                ],
                [
                    'uploaded_by' => $user->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                ]
            );
        }

        return response()->json([
            'message' => 'Documents saved successfully.',
        ]);

    } catch (\Exception $e) {

        \Log::error(
            'Office document upload failed',
            [
                'application_id' => $application->id,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]
        );

        return response()->json([
            'message' => 'Failed to save documents.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
