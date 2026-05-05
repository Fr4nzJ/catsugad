<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Models\PageBanner;
use App\Models\Chart;
use App\Models\Announcement;
use App\Models\Program;
use App\Models\AccomplishmentReport;
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

        // Fetch latest announcements (3 most recent published)
        $latestAnnouncements = Announcement::where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Fetch latest programs (3 most recent)
        $latestPrograms = Program::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Fetch latest accomplishment reports (3 most recent)
        $latestAccomplishments = AccomplishmentReport::orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('home', compact(
            'statistics', 
            'banner', 
            'growthChart', 
            'distributionChart',
            'latestAnnouncements',
            'latestPrograms',
            'latestAccomplishments'
        ));
    }
}
