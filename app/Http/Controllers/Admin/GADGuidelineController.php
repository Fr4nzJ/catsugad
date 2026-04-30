<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GADGuideline;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;

class GADGuidelineController extends Controller
{
    use LogsActivityTrait;

    public function index()
    {
        $guidelines = GADGuideline::orderBy('created_at', 'desc')->paginate(10);
        $categories = ['Memorandum', 'Circular', 'Event Guide', 'Policy', 'Other'];
        
        return view('admin.gad-guidelines.index', compact('guidelines', 'categories'));
    }

    public function create()
    {
        $categories = ['Memorandum', 'Circular', 'Event Guide', 'Policy', 'Other'];
        $currentYear = date('Y');
        
        return view('admin.gad-guidelines.create', compact('categories', 'currentYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:Memorandum,Circular,Event Guide,Policy,Other',
            'release_date' => 'required|date',
            'release_year' => 'required|integer|min:2000|max:2100',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'release_date' => $validated['release_date'],
            'release_year' => $validated['release_year'],
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('gad-guidelines', $filename, 'public');
            $data['file_path'] = 'storage/gad-guidelines/' . $filename;
            $data['file_original_name'] = $file->getClientOriginalName();
        }

        $guideline = GADGuideline::create($data);
        $this->logCreate($guideline, $guideline->title);
        
        return redirect()->route('admin.gad-guidelines.index')
                       ->with('success', 'GAD Guideline created successfully!');
    }

    public function edit(GADGuideline $gadGuideline)
    {
        $categories = ['Memorandum', 'Circular', 'Event Guide', 'Policy', 'Other'];
        
        return view('admin.gad-guidelines.edit', compact('gadGuideline', 'categories'));
    }

    public function update(Request $request, GADGuideline $gadGuideline)
    {
        $oldValues = $gadGuideline->getAttributes();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:Memorandum,Circular,Event Guide,Policy,Other',
            'release_date' => 'required|date',
            'release_year' => 'required|integer|min:2000|max:2100',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'release_date' => $validated['release_date'],
            'release_year' => $validated['release_year'],
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('gad-guidelines', $filename, 'public');
            $data['file_path'] = 'storage/gad-guidelines/' . $filename;
            $data['file_original_name'] = $file->getClientOriginalName();
        }

        $gadGuideline->update($data);
        $this->logUpdate($gadGuideline, $oldValues, $gadGuideline->title);
        
        return redirect()->route('admin.gad-guidelines.index')
                       ->with('success', 'GAD Guideline updated successfully!');
    }

    public function destroy(GADGuideline $gadGuideline)
    {
        $this->logDelete($gadGuideline, $gadGuideline->title);
        $gadGuideline->delete();
        
        return redirect()->route('admin.gad-guidelines.index')
                       ->with('success', 'GAD Guideline deleted successfully!');
    }
}
