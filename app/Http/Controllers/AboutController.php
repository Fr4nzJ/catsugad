<?php

namespace App\Http\Controllers;

use App\Models\AboutMenu;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the about page with all menu sections
     */
    public function index()
    {
        $aboutSections = AboutMenu::where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('about', compact('aboutSections'));
    }

    /**
     * Display a specific about section by route name
     */
    public function show(Request $request)
    {
        // Get the current route name (e.g., 'about.mission-vision')
        $routeName = $request->route()->getName();
        
        $aboutSection = AboutMenu::where('route', $routeName)
            ->where('is_active', true)
            ->firstOrFail();
        
        $aboutSections = AboutMenu::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        return view('about.show', compact('aboutSection', 'aboutSections'));
    }
}
