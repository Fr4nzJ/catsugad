<?php

namespace App\Http\Controllers\Admin;

use App\Models\GfpsMember;
use App\Services\AnthropicService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GfpsMemberController extends Controller
{
    /**
     * Display a listing of the GFPS members.
     */
    public function index()
    {
        $members = GfpsMember::orderBy('section')
            ->orderBy('sort_order')
            ->paginate(50);

        $grouped = $members->groupBy('section');

        return view('admin.gfps-members.index', compact('grouped', 'members'));
    }

    /**
     * Show the form for creating a new GFPS member.
     */
    public function create()
    {
        $sections = GfpsMember::getSections();
        $roles = GfpsMember::getRoles();

        return view('admin.gfps-members.create', compact('sections', 'roles'));
    }

    /**
     * Store a newly created GFPS member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section' => 'required|string|in:' . implode(',', array_keys(GfpsMember::getSections())),
            'sort_order' => 'required|integer|min:0',
            'gfps_position' => 'required|string|max:255',
            'gfps_role' => 'required|string|in:' . implode(',', array_keys(GfpsMember::getRoles())),
            'name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'is_vacant' => 'boolean',
        ]);

        // If name is empty or null, mark as vacant
        if (empty($validated['name'])) {
            $validated['is_vacant'] = true;
        }

        GfpsMember::create($validated);

        return redirect()->route('admin.gfps-members.index')
            ->with('success', 'GFPS member created successfully!');
    }

    /**
     * Show the form for editing the specified GFPS member.
     */
    public function edit(GfpsMember $gfpsMember)
    {
        $sections = GfpsMember::getSections();
        $roles = GfpsMember::getRoles();

        return view('admin.gfps-members.edit', compact('gfpsMember', 'sections', 'roles'));
    }

    /**
     * Update the specified GFPS member in storage.
     */
    public function update(Request $request, GfpsMember $gfpsMember)
    {
        $validated = $request->validate([
            'section' => 'required|string|in:' . implode(',', array_keys(GfpsMember::getSections())),
            'sort_order' => 'required|integer|min:0',
            'gfps_position' => 'required|string|max:255',
            'gfps_role' => 'required|string|in:' . implode(',', array_keys(GfpsMember::getRoles())),
            'name' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
            'is_vacant' => 'boolean',
        ]);

        // If name is empty or null, mark as vacant
        if (empty($validated['name'])) {
            $validated['is_vacant'] = true;
        } else {
            $validated['is_vacant'] = false;
        }

        $gfpsMember->update($validated);

        return redirect()->route('admin.gfps-members.index')
            ->with('success', 'GFPS member updated successfully!');
    }

    /**
     * Remove the specified GFPS member from storage.
     */
    public function destroy(GfpsMember $gfpsMember)
    {
        $gfpsMember->delete();

        return redirect()->route('admin.gfps-members.index')
            ->with('success', 'GFPS member deleted successfully!');
    }

    /**
     * Import GFPS members from an uploaded Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->store('imports');

            // Import logic using simple CSV/Excel parsing
            $this->importFromFile(storage_path('app/' . $path));

            return redirect()->route('admin.gfps-members.index')
                ->with('success', 'GFPS members imported successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.gfps-members.index')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }

    /**
     * Suggest a placeholder or description for a vacant position using AI.
     */
    public function suggestName(GfpsMember $gfpsMember)
    {
        $service = app(AnthropicService::class);
        $suggestion = $service->suggestMemberForPosition(
            $gfpsMember->gfps_position,
            $gfpsMember->gfps_role,
            $gfpsMember->section
        );

        return response()->json(['suggestion' => $suggestion]);
    }

    /**
     * Import GFPS members from file
     */
    private function importFromFile(string $filePath)
    {
        // Determine file type
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($ext === 'csv') {
            $this->importFromCsv($filePath);
        } else {
            // For Excel files, we'll use a simple approach
            $this->importFromExcel($filePath);
        }
    }

    /**
     * Import from CSV file
     */
    private function importFromCsv(string $filePath)
    {
        $file = fopen($filePath, 'r');
        $currentSection = '';
        $sortOrder = 1;

        // Skip header rows (typically 3-4 rows)
        for ($i = 0; $i < 4; $i++) {
            fgetcsv($file);
        }

        GfpsMember::truncate();

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 2 || empty($row[0])) {
                continue;
            }

            // Check if this is a section header (columns B-E are empty, column A has a label)
            if (empty($row[1]) && empty($row[2]) && empty($row[3]) && empty($row[4])) {
                $currentSection = trim($row[0]);
                $sortOrder = 1;
                continue;
            }

            $position = trim($row[0] ?? '');
            $role = trim($row[1] ?? '');
            $name = trim($row[2] ?? '');
            $designation = trim($row[3] ?? '');
            $remarks = trim($row[4] ?? '');

            if (empty($position)) {
                continue;
            }

            // Determine if vacant
            $isVacant = empty($name) || $name === '—';
            $name = ($isVacant) ? null : $name;
            $designation = ($designation === '—') ? null : $designation;

            GfpsMember::create([
                'section' => $currentSection,
                'sort_order' => $sortOrder++,
                'gfps_position' => $position,
                'gfps_role' => $role,
                'name' => $name,
                'designation' => $designation,
                'remarks' => $remarks ?: null,
                'is_vacant' => $isVacant,
            ]);
        }

        fclose($file);
    }

    /**
     * Import from Excel file (simplified approach without Laravel Excel)
     */
    private function importFromExcel(string $filePath)
    {
        // For now, we'll treat Excel like CSV since we don't have Laravel Excel
        // In a production environment, you'd want to properly parse XLSX files
        $this->importFromCsv($filePath);
    }
}
