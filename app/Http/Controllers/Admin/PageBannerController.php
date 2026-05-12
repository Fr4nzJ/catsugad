<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageBannerController extends Controller
{
    use LogsActivityTrait;

    public function index()
    {
        $banners = PageBanner::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'page' => 'required|string|in:home,about,programs,news,events,reports,contact',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = $file->storeAs('images/banners', $filename, 'public');
            // Store just the relative path from storage/app/public
            $validated['image_path'] = $path;
        }

        $banner = PageBanner::create($validated);
        $this->logCreate($banner, $banner->name);
        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully!');
    }

    public function edit(PageBanner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, PageBanner $banner)
    {
        $oldValues = $banner->getAttributes();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
            'page' => 'required|string|in:home,about,programs,news,events,reports,contact',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Handle file upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $file = $request->file('image');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = $file->storeAs('images/banners', $filename, 'public');
            // Store just the relative path from storage/app/public
            $validated['image_path'] = $path;
        }

        $banner->update($validated);
        $this->logUpdate($banner, $oldValues, $banner->name);
        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully!');
    }

    public function destroy(PageBanner $banner)
    {
        $this->logDelete($banner, $banner->name);
        // Delete the image file if it exists
        if ($banner->image_path && file_exists(public_path($banner->image_path))) {
            unlink(public_path($banner->image_path));
        }

        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully!');
    }
}
