<?php

namespace App\Services;

use App\Models\Application;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon\Carbon;
use App\Models\CompletedApplicationForm;

class CompletedApplicationService{
    public function generate_form_16(Application $application): array{
        
        //load of required relationships
        $application->load([
            'applicant',
            'applicant.designation',
            'applicant.office',
            'ministry',
            'institute',
            'previousTravels',
            'goslFunds',
            'workflowHistories.user.office'
        ]);

        //template
        $templatePath = storage_path('app/templates/application_forms/form_16.docx');

        if (!file_exists($templatePath)) {
            throw new \Exception(
                "Application form template not found: {$templatePath}"
            );
        }

        //Create TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);

        //Applicant information
        $templateProcessor->setValue(
            'name',
            $application->name ?? ''
        );

        $templateProcessor->setValue(
            'designation',
            $application->applicant?->designation?->name ?? ''
        );

        $templateProcessor->setValue(
            'service',
            $application->service_id ?? ''
        );

        // dob
        $dob = $application->dob
            ? Carbon::parse($application->dob)
            : null;

        $templateProcessor->setValue(
            'date',
            $dob ? $dob->format('d') : ''
        );

        $templateProcessor->setValue(
            'month',
            $dob ? $dob->format('m') : ''
        );

        $templateProcessor->setValue(
            'year',
            $dob ? $dob->format('Y') : ''
        );

        $templateProcessor->setValue(
            'nic',
            $application->nic ?? ''
        );

        $templateProcessor->setValue(
            'ministry',
            $application->ministry?->name ?? ''
        );

        $templateProcessor->setValue(
            'department',
            $application->institute?->name ?? ''
        );

        $templateProcessor->setValue(
            'arrangement_made_to_cover_duty',
            $application->arrangement_made_to_cover_duty ?? ''
        );

        $templateProcessor->setValue(
            'purpose',
            $application->purpose ?? ''
        );

        $templateProcessor->setValue(
            'awarding_agency',
            $application->awarding_agency ?? ''
        );

        $templateProcessor->setValue(
            'foreign_loan_project_particulars_thereof',
            $application->foreign_loan_project_particulars_thereof ?? ''
        );

        $templateProcessor->setValue(
            'commencement_date_of_trainig',
            $this->formatDate(
                $application->commencement_date_of_trainig
            )
        );

        $templateProcessor->setValue(
            'completion_date_of_trainig',
            $this->formatDate(
                $application->completion_date_of_trainig
            )
        );

        $templateProcessor->setValue(
            'departure_date',
            $this->formatDate(
                $application->departure_date
            )
        );

        $templateProcessor->setValue(
            'return_date',
            $this->formatDate(
                $application->return_date
            )
        );

        $templateProcessor->setValue(
            'country',
            $application->country ?? ''
        );

        $templateProcessor->setValue(
            'foreign_address',
            $application->foreign_address ?? ''
        );

        $templateProcessor->setValue(
            'foreign_phone',
            $application->foreign_phone ?? ''
        );

        $templateProcessor->setValue(
            'foreign_fax',
            $application->foreign_fax ?? ''
        );

        $templateProcessor->setValue(
            'foreign_email',
            $application->foreign_email ?? ''
        );

        $templateProcessor->setValue(
            'has_previous_trip_report_submitted',
            $application->has_previous_trip_report_submitted
                ? 'ඔව්'
                : 'නැත'
        );

        $templateProcessor->setValue(
            'submitted-date',
            $application->created_at
                ? $application->created_at->format('d/m/Y')
                : ''
        );

        //previous travels
        $previousTravels  = $application->previousTravels;

        if($previousTravels->count() > 0){
            $templateProcessor->cloneRow('travel_year',$previousTravels->count());

            foreach ($previousTravels as $index => $travel) {
                $row = $index + 1;

                $templateProcessor->setValue(
                    "travel_year#{$row}",
                    $travel->year ?? ''
                );

                $templateProcessor->setValue(
                    "travel_purpose#{$row}",
                    $travel->purpose ?? ''
                );

                $templateProcessor->setValue(
                    "travel_period#{$row}",
                    $travel->period ?? ''
                );

                $templateProcessor->setValue(
                    "travel_country#{$row}",
                    $travel->country ?? ''
                );
            }
        }else{
            // If there are no previous travels
            $templateProcessor->setValue(
                'travel_year',
                ''
            );

            $templateProcessor->setValue(
                'travel_purpose',
                ''
            );

            $templateProcessor->setValue(
                'travel_period',
                ''
            );

            $templateProcessor->setValue(
                'travel_country',
                ''
            );
        }

        //nature of trip
        $officialMark = '';
        $privateMark = '';

        if ($application->nature_of_trip === 'official') {
            $officialMark = '✓';
        }

        if ($application->nature_of_trip === 'private') {
            $privateMark = '✓';
        }

        $templateProcessor->setValue(
            'official',
            $officialMark
        );

        $templateProcessor->setValue(
            'private',
            $privateMark
        );

        //expences
        $a_mark = '';
        $b_mark = '';
        $c_mark = '';
        $d_mark = '';
        $e_mark = '';

        if ($application->expenses_mainly_to_be_met === 'විදේශ සම්පත් දෙපාර්තමේන්තුව මගින්') {
            $a_mark = '✓';
        }

        if ($application->expenses_mainly_to_be_met === 'ව්‍යාපෘතියකින්') {
            $b_mark = '✓';
        }

        if ($application->expenses_mainly_to_be_met === 'ඍජුව ලැබුණ ප්‍රදානයක්') {
            $c_mark = '✓';
        }

        if ($application->expenses_mainly_to_be_met === 'තමාගේම මුදලක්') {
            $d_mark = '✓';
        }

        if ($application->expenses_mainly_to_be_met === 'ශ්‍රී ලංකා රජයෙන්') {
            $e_mark = '✓';
        }

        $templateProcessor->setValue('a',$a_mark);
        $templateProcessor->setValue('b',$b_mark);
        $templateProcessor->setValue('c',$c_mark);
        $templateProcessor->setValue('d',$d_mark);
        $templateProcessor->setValue('e',$e_mark);

        //gosl
        $goslFunds = $application->goslFunds->first();

        $templateProcessor->setValue(
            'p',
            $goslFunds?->air_travel_amount ?? '0.00'
        );

        $templateProcessor->setValue('q',$goslFunds?->subsistence_amount ?? '0.00');
        $templateProcessor->setValue('r',$goslFunds?->course_fees_amount ?? '0.00');
        $templateProcessor->setValue('s',$goslFunds?->additional_expenses_amount ?? '0.00');
        $templateProcessor->setValue('t',$goslFunds?->other_personal_expenses_amount ?? '0.00');

       
        $signaturePath = storage_path('app/public/' . $application->signature_path);

        if (
            !$application->signature_path ||
            !file_exists($signaturePath)
        ) {
            throw new \Exception(
                'Applicant signature file not found: ' . $signaturePath
            );
        }

        $templateProcessor->setImageValue(
            'signature',
            [
                'path' => $signaturePath,
                'width' => 120,
                'height' => 50,
                'ratio' => true,
            ]
        );

        
        // Recommended Officer
        $recommendedHistory = null;

        //get all recommendation histories
        $recommendations = $application->workflowHistories->filter(
            function ($history){
                $action = strtolower(trim($history->action ?? ''));
                return in_array($action, [
                    'recommended',
                    'recommend',
                    'recommendation',
                ],true);
            }
        )->sortByDesc('created_at')->values();

        //ministry recommendation
        $recommendedHistory = $recommendations->first(
            function ($history) use ($application) {
                return $history->user
                    && $history->user->office
                    && (int) $history->user->office->id === (int) $application->ministry_id;
            }
        );

        //department recommendation
        if (!$recommendedHistory) {
            $recommendedHistory = $recommendations->first(
                function ($history) use ($application) {
                    return $history->user
                        && $history->user->office
                        && (int) $history->user->office->id === (int) $application->institute_id;
                });
        }

        //Recommended date
        $templateProcessor->setValue(
            'recommended-date',
            $recommendedHistory?->created_at
                ? Carbon::parse($recommendedHistory->created_at)->format('d/m/Y')
                : ''
        );

        //recommend officer sign
        if ($recommendedHistory && $recommendedHistory->signature_path) {
            $recommendedSignaturePath = storage_path('app/public/' . $recommendedHistory->signature_path);
            if (file_exists($recommendedSignaturePath)) {
                $templateProcessor->setImageValue(
                    'recommend-officer-sign',
                    [
                        'path' => $recommendedSignaturePath,
                        'width' => 120,
                        'height' => 50,
                        'ratio' => true,
                    ]
                );
            } else {
                $templateProcessor->setValue('recommend-officer-sign','');
            }
        }else{
            $templateProcessor->setValue(
                'recommend-officer-sign',''
            );
        }
        //cheif-sec
        $templateProcessor->setValue(
            'approved-date',
            $application->approved_at
                ? Carbon::parse($application->approved_at)->format('d/m/Y')
                : ''
        );

        $approvedHistory = $application->workflowHistories->where('action', 'Approved')->sortByDesc('created_at')->first();

        $chiefSignaturePath = null;

        if ($approvedHistory?->signature_path) {
            $chiefSignaturePath = storage_path(
                'app/public/' . $approvedHistory->signature_path
            );
        }

        if ($chiefSignaturePath && file_exists($chiefSignaturePath)) {
            $templateProcessor->setImageValue(
                'chief-sec-sign',
                [
                    'path' => $chiefSignaturePath,
                    'width' => 120,
                    'height' => 50,
                    'ratio' => true,
                ]
            );
        } else {
            $templateProcessor->setValue('chief-sec-sign','');
        }

        //Output directory
        $directory = storage_path(
            'app/generated/application_forms'
        );

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        
        //File names
        $baseName ='Form_16_' .$application->application_no;

        $docxFileName = $baseName . '.docx';
        $docxPath = $directory . '/' . $docxFileName;

        //Generate DOCX
        $templateProcessor->saveAs($docxPath);

        
        //Generate PDF
        $pdfFileName = $baseName . '.pdf';
        $pdfPath = $directory . '/' . $pdfFileName;

        $this->convertToPdf(
            $docxPath,
            $directory
        );

        if (!file_exists($pdfPath)) {
            throw new \Exception(
                'PDF conversion failed.'
            );
        }

        CompletedApplicationForm::create([
            'application_id' => $application->id,
            'form_type' => 'form_16',
            'docx_file_name' => $docxFileName,
            'docx_file_path' => $docxPath,
            'pdf_file_name' => $pdfFileName,
            'pdf_file_path' => $pdfPath,
            'generated_at' => now(),
        ]);
 
        //Return generated files
        return [
            'docx' => [
                'file_name' => $docxFileName,
                'file_path' =>
                    'generated/application_forms/' .
                    $docxFileName,
            ],

            'pdf' => [
                'file_name' => $pdfFileName,
                'file_path' =>
                    'generated/application_forms/' .
                    $pdfFileName,
            ],
        ];
    }

    public function generate_form_126(Application $application): array{
        //load of required relationships
        $application->load([
            'applicant',
            'applicant.office',
            'ministry',
            'institute',
            'availableLeaveInfo'
        ]);

        //template
        $templatePath = storage_path('app/templates/application_forms/form_126.docx');

        if (!file_exists($templatePath)) {
            throw new \Exception(
                "Application form template not found: {$templatePath}"
            );
        }

        //Create TemplateProcessor
        $templateProcessor = new TemplateProcessor($templatePath);

        //Applicant information
        $templateProcessor->setValue('department',$application->institute->name ?? '');

        $templateProcessor->setValue('name and designation',$application->name_and_designation ?? '');

        $templateProcessor->setValue('service',$application->service_id ?? '');

        $templateProcessor->setValue('grade',$application->class_or_grade ?? '');

        $templateProcessor->setValue('first_appoinment_date',$application->first_appoinment_date ?? '');

        $templateProcessor->setValue('last_return_date',$application->last_return_date ?? '');
        
        $templateProcessor->setValue('leave_start_date',$application->leave_start_date ?? '');

        $templateProcessor->setValue('leave_end_date',$application->leave_end_date ?? '');

        $templateProcessor->setValue('reason',$application->reason_for_leave ?? '');

        $templateProcessor->setValue('is_travel_on_a_pre_paid_ticket',$application->is_travel_on_a_pre_paid_ticket ?? '');

        $templateProcessor->setValue('relationship_of_the_person_sending_it',$application->relationship_of_the_person_sending_it ?? '');

        $templateProcessor->setValue('cost_maintanence_abroad',$application->cost_maintanence_abroad ?? '');

        $templateProcessor->setValue('relationship_of_person_meeting_expenditure',$application->relationship_of_person_meeting_expenditure ?? '');

        $templateProcessor->setValue('address_when_leave',$application->address_when_leave ?? '');

        $templateProcessor->setValue(
            'submitted-date',
            $application->created_at
                ? $application->created_at->format('d/m/Y')
                : ''
        );

        $signaturePath = storage_path('app/public/' . $application->signature_path);

        if (
            !$application->signature_path ||
            !file_exists($signaturePath)
        ) {
            throw new \Exception(
                'Applicant signature file not found: ' . $signaturePath
            );
        }

        $templateProcessor->setImageValue(
            'signature',
            [
                'path' => $signaturePath,
                'width' => 120,
                'height' => 50,
                'ratio' => true,
            ]
        );

        //available leave info
        $templateProcessor->setValue('vac-m', $application->availableLeaveInfo->vacation_months ?? '');
        $templateProcessor->setValue('vac-d', $application->availableLeaveInfo->vacation_days ?? '');

        $templateProcessor->setValue('com-m', $application->availableLeaveInfo->commuted_halfpay_months ?? '');
        $templateProcessor->setValue('com-d', $application->availableLeaveInfo->commuted_halfpay_days ?? '');

        $templateProcessor->setValue('half-m', $application->availableLeaveInfo->halfpay_months ?? '');
        $templateProcessor->setValue('half-d', $application->availableLeaveInfo->halfpay_days ?? '');

        $templateProcessor->setValue('no-m', $application->availableLeaveInfo->nopay_months ?? '');
        $templateProcessor->setValue('no-d', $application->availableLeaveInfo->nopay_days ?? '');

        $templateProcessor->setValue('sum-m', $application->availableLeaveInfo->total_months ?? '');
        $templateProcessor->setValue('sum-d', $application->availableLeaveInfo->total_days ?? '');

        $templateProcessor->setValue('ministry', $application->ministry->name ?? '');

        $templateProcessor->setValue('name', $application->name ?? '');

        //Output directory
        $directory = storage_path(
            'app/generated/application_forms'
        );

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        
        //File names
        $baseName ='Form_126_' .$application->application_no;

        $docxFileName = $baseName . '.docx';
        $docxPath = $directory . '/' . $docxFileName;

        //Generate DOCX
        $templateProcessor->saveAs($docxPath);

        
        //Generate PDF
        $pdfFileName = $baseName . '.pdf';
        $pdfPath = $directory . '/' . $pdfFileName;

        $this->convertToPdf(
            $docxPath,
            $directory
        );

        if (!file_exists($pdfPath)) {
            throw new \Exception(
                'PDF conversion failed.'
            );
        }

        CompletedApplicationForm::create([
            'application_id' => $application->id,
            'form_type' => 'form_126',
            'docx_file_name' => $docxFileName,
            'docx_file_path' => $docxPath,
            'pdf_file_name' => $pdfFileName,
            'pdf_file_path' => $pdfPath,
            'generated_at' => now(),
        ]);
 
        //Return generated files
        return [
            'docx' => [
                'file_name' => $docxFileName,
                'file_path' =>
                    'generated/application_forms/' .
                    $docxFileName,
            ],

            'pdf' => [
                'file_name' => $pdfFileName,
                'file_path' =>
                    'generated/application_forms/' .
                    $pdfFileName,
            ],
        ];
    }


    
    //Convert DOCX -> PDF using LibreOffice
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


    //format date
    private function formatDate($date): string{
        if (!$date) {
            return '';
        }

        return Carbon::parse($date)->format('d/m/Y');
    }
}