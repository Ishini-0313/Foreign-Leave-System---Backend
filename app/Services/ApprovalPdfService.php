<?php

namespace App\Services;

use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;
use RuntimeException;

class ApprovalPdfService
{
    public function generate(array $data, string $pdfPath): string
    {
        $fontDirectory = storage_path('app/fonts');

        // Check that both font files exist.
        $regularFont = $fontDirectory . '/Iskpota.ttf';
        $boldFont = $fontDirectory . '/Iskpotab.ttf';

        if (!file_exists($regularFont)) {
            throw new RuntimeException(
                'Iskoola Pota regular font not found: ' . $regularFont
            );
        }

        if (!file_exists($boldFont)) {
            throw new RuntimeException(
                'Iskoola Pota bold font not found: ' . $boldFont
            );
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',

            'margin_left' => 25,
            'margin_right' => 25,
            'margin_top' => 25,
            'margin_bottom' => 25,

            'fontDir' => [
                $fontDirectory,
            ],

            'fontdata' => [
                'iskoolapota' => [
                    'R' => 'Iskpota.ttf',
                    'B' => 'Iskpotab.ttf',
                ],
            ],

            'default_font' => 'iskoolapota',
        ]);

        $html = View::make(
            'approval_letters.leave_without_offer',
            $data
        )->render();

        $mpdf->WriteHTML($html);

        $directory = dirname($pdfPath);

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0755, true) && !is_dir($directory)) {
                throw new RuntimeException(
                    'Unable to create PDF output directory.'
                );
            }
        }

        $mpdf->Output($pdfPath, 'F');

        if (!file_exists($pdfPath) || filesize($pdfPath) === 0) {
            throw new RuntimeException('PDF generation failed.');
        }

        return $pdfPath;
    }
}