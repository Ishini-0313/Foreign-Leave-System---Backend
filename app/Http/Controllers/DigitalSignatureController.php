<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApprovalLetter;
use App\Services\DigitalSignatureService;


class DigitalSignatureController extends Controller
{
    public function verify(ApprovalLetter $approvalLetter,DigitalSignatureService $digitalSignatureService) {
        $isValid = $digitalSignatureService
            ->verifyApprovalLetter($approvalLetter);

        return response()->json([
            'approval_letter_id' => $approvalLetter->id,
            'signed_by' => $approvalLetter->signed_by,
            'signed_at' => $approvalLetter->digitally_signed_at,
            'algorithm' => $approvalLetter->signature_algorithm,
            'valid' => $isValid,
            'message' => $isValid
                ? 'The approval letter is valid and has not been modified.'
                : 'The signature is invalid or the document was modified.',
        ]);
    }
}
