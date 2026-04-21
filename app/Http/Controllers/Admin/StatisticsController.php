<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $statistics = Statistic::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.statistics.index', compact('statistics'));
    }

    public function create()
    {
        return view('admin.statistics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|string',
            'label' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'required|string|in:blue,green,orange,red',
        ]);

        Statistic::create($validated);
        return redirect()->route('admin.statistics.index')->with('success', 'Statistic created successfully!');
    }

    public function edit(Statistic $statistic)
    {
        return view('admin.statistics.edit', compact('statistic'));
    }

    public function update(Request $request, Statistic $statistic)
    {
        $validated = $request->validate([
            'value' => 'required|string',
            'label' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'color' => 'required|string|in:blue,green,orange,red',
        ]);

        $statistic->update($validated);
        return redirect()->route('admin.statistics.index')->with('success', 'Statistic updated successfully!');
    }

    public function destroy(Statistic $statistic)
    {
        $statistic->delete();
        return redirect()->route('admin.statistics.index')->with('success', 'Statistic deleted successfully!');
    }
}
