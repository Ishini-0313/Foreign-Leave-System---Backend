<?php

namespace App\Services;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use RuntimeException;

class DocxToPdfService
{
    public function convert(string $docxPath, string $pdfPath): string
    {
        if (!is_file($docxPath)) {
            throw new RuntimeException('Word document not found.');
        }

        $directory = dirname($pdfPath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Configure PHPWord's PDF renderer.
        Settings::setPdfRendererName(Settings::PDF_RENDERER_MPDF);
        Settings::setPdfRendererPath(
            base_path('vendor/mpdf/mpdf')
        );

        // Load the existing Word document.
        $phpWord = IOFactory::load($docxPath);

        // Convert the loaded document to PDF.
        $writer = IOFactory::createWriter($phpWord, 'PDF');
        $writer->save($pdfPath);

        if (!is_file($pdfPath) || filesize($pdfPath) === 0) {
            throw new RuntimeException('PDF conversion failed.');
        }

        return $pdfPath;
    }
}