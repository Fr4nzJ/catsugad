<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StaffImport;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffImportController extends Controller
{
    public function index()
    {
        $totalByGender = $this->getTotalByGender();
        $byOfficeAndGender = $this->getByOfficeAndGender();

        return view('admin.staff.import', [
            'totalByGender' => $totalByGender,
            'byOfficeAndGender' => $byOfficeAndGender,
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:5120',
            'truncate' => 'sometimes|boolean',
        ]);

        try {
            if ($request->has('truncate') && $request->boolean('truncate')) {
                Staff::truncate();
            }

            // Ensure temp directory exists
            $tempDir = storage_path('app/temp');
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            // Store uploaded file temporarily
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($tempDir, $fileName);
            $fullPath = $tempDir . DIRECTORY_SEPARATOR . $fileName;

            // Verify file exists before importing
            if (!file_exists($fullPath)) {
                throw new \Exception("Failed to store uploaded file");
            }

            // Import data
            $import = new StaffImport();
            $import->import($fullPath);

            // Clean up
            @unlink($fullPath);

            return redirect()->route('admin.staff.import')
                ->with('success', "Staff data imported successfully ({$import->getRowsImported()} records).");
        } catch (\Exception $e) {
            return redirect()->route('admin.staff.import')
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    /**
     * Get total counts by gender
     */
    public function getTotalByGender(): array
    {
        return [
            'Male' => Staff::where('gender', 'Male')->count(),
            'Female' => Staff::where('gender', 'Female')->count(),
            'Other' => Staff::where('gender', 'Other')->count(),
        ];
    }

    /**
     * Get counts grouped by office and gender
     */
    public function getByOfficeAndGender(): array
    {
        $offices = Staff::distinct('office')->pluck('office')->sort()->values();

        $result = [];

        foreach ($offices as $office) {
            $result[$office] = [
                'Male' => Staff::where('office', $office)->where('gender', 'Male')->count(),
                'Female' => Staff::where('office', $office)->where('gender', 'Female')->count(),
                'Other' => Staff::where('office', $office)->where('gender', 'Other')->count(),
            ];

            $result[$office]['Total'] = array_sum($result[$office]);
        }

        return $result;
    }
}
