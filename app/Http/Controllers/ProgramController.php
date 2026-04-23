<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramsController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::query();
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('program_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Program::distinct('category')->pluck('category');

        return view('programs.index', compact('programs', 'categories'));
    }

    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }
}
