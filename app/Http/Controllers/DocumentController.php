<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::query();

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('year') && $request->year) {
            $query->where('year', $request->year);
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $categories = Document::distinct('category')->pluck('category');
        $years = Document::whereNotNull('year')->distinct('year')->orderBy('year', 'desc')->pluck('year');

        return view('documents.index', compact('documents', 'categories', 'years'));
    }

    public function download(Document $document)
    {
        $document->increment('download_count');
        
        return response()->download(
            storage_path('app/public/' . $document->file_path),
            $document->title . '.' . $document->file_type
        );
    }

    public function gadPlanBudget()
    {
        $documents = Document::where('category', 'GAD Plan and Budget')
            ->orderBy('year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('gad-plan-budget', compact('documents'));
    }
}
