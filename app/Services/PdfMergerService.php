<?php

// app/Services/PdfMergerService.php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use ZipArchive;

class PdfMergerService
{
    /**
     * Merge multiple PDF files into one
     * Untuk sekarang, kita buat ZIP file sebagai alternatif
     * Karena merge PDF memerlukan library tambahan
     */
    public function mergePdfs(array $pdfPaths, string $outputPath): string
    {
        // Untuk sementara, kita buat ZIP file yang berisi semua PDF
        // Nanti bisa diganti dengan PDF merger yang sesungguhnya
        return $this->createZipArchive($pdfPaths, $outputPath);
    }

    /**
     * Create ZIP archive containing all PDF files
     */
    private function createZipArchive(array $pdfPaths, string $outputPath): string
    {
        $zipPath = str_replace('.pdf', '.zip', $outputPath);
        $fullZipPath = Storage::path($zipPath);

        // Ensure directory exists
        Storage::makeDirectory(dirname($zipPath));

        $zip = new ZipArchive();

        if ($zip->open($fullZipPath, ZipArchive::CREATE) !== TRUE) {
            throw new \Exception('Tidak bisa membuat file archive');
        }

        foreach ($pdfPaths as $index => $pdfPath) {
            $fullPath = Storage::path($pdfPath);

            if (file_exists($fullPath)) {
                $filename = basename($pdfPath);
                $zip->addFile($fullPath, ($index + 1) . '_' . $filename);
            }
        }

        $zip->close();

        return $zipPath;
    }

    /**
     * Merge PDFs for specific transaction
     */
    public function mergeTransactionPdfs(int $transactionId): string
    {
        $transaction = \App\Models\Transaction::findOrFail($transactionId);

        if (empty($transaction->pdf_files)) {
            throw new \Exception('Tidak ada file PDF untuk digabung');
        }

        $outputFileName = 'merged_' . $transaction->id . '_' . time() . '.zip';
        $outputPath = 'transactions/merged/' . $outputFileName;

        return $this->mergePdfs($transaction->pdf_files, $outputPath);
    }
}
