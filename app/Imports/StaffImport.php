<?php

namespace App\Imports;

use App\Models\Staff;
use Exception;
use Illuminate\Support\Facades\Log;
use OpenSpout\Reader\XLSX\Reader;

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
     * Parse XLSX file using Spout (no ZipArchive dependency)
     */
    private function parseXlsx(string $filePath): array
    {
        $rows = [];

        // Check if file exists
        if (!file_exists($filePath)) {
            throw new Exception("File not found: {$filePath}");
        }

        try {
            $reader = new Reader();
            $reader->open($filePath);

            $isFirstRow = true;

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    // Skip header row
                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }

                    $cells = $row->getCells();
                    $cellData = [];

                    // Convert cells to string values
                    foreach ($cells as $cell) {
                        $cellData[] = (string)($cell->getValue() ?? '');
                    }

                    if (!empty($cellData)) {
                        $rows[] = $cellData;
                    }
                }
            }

            $reader->close();

        } catch (Exception $e) {
            throw new Exception("Failed to parse XLSX file: " . $e->getMessage());
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
