<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    use LogsActivityTrait;

    public function index()
    {
        $documents = Document::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $categories = ['GPB (Gender and Development Plan & Budget)', 'Annual Reports', 'Financial Reports', 'GAD Accomplishment Reports', 'Policies & Guidelines', 'Other'];
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240', // 10MB
            'category' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        $data = $validated;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_path'] = $file->store('documents', 'public');
        }

        $document = Document::create($data);
        $this->logCreate($document, $document->title);
        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully!');
    }

    public function edit(Document $document)
    {
        $categories = ['GPB (Gender and Development Plan & Budget)', 'Annual Reports', 'Financial Reports', 'GAD Accomplishment Reports', 'Policies & Guidelines', 'Other'];
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, Document $document)
    {
        $oldValues = $document->getAttributes();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'category' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);

        $data = $validated;

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                \Storage::disk('public')->delete($document->file_path);
            }
            $file = $request->file('file');
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_path'] = $file->store('documents', 'public');
        }

        $document->update($data);
        $this->logUpdate($document, $oldValues, $document->title);
        return redirect()->route('admin.documents.index')->with('success', 'Document updated successfully!');
    }

    public function destroy(Document $document)
    {
        $this->logDelete($document, $document->title);
        if ($document->file_path) {
            \Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Document deleted successfully!');
    }
}
