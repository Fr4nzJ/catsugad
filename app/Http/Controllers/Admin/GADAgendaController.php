<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GADAgenda;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;

class GADAgendaController extends Controller
{
    use LogsActivityTrait;

    public function index()
    {
        $agendas = GADAgenda::orderBy('created_at', 'desc')->paginate(10);
        $statuses = ['Active', 'Inactive'];
        
        return view('admin.gad-agendas.index', compact('agendas', 'statuses'));
    }

    public function create()
    {
        $statuses = ['Active', 'Inactive'];
        $currentYear = date('Y');
        
        return view('admin.gad-agendas.create', compact('statuses', 'currentYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_title' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'start_year' => 'required|integer|min:2000|max:2100',
            'end_year' => 'required|integer|min:2000|max:2100|gte:start_year',
            'objectives' => 'required|string',
            'strategies' => 'required|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $agenda = GADAgenda::create($validated);
        $this->logCreate($agenda, $agenda->agenda_title);
        
        return redirect()->route('admin.gad-agendas.index')
                       ->with('success', 'GAD Agenda created successfully!');
    }

    public function edit(GADAgenda $gadAgenda)
    {
        $statuses = ['Active', 'Inactive'];
        
        return view('admin.gad-agendas.edit', compact('gadAgenda', 'statuses'));
    }

    public function update(Request $request, GADAgenda $gadAgenda)
    {
        $oldValues = $gadAgenda->getAttributes();
        $validated = $request->validate([
            'agenda_title' => 'required|string|max:255',
            'organization' => 'required|string|max:255',
            'start_year' => 'required|integer|min:2000|max:2100',
            'end_year' => 'required|integer|min:2000|max:2100|gte:start_year',
            'objectives' => 'required|string',
            'strategies' => 'required|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $gadAgenda->update($validated);
        $this->logUpdate($gadAgenda, $oldValues, $gadAgenda->agenda_title);
        
        return redirect()->route('admin.gad-agendas.index')
                       ->with('success', 'GAD Agenda updated successfully!');
    }

    public function destroy(GADAgenda $gadAgenda)
    {
        $this->logDelete($gadAgenda, $gadAgenda->agenda_title);
        $gadAgenda->delete();
        
        return redirect()->route('admin.gad-agendas.index')
                       ->with('success', 'GAD Agenda deleted successfully!');
    }
}
