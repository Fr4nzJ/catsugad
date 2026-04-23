<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        $categories = ['Health & Wellness', 'Education', 'Economic Empowerment', 'Legal & Advocacy', 'Other'];
        return view('admin.programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'description' => 'required|string',
            'target_beneficiaries' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('programs', 'public');
        }

        Program::create($data);
        return redirect()->route('admin.programs.index')->with('success', 'Program created successfully!');
    }

    public function edit(Program $program)
    {
        $categories = ['Health & Wellness', 'Education', 'Economic Empowerment', 'Legal & Advocacy', 'Other'];
        return view('admin.programs.edit', compact('program', 'categories'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'description' => 'required|string',
            'target_beneficiaries' => 'nullable|string',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            if ($program->image_path) {
                \Storage::disk('public')->delete($program->image_path);
            }
            $data['image_path'] = $request->file('image')->store('programs', 'public');
        }

        $program->update($data);
        return redirect()->route('admin.programs.index')->with('success', 'Program updated successfully!');
    }

    public function destroy(Program $program)
    {
        if ($program->image_path) {
            \Storage::disk('public')->delete($program->image_path);
        }
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program deleted successfully!');
    }
}
