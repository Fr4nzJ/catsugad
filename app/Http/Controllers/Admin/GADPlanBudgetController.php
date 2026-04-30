<?php

namespace App\Http\Controllers\Admin;

use App\Models\GADPlanBudget;
use App\Models\College;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GADPlanBudgetController extends Controller
{
    use LogsActivityTrait;

    /**
     * Display admin listing of GAD Plan & Budgets
     */
    public function index(Request $request)
    {
        $query = GADPlanBudget::query()->with('college');

        if ($request->college_id) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $plans = $query->orderBy('created_at', 'desc')->paginate(15);
        $colleges = College::orderBy('name')->get();
        $statuses = ['draft' => 'Draft', 'submitted' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected'];

        return view('admin.gad-plan-budgets.index', compact('plans', 'colleges', 'statuses'));
    }

    /**
     * Show form for creating a new GAD Plan & Budget
     */
    public function create()
    {
        $colleges = College::orderBy('name')->get();

        return view('admin.gad-plan-budgets.create', compact('colleges'));
    }

    /**
     * Store a newly created GAD Plan & Budget
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'college_id' => 'required|exists:colleges,id',
            'program_project' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_beneficiaries' => 'nullable|string|max:255',
            'budget_amount' => 'required|numeric|min:0',
            'timeline' => 'nullable|string|max:255',
            'status' => 'required|in:draft,submitted,approved,rejected',
        ]);

        $plan = GADPlanBudget::create($validated);
        $college = College::find($validated['college_id']);
        $this->logCreate($plan, "GAD Plan & Budget: {$plan->title} ({$college->name})");

        return redirect()->route('admin.gad-plan-budgets.index')
            ->with('success', 'GAD Plan & Budget created successfully');
    }

    /**
     * Show form for editing a GAD Plan & Budget
     */
    public function edit(GADPlanBudget $gadPlanBudget)
    {
        $colleges = College::orderBy('name')->get();

        return view('admin.gad-plan-budgets.edit', compact('gadPlanBudget', 'colleges'));
    }

    /**
     * Update the specified GAD Plan & Budget
     */
    public function update(Request $request, GADPlanBudget $gadPlanBudget)
    {
        $oldValues = $gadPlanBudget->getAttributes();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'college_id' => 'required|exists:colleges,id',
            'program_project' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_beneficiaries' => 'nullable|string|max:255',
            'budget_amount' => 'required|numeric|min:0',
            'timeline' => 'nullable|string|max:255',
            'status' => 'required|in:draft,submitted,approved,rejected',
        ]);

        $gadPlanBudget->update($validated);
        $college = College::find($validated['college_id']);
        $this->logUpdate($gadPlanBudget, $oldValues, "GAD Plan & Budget: {$gadPlanBudget->title} ({$college->name})");

        return redirect()->route('admin.gad-plan-budgets.index')
            ->with('success', 'GAD Plan & Budget updated successfully');
    }

    /**
     * Delete the specified GAD Plan & Budget
     */
    public function destroy(GADPlanBudget $gadPlanBudget)
    {
        $college = $gadPlanBudget->college;
        $this->logDelete($gadPlanBudget, "GAD Plan & Budget: {$gadPlanBudget->title} ({$college->name})");
        $gadPlanBudget->delete();

        return redirect()->route('admin.gad-plan-budgets.index')
            ->with('success', 'GAD Plan & Budget deleted successfully');
    }
}
