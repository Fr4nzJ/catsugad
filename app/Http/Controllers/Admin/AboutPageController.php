<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutPages = AboutPage::orderBy('order')->get();
        return view('admin.about-pages.index', compact('aboutPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.about-pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|unique:about_pages,section_name',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        AboutPage::create($validated);

        return redirect()->route('admin.about-pages.index')->with('success', 'About page section created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutPage $aboutPage)
    {
        return view('admin.about-pages.edit', compact('aboutPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AboutPage $aboutPage)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|unique:about_pages,section_name,' . $aboutPage->id,
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $aboutPage->update($validated);

        return redirect()->route('admin.about-pages.index')->with('success', 'About page section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutPage $aboutPage)
    {
        $aboutPage->delete();
        return redirect()->route('admin.about-pages.index')->with('success', 'About page section deleted successfully.');
    }
}
