<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapMarker;
use Illuminate\Http\Request;

class MapMarkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $markers = MapMarker::orderBy('created_at', 'desc')->get();
        return view('admin.map-markers.index', compact('markers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.map-markers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
            'page' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        MapMarker::create($validated);

        return redirect()->route('admin.map-markers.index')
            ->with('success', 'Map marker created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(MapMarker $mapMarker)
    {
        return view('admin.map-markers.show', compact('mapMarker'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MapMarker $mapMarker)
    {
        return view('admin.map-markers.edit', compact('mapMarker'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MapMarker $mapMarker)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
            'page' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        $mapMarker->update($validated);

        return redirect()->route('admin.map-markers.index')
            ->with('success', 'Map marker updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MapMarker $mapMarker)
    {
        $mapMarker->delete();

        return redirect()->route('admin.map-markers.index')
            ->with('success', 'Map marker deleted successfully!');
    }
}

