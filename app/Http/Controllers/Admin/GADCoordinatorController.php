<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGADCoordinatorRequest;
use App\Models\College;
use App\Models\GADCoordinator;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;

class GADCoordinatorController extends Controller
{
    use LogsActivityTrait;

    /**
     * Display a listing of GAD Coordinators
     */
    public function index()
    {
        $coordinators = GADCoordinator::with('college')
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(15);

        return view('admin.gad-coordinators.index', compact('coordinators'));
    }

    /**
     * Show the form for creating a new GAD Coordinator
     */
    public function create()
    {
        $colleges = College::orderBy('name')->get();
        $assignedColleges = GADCoordinator::pluck('college_id')->toArray();

        return view('admin.gad-coordinators.create', compact('colleges', 'assignedColleges'));
    }

    /**
     * Store a newly created GAD Coordinator in storage
     */
    public function store(StoreGADCoordinatorRequest $request)
    {
        $validated = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('gad-coordinators', 'public');
        }

        $coordinator = GADCoordinator::create($validated);

        $college = College::find($validated['college_id']);
        $this->logCreate($coordinator, "GAD Coordinator: {$coordinator->name} ({$college->name})");

        return redirect()->route('admin.gad-coordinators.index')
                       ->with('success', "GAD Coordinator '{$coordinator->name}' created successfully!");
    }

    /**
     * Show the form for editing a GAD Coordinator
     */
    public function edit(GADCoordinator $gadCoordinator)
    {
        $colleges = College::orderBy('name')->get();
        $assignedColleges = GADCoordinator::where('id', '!=', $gadCoordinator->id)
                                         ->pluck('college_id')
                                         ->toArray();

        return view('admin.gad-coordinators.edit', compact('gadCoordinator', 'colleges', 'assignedColleges'));
    }

    /**
     * Update a GAD Coordinator in storage
     */
    public function update(StoreGADCoordinatorRequest $request, GADCoordinator $gadCoordinator)
    {
        $oldValues = $gadCoordinator->getAttributes();
        $validated = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($gadCoordinator->photo) {
                \Storage::disk('public')->delete($gadCoordinator->photo);
            }
            $validated['photo'] = $request->file('photo')->store('gad-coordinators', 'public');
        }

        $gadCoordinator->update($validated);

        $college = College::find($validated['college_id']);
        $this->logUpdate($gadCoordinator, $oldValues, "GAD Coordinator: {$gadCoordinator->name} ({$college->name})");

        return redirect()->route('admin.gad-coordinators.index')
                       ->with('success', "GAD Coordinator '{$gadCoordinator->name}' updated successfully!");
    }

    /**
     * Delete a GAD Coordinator from storage
     */
    public function destroy(GADCoordinator $gadCoordinator)
    {
        $college = $gadCoordinator->college;
        $coordinatorName = $gadCoordinator->name;

        // Delete photo if exists
        if ($gadCoordinator->photo) {
            \Storage::disk('public')->delete($gadCoordinator->photo);
        }

        $gadCoordinator->delete();

        $this->logDelete($gadCoordinator, "GAD Coordinator: {$coordinatorName} ({$college->name})");

        return redirect()->route('admin.gad-coordinators.index')
                       ->with('success', "GAD Coordinator '{$coordinatorName}' deleted successfully!");
    }
}
