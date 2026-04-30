<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of published announcements
     */
    public function index()
    {
        $announcements = Announcement::published()
                                    ->latest()
                                    ->paginate(10);
        
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Display the specified announcement
     */
    public function show(Announcement $announcement)
    {
        // Check if announcement is published
        if (!$announcement->isPublished()) {
            abort(404);
        }

        $relatedAnnouncements = Announcement::published()
                                           ->where('id', '!=', $announcement->id)
                                           ->latest()
                                           ->limit(3)
                                           ->get();

        return view('announcements.show', compact('announcement', 'relatedAnnouncements'));
    }
}
