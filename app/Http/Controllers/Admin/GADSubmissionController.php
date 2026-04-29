<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GADSubmission;
use Illuminate\Http\Request;

class GADSubmissionController extends Controller
{
    public function index()
    {
        $submissions = GADSubmission::orderBy('created_at', 'desc')->paginate(10);
        $statuses = ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected'];
        
        return view('admin.gad-submissions.index', compact('submissions', 'statuses'));
    }

    public function create()
    {
        $statuses = ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected'];
        
        return view('admin.gad-submissions.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'lgu_name' => 'required|string|max:255',
            'fiscal_year' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:Draft,Submitted,Under Review,Approved,Rejected',
            'remarks' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'title' => $validated['title'],
            'lgu_name' => $validated['lgu_name'],
            'fiscal_year' => $validated['fiscal_year'],
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ];

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('gad-submissions', $filename, 'public');
            $data['document_path'] = 'storage/gad-submissions/' . $filename;
            $data['document_original_name'] = $file->getClientOriginalName();
        }

        GADSubmission::create($data);
        
        return redirect()->route('admin.gad-submissions.index')
                       ->with('success', 'GAD Submission created successfully!');
    }

    public function edit(GADSubmission $gadSubmission)
    {
        $statuses = ['Draft', 'Submitted', 'Under Review', 'Approved', 'Rejected'];
        
        return view('admin.gad-submissions.edit', compact('gadSubmission', 'statuses'));
    }

    public function update(Request $request, GADSubmission $gadSubmission)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'lgu_name' => 'required|string|max:255',
            'fiscal_year' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:Draft,Submitted,Under Review,Approved,Rejected',
            'remarks' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $data = [
            'title' => $validated['title'],
            'lgu_name' => $validated['lgu_name'],
            'fiscal_year' => $validated['fiscal_year'],
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ];

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('gad-submissions', $filename, 'public');
            $data['document_path'] = 'storage/gad-submissions/' . $filename;
            $data['document_original_name'] = $file->getClientOriginalName();
        }

        $gadSubmission->update($data);
        
        return redirect()->route('admin.gad-submissions.index')
                       ->with('success', 'GAD Submission updated successfully!');
    }

    public function destroy(GADSubmission $gadSubmission)
    {
        $gadSubmission->delete();
        
        return redirect()->route('admin.gad-submissions.index')
                       ->with('success', 'GAD Submission deleted successfully!');
    }
}
