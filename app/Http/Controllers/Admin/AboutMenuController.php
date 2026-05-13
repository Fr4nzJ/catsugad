<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutMenuController extends Controller
{
    /**
     * Display a listing of all about menus
     */
    public function index()
    {
        $menus = AboutMenu::orderBy('order')->get();
        return view('admin.about-menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new about menu
     */
    public function create()
    {
        return view('admin.about-menus.create');
    }

    /**
     * Store a newly created about menu in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:about_menus,title',
            'route' => 'required|string|max:255|unique:about_menus,route',
            'icon' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        AboutMenu::create($validated);

        return redirect()->route('admin.about-menus.index')
            ->with('success', 'About menu item created successfully!');
    }

    /**
     * Show the form for editing an about menu
     */
    public function edit(AboutMenu $aboutMenu)
    {
        return view('admin.about-menus.edit', compact('aboutMenu'));
    }

    /**
     * Update an about menu in storage
     */
    public function update(Request $request, AboutMenu $aboutMenu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:about_menus,title,' . $aboutMenu->id,
            'route' => 'required|string|max:255|unique:about_menus,route,' . $aboutMenu->id,
            'icon' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $aboutMenu->update($validated);

        return redirect()->route('admin.about-menus.index')
            ->with('success', 'About menu item updated successfully!');
    }

    /**
     * Remove an about menu from storage
     */
    public function destroy(AboutMenu $aboutMenu)
    {
        $aboutMenu->delete();

        return redirect()->route('admin.about-menus.index')
            ->with('success', 'About menu item deleted successfully!');
    }
}
