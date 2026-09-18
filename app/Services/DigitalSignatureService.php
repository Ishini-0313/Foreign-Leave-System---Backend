<?php

namespace App\Services;

use App\Models\ApprovalLetter;
use App\Models\User;
use App\Models\Application;
use RuntimeException;
use Illuminate\Support\Facades\Storage;

class DigitalSignatureService{
    private string $privateKeyPath;
    private string $publicKeyPath;

    public function __construct(){
        $this->privateKeyPath = storage_path("app/keys/chief_secretary_private.pem");
        $this->publicKeyPath = storage_path("app/keys/chief_secretary_public.pem");
    }

    public function signApprovalLetter(ApprovalLetter $approvalLetter, User $chiefSecretary) : ApprovalLetter {
        if(!file_exists($this->privateKeyPath)){
            throw new RuntimeException(
                'Chief Secretary private key was not found.'
            );
        }

        if(!file_exists($this->publicKeyPath)){
            throw new RuntimeException(
                'Chief Secretary public key was not found.'
            );
        }

        if (!$approvalLetter->pdf_path) {
            throw new RuntimeException(
                'Approval letter PDF path is missing.'
            );
        }

        $pdfAbsolutePath = Storage::disk('public')->path($approvalLetter->pdf_path);

        if (!file_exists($pdfAbsolutePath)) {
            throw new RuntimeException(
                'Approval letter PDF file was not found.'
            );
        }

        // 1. Calculate SHA-256 hash of the PDF
        $pdfHash = hash_file('sha256', $pdfAbsolutePath);

        if (!$pdfHash) {
            throw new RuntimeException(
                'Unable to calculate approval letter hash.'
            );
        }

        // 2. Load private key
        $privateKeyContent = file_get_contents($this->privateKeyPath);

        $privateKey = openssl_pkey_get_private($privateKeyContent);

        if (!$privateKey) {
            throw new RuntimeException(
                'Unable to load Chief Secretary private key.'
            );
        }

        // 3. Sign PDF hash
        $signature = '';

        $signed = openssl_sign(
            $pdfHash,
            $signature,
            $privateKey,
            OPENSSL_ALGO_SHA256
        );

        if (!$signed) {
            throw new RuntimeException(
                'Unable to digitally sign approval letter.'
            );
        }

        // 4. Store digital-signature information
        $approvalLetter->update([
            'pdf_hash' => $pdfHash,
            'digital_signature' => base64_encode($signature),
            'signature_algorithm' => 'RSA-SHA256',
            'signed_by' => $chiefSecretary->full_name,
            'digitally_signed_at' => now(),
            'public_key_path' => 'keys/chief_secretary_public.pem',
        ]);

        return $approvalLetter->fresh();
    }

    public function verifyApprovalLetter(ApprovalLetter $approvalLetter) : bool {
        if (!$approvalLetter->digital_signature) {
            return false;
        }

        if (!$approvalLetter->pdf_path) {
            return false;
        }

        $pdfAbsolutePath = Storage::disk('public')
            ->path($approvalLetter->pdf_path);

        if (!file_exists($pdfAbsolutePath)) {
            return false;
        }

        //Recalculate current PDF hash
        $currentPdfHash = hash_file(
            'sha256',
            $pdfAbsolutePath
        );

        //Check whether the PDF was modified
        if ($currentPdfHash !== $approvalLetter->pdf_hash) {
            return false;
        }

        //load public key
        $publicKeyAbsolutePath = storage_path(
            'app/' . $approvalLetter->public_key_path
        );

        if (!file_exists($publicKeyAbsolutePath)) {
            return false;
        }

        $publicKeyContent = file_get_contents(
            $publicKeyAbsolutePath
        );

        $publicKey = openssl_pkey_get_public(
            $publicKeyContent
        );

        if (!$publicKey) {
            return false;
        }

        //Verify signature
        return openssl_verify(
            $currentPdfHash,
            base64_decode($approvalLetter->digital_signature),
            $publicKey,
            OPENSSL_ALGO_SHA256
        ) === 1;
    }

    public function getVisibleSignatureText(User $chiefSecretary,Application $application): string {
        return
            'Digitally Signed | Chief Secretary | ' .
            ($chiefSecretary->full_name ?? '') .
            ' | RSA-SHA256 | ' .
            now()->format('Y.m.d H:i');
    }
}