<?php

namespace App\Http\Controllers;

use App\Models\OrganizationMember;

class OrganizationStructureController extends Controller
{
    public function index()
    {
        $members = OrganizationMember::orderBy('role_group')->orderBy('sort_order')->get();
        $groupedMembers = $members->groupBy('role_group');
        
        return view('organization-structure.index', compact('groupedMembers'));
    }
}
