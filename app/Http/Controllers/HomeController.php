<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\PageBanner;
use App\Models\Chart;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch statistics from database
        $statistics = Statistic::all();
        
        // Fetch main banner for home page
        $banner = PageBanner::where('page', 'home')->where('is_active', true)->first();
        
        // Fetch charts by type
        $growthChart = Chart::where('type', 'growth')->where('is_active', true)->orderBy('order')->get();
        $distributionChart = Chart::where('type', 'distribution')->where('is_active', true)->orderBy('order')->get();

        return view('home', compact('statistics', 'banner', 'growthChart', 'distributionChart'));
    }
}
