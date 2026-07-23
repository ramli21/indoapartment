<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FonnteSetting;
use Illuminate\Http\Request;

class FonnteSettingController extends Controller
{
    /**
     * Show form to edit Fonnte configuration.
     */
    public function edit()
    {
        $setting = FonnteSetting::first() ?? new FonnteSetting([
            'name' => 'Primary Device',
            'base_url' => 'https://api.fonnte.com',
            'country_code' => '62',
            'is_active' => true,
        ]);

        return view('admin.fonnte.edit', compact('setting'));
    }

    /**
     * Update Fonnte configuration.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'base_url' => 'required|url|max:255',
            'token' => 'nullable|string',
            'country_code' => 'required|string|max:10',
            'is_active' => 'nullable|boolean',
        ]);

        $setting = FonnteSetting::first();

        // Convert checkbox state to boolean
        $validated['is_active'] = $request->has('is_active');

        // Only update token if it is provided
        if (empty($validated['token'])) {
            unset($validated['token']);
        }

        if ($setting) {
            $setting->update($validated);
        } else {
            // If token is missing for a new record, require it
            if (!isset($validated['token'])) {
                return back()->withErrors(['token' => 'Token wajib diisi untuk konfigurasi baru.'])->withInput();
            }
            FonnteSetting::create($validated);
        }

        return redirect()->route('admin.fonnte.edit')->with('success', 'Pengaturan Fonnte berhasil disimpan.');
    }
}
