<?php

namespace App\Http\Controllers;

use App\Models\GADPlanBudget;
use App\Models\College;
use Illuminate\Http\Request;

class GADPlanBudgetController extends Controller
{
    /**
     * Display the GAD Plan & Budget listing
     */
    public function index(Request $request)
    {
        $query = GADPlanBudget::query()
            ->where('status', 'approved')
            ->with('college');

        if ($request->college_id) {
            $query->where('college_id', $request->college_id);
        }

        $plans = $query->orderBy('created_at', 'desc')->paginate(15);
        $colleges = College::orderBy('name')->get();

        return view('gad-plan-budgets.index', compact('plans', 'colleges'));
    }

    /**
     * Display a single GAD Plan & Budget
     */
    public function show(GADPlanBudget $gadPlanBudget)
    {
        if ($gadPlanBudget->status !== 'approved') {
            abort(404);
        }

        return view('gad-plan-budgets.show', compact('gadPlanBudget'));
    }
}
