<?php

namespace App\Imports;

use App\Models\Staff;
use Exception;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class StaffImport
{
    private $currentOffice = null;
    private $rowsImported = 0;

    /**
     * Parse file and import staff data
     * Supports .xlsx and .csv formats
     */
    public function import($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $rows = match($extension) {
            'csv' => $this->parseCsv($filePath),
            'xlsx' => $this->parseXlsx($filePath),
            default => throw new Exception("Unsupported file format: {$extension}"),
        };

        $this->processRows($rows);
    }

    /**
     * Parse CSV file
     */
    private function parseCsv(string $filePath): array
    {
        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Skip header row
            fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                $rows[] = $row;
            }
            fclose($handle);
        }
        return $rows;
    }

    /**
     * Parse XLSX file using native ZIP + XML
     */
    private function parseXlsx(string $filePath): array
    {
        $rows = [];

        // Check if file exists
        if (!file_exists($filePath)) {
            throw new Exception("File not found: {$filePath}");
        }

        $zip = new ZipArchive();
        $openResult = $zip->open($filePath);
        
        if ($openResult !== true) {
            $errorMsg = match($openResult) {
                ZipArchive::ER_NOZIP => "File is not a valid ZIP archive",
                ZipArchive::ER_INCONS => "Inconsistent ZIP file",
                ZipArchive::ER_CRC => "CRC error in ZIP file",
                default => "Failed to open ZIP file (error code: {$openResult})",
            };
            throw new Exception($errorMsg);
        }

        try {
            // Read shared strings (for string references)
            $strings = [];
            if ($zip->locateName('xl/sharedStrings.xml') !== false) {
                $stringXmlContent = $zip->getFromName('xl/sharedStrings.xml');
                if ($stringXmlContent === false) {
                    throw new Exception("Cannot read shared strings from XLSX");
                }
                $xmlStrings = simplexml_load_string($stringXmlContent);
                if ($xmlStrings === false) {
                    throw new Exception("Invalid XML in sharedStrings.xml");
                }
                foreach ($xmlStrings->si as $si) {
                    $strings[] = (string)$si->t;
                }
            }

            // Read worksheet data
            $worksheetContent = $zip->getFromName('xl/worksheets/sheet1.xml');
            if ($worksheetContent === false) {
                throw new Exception("Cannot read worksheet from XLSX");
            }
            
            $xmlWorksheet = simplexml_load_string($worksheetContent);
            if ($xmlWorksheet === false) {
                throw new Exception("Invalid XML in worksheet");
            }
            
            $rowIndex = 0;

            foreach ($xmlWorksheet->sheetData->row as $xmlRow) {
                $rowIndex++;
                if ($rowIndex === 1) continue; // Skip header

                $cellData = [];

                foreach ($xmlRow->c as $cell) {
                    // Get value
                    if ((string)$cell['t'] === 's') {
                        // String reference
                        $cellData[] = $strings[(int)$cell->v] ?? '';
                    } else {
                        // Direct value
                        $cellData[] = (string)$cell->v ?? '';
                    }
                }

                if (!empty($cellData)) {
                    $rows[] = $cellData;
                }
            }

        } finally {
            $zip->close();
        }

        if (empty($rows)) {
            throw new Exception("No data found in XLSX file");
        }

        return $rows;
    }

    /**
     * Process rows and create staff records
     */
    private function processRows(array $rows): void
    {
        $this->currentOffice = null;
        $this->rowsImported = 0;

        foreach ($rows as $row) {
            $this->processRow($row);
        }
    }

    /**
     * Process single row
     */
    private function processRow(array $row): void
    {
        $no = trim((string)($row[0] ?? ''));
        $name = trim((string)($row[1] ?? ''));
        $position = trim((string)($row[2] ?? ''));
        $gender = trim((string)($row[4] ?? '')); // Gender is at index 4, not 3

        // Debug logging
        Log::debug('Processing row', [
            'no' => $no,
            'name' => $name,
            'position' => $position,
            'gender' => $gender,
            'gender_raw' => var_export($row[4] ?? 'MISSING', true),
            'row_data' => $row,
        ]);

        // If No. is empty, this is an office row
        if (empty($no)) {
            if (!empty($name)) {
                $this->currentOffice = $name;
            }
            return;
        }

        // If No. is numeric, this is a staff row
        if (!empty($name) && $this->currentOffice !== null) {
            $normalizedGender = $this->normalizeGender($gender);

            Log::debug('Creating staff record', [
                'gender_input' => $gender,
                'gender_normalized' => $normalizedGender,
            ]);

            Staff::create([
                'name' => $name,
                'position' => $position,
                'office' => $this->currentOffice,
                'gender' => $normalizedGender,
            ]);

            $this->rowsImported++;
        }
    }

    /**
     * Normalize gender values
     */
    private function normalizeGender(string $gender): string
    {
        $gender = strtolower(trim($gender));
        
        // Handle common variations
        if (in_array($gender, ['m', 'male', 'man', '1'])) {
            return 'Male';
        }
        if (in_array($gender, ['f', 'female', 'woman', 'woman', '2'])) {
            return 'Female';
        }
        
        return 'Other';
    }

    public function getRowsImported(): int
    {
        return $this->rowsImported;
    }
}
