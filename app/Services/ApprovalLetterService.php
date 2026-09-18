<?php
namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use App\Models\ApprovalLetter;
use App\Models\Application;
use Carbon\Carbon;
use Symfony\Component\Process\Process;

class ApprovalLetterService
{
    public function generate(Application $application): ApprovalLetter{
        // refresh application relationship
        $application->load([
            'applicant',
            'ministry',
            'institute',
        ]);

        // select template according to the leave category
        $templates = [
            'short_trip' =>
                'templates/approval_letters/short_trip.docx',

            'study' =>
                'templates/approval_letters/study.docx',

            'employment' =>
                'templates/approval_letters/employment.docx',

            'study_and_employment' =>
                'templates/approval_letters/study_and_employment.docx',

            'spouse' =>
                'templates/approval_letters/spouse.docx',

            'leave_without_offers' =>
                'templates/approval_letters/leave_without_offers.docx',

            'leave_with_warm_cloths_offer' =>
                'templates/approval_letters/leave_with_warm_cloths_offer.docx',

            'leave_with_additional_offer' =>
                'templates/approval_letters/leave_with_additional_offer.docx',

            'leave_with_warm_cloths_and_additional_offer' =>
                'templates/approval_letters/leave_with_warm_cloths_and_additional_offer.docx',
        ];

        $category = $application->leave_category;

        if (!isset($templates[$category])) {
            throw new \Exception(
                "Approval letter template not found for leave category: {$category}"
            );
        }

        $templatePath = storage_path(
            'app/' . $templates[$category]
        );

        if (!file_exists($templatePath)) {
            throw new \Exception(
                "Template file does not exist: {$templatePath}"
            );
        }

        // load word template
        $templateProcessor = new TemplateProcessor($templatePath);

        // replace placeholders
        $templateProcessor->setValue(
            'date',
            now()->format('Y.m.d')
        );

        $templateProcessor->setValue(
            'name',
            $application->name ?? ""
        );

        $templateProcessor->setValue(
            'designation',
            $application->applicant?->designation?->name ?? ""
        );

        $templateProcessor->setValue(
            'office',
            $application->institute?->name ?? ""
        );

        $templateProcessor->setValue(
            'service',
            $application->service_id ?? ""
        );

        $templateProcessor->setValue(
            'grade',
            $application->class_or_grade ?? ""
        );

        $templateProcessor->setValue(
            'country',
            $application->country ?? ""
        );

        $templateProcessor->setValue(
            'leave_from',
            $this->formatDate($application->leave_start_date)
        );

        $templateProcessor->setValue(
            'leave_to',
            $this->formatDate($application->leave_end_date)
        );

        

        $fileName ='Approval_Letter_' .$application->application_no .'.docx';

        $directory = storage_path(
            'app/generated/approval_letters'
        );

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // file names
        $baseName = 'Approval_Letter_' . $application->application_no;

        $docxFileName = $baseName . '.docx';
        $pdfFileName = $baseName . '.pdf';

        $docxPath = $directory . '/' . $docxFileName;
        $pdfPath = $directory . '/' . $pdfFileName;

        //save word document
        $templateProcessor->saveAs($docxPath);

        //convert docx to pdf
        $this->convertToPdf($docxPath,$directory);

        if (!file_exists($pdfPath)) {
            throw new \Exception(
                'PDF generation failed.'
            );
        }

        // return ApprovalLetter::create([
        //     'application_id' => $application->id,
        //     'file_name' => $fileName,
        //     'file_path' => 'generated/approval_letters/' . $fileName,
        //     'template_name' => $category,
        // ]);

        return ApprovalLetter::create(
            [
                'application_id' => $application->id,
                'file_name' => $fileName,
                'file_path' => 'generated/approval_letters/' . $fileName,
                'pdf_path' => 'generated/approval_letters/' .
                    pathinfo($fileName, PATHINFO_FILENAME) . '.pdf',
                'template_name' => $category,
            ]
        );
    }

    private function formatDate($date){
        if (!$date) {
            return '';
        }
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }

    private function convertToPdf(string $docxPath,string $outputDirectory): string {
        $command = '"C:\Program Files\LibreOffice\program\soffice.exe" '
        . '--headless '
        . '--convert-to pdf '
        . '--outdir "' . $outputDirectory . '" '
        . '"' . $docxPath . '"';

        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            throw new \Exception('Failed to convert approval letter to PDF.');
        }

        return $outputDirectory . '/' .
            pathinfo($docxPath, PATHINFO_FILENAME) . '.pdf';
    }
}