<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Models\Announcement;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use LogsActivityTrait;

    public function index()
    {
        $announcements = Announcement::latest('published_at')
                                    ->latest('created_at')
                                    ->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? $validated['published_at'] : null,
        ];
        
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement = Announcement::create($data);
        $this->logCreate($announcement, $announcement->title);
        
        return redirect()->route('admin.announcements.index')
                       ->with('success', 'Announcement created successfully!');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(StoreAnnouncementRequest $request, Announcement $announcement)
    {
        $oldValues = $announcement->getAttributes();
        $validated = $request->validated();

        $data = [
            'title' => $validated['title'],
            'excerpt' => $validated['excerpt'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? $validated['published_at'] : null,
        ];

        if ($request->hasFile('image')) {
            if ($announcement->image_path) {
                \Storage::disk('public')->delete($announcement->image_path);
            }
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($data);
        $this->logUpdate($announcement, $oldValues, $announcement->title);
        
        return redirect()->route('admin.announcements.index')
                       ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        $this->logDelete($announcement, $announcement->title);
        if ($announcement->image_path) {
            \Storage::disk('public')->delete($announcement->image_path);
        }
        $announcement->delete();
        
        return redirect()->route('admin.announcements.index')
                       ->with('success', 'Announcement deleted successfully!');
    }
}
