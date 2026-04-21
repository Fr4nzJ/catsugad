<?php

namespace App\Http\Controllers;

use App\Models\AccomplishmentReport;
use Illuminate\Http\Request;

class AccomplishmentReportController extends Controller
{
    /**
     * Public index - show all accomplishment reports
     */
    public function index(Request $request)
    {
        $reports = AccomplishmentReport::query()
            ->when($request->college, fn($q) => $q->where('college', $request->college))
            ->when($request->gender, fn($q) => $q->where('gender', $request->gender))
            ->orderBy('year', 'desc')
            ->paginate(15);

        $colleges = AccomplishmentReport::distinct()
            ->pluck('college')
            ->filter()
            ->sort()
            ->values();

        return view('accomplishment-report', compact('reports', 'colleges'));
    }
}

