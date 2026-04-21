<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chart;
use App\Models\AccomplishmentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{
    public function index()
    {
        $charts = Chart::orderBy('order')->paginate(10);
        return view('admin.charts.index', compact('charts'));
    }

    public function create()
    {
        return view('admin.charts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:growth,distribution',
            'labels' => 'required|json',
            'data' => 'required|json',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        Chart::create($validated);
        return redirect()->route('admin.charts.index')->with('success', 'Chart created successfully');
    }

    public function edit(Chart $chart)
    {
        return view('admin.charts.edit', compact('chart'));
    }

    public function update(Request $request, Chart $chart)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:growth,distribution',
            'labels' => 'required|json',
            'data' => 'required|json',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $chart->update($validated);
        return redirect()->route('admin.charts.index')->with('success', 'Chart updated successfully');
    }

    public function destroy(Chart $chart)
    {
        $chart->delete();
        return redirect()->route('admin.charts.index')->with('success', 'Chart deleted successfully');
    }

    /**
     * Generate grouped gender-college data for charts
     * Returns data in format: { "College": { "male": count, "female": count } }
     */
    public function getGenderCollegeAggregation()
    {
        $data = AccomplishmentReport::select('college', 'gender', DB::raw('SUM(participants_count) as total'))
            ->whereNotNull('college')
            ->whereNotNull('gender')
            ->groupBy('college', 'gender')
            ->orderBy('college')
            ->orderBy('gender')
            ->get();

        // Transform to required format
        $result = [];
        foreach ($data as $row) {
            if (!isset($result[$row->college])) {
                $result[$row->college] = [];
            }
            $result[$row->college][$row->gender] = (int)$row->total;
        }

        return response()->json($result);
    }

    /**
     * Generate chart data for dashboard display
     */
    public function generateAccomplishmentChart()
    {
        $data = $this->getGenderCollegeAggregation();
        
        // This can be used to generate chart data for display
        return $data;
    }
}

