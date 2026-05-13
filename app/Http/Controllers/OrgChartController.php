<?php

namespace App\Http\Controllers;

use App\Models\GfpsMember;
use App\Services\AnthropicService;
use Illuminate\Support\Facades\Cache;

class OrgChartController extends Controller
{
    /**
     * Display the organizational chart
     */
    public function index()
    {
        $members = GfpsMember::orderBy('sort_order')->get();
        $grouped = $members->groupBy('section');

        // Cache the AI summary for 24 hours
        $summary = Cache::remember('gfps_org_summary', 86400, function () use ($members) {
            $service = app(AnthropicService::class);
            return $service->generateOrgChartSummary($members->toArray());
        });

        return view('public.org-chart', compact('grouped', 'members', 'summary'));
    }
}
