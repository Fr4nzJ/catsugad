<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationMember;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;

class OrganizationMemberController extends Controller
{
    use LogsActivityTrait;

    public function index()
    {
        $members = OrganizationMember::orderBy('role_group')->orderBy('sort_order')->paginate(15);
        return view('admin.organization-members.index', compact('members'));
    }

    public function create()
    {
        $roleGroups = ['Executive Committee', 'Technical Working Group'];
        return view('admin.organization-members.create', compact('roleGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'role_group' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('organization-members', 'public');
        }

        $member = OrganizationMember::create($data);
        $this->logCreate($member, $member->name);
        return redirect()->route('admin.organization-members.index')->with('success', 'Organization member added successfully!');
    }

    public function edit(OrganizationMember $organizationMember)
    {
        $roleGroups = ['Executive Committee', 'Technical Working Group'];
        return view('admin.organization-members.edit', compact('organizationMember', 'roleGroups'));
    }

    public function update(Request $request, OrganizationMember $organizationMember)
    {
        $oldValues = $organizationMember->getAttributes();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'role_group' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = $validated;

        if ($request->hasFile('image')) {
            if ($organizationMember->image_path) {
                \Storage::disk('public')->delete($organizationMember->image_path);
            }
            $data['image_path'] = $request->file('image')->store('organization-members', 'public');
        }

        $organizationMember->update($data);
        $this->logUpdate($organizationMember, $oldValues, $organizationMember->name);
        return redirect()->route('admin.organization-members.index')->with('success', 'Organization member updated successfully!');
    }

    public function destroy(OrganizationMember $organizationMember)
    {
        $this->logDelete($organizationMember, $organizationMember->name);
        if ($organizationMember->image_path) {
            \Storage::disk('public')->delete($organizationMember->image_path);
        }
        $organizationMember->delete();
        return redirect()->route('admin.organization-members.index')->with('success', 'Organization member deleted successfully!');
    }
}
