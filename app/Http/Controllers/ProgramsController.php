<?php

namespace App\Http\Controllers;

use App\Models\PageBanner;

class ProgramsController extends Controller
{
    public function index()
    {
        $banner = PageBanner::where('page', 'programs')->where('is_active', true)->first();
        return view('programs', compact('banner'));
    }
}
