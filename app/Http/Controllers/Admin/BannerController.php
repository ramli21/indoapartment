<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the banners.
     */
    public function index(Request $request)
    {
        $query = Banner::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $banners = $query->orderBy('type')->orderBy('order')->paginate(15)->withQueryString();
        $types = ['hero' => 'Hero Banner', 'promo' => 'Promo Banner', 'promo_small' => 'Promo Small'];

        return view('admin.banners.index', compact('banners', 'types'));
    }

    /**
     * Show the form for creating a new banner.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created banner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|string|max:500',
            'type' => 'required|in:hero,promo,promo_small',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $validated['image'] = $imagePath;
        }

        // Handle is_active
        $validated['is_active'] = $request->has('is_active');

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil dibuat!');
    }

    /**
     * Display the specified banner.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified banner.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|string|max:500',
            'type' => 'required|in:hero,promo,promo_small',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $imagePath = $request->file('image')->store('banners', 'public');
            $validated['image'] = $imagePath;
        }

        // Handle is_active
        $validated['is_active'] = $request->has('is_active');

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil diperbarui!');
    }

    /**
     * Remove the specified banner.
     */
    public function destroy(Banner $banner)
    {
        // Delete image
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus!');
    }

    /**
     * Toggle banner status.
     */
    public function toggleStatus(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);

        $status = $banner->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.banners.index')
            ->with('success', "Banner berhasil {$status}!");
    }
}
