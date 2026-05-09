<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MidtransSetting;
use Illuminate\Http\Request;

class MidtransSettingController extends Controller
{
    public function edit()
    {
        $setting = MidtransSetting::query()->orderBy('id', 'asc')->first();
        return view('admin.midtrans_settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'server_key' => 'required|string|max:255',
            'client_key' => 'required|string|max:255',
            'webhook_secret' => 'nullable|string|max:255',
            'is_production' => 'required|boolean',
        ]);

        $setting = MidtransSetting::query()->orderBy('id', 'asc')->first();
        if ($setting) {
            $setting->update($validated);
        } else {
            $setting = MidtransSetting::create($validated);
        }

        return redirect()->route('admin.midtrans_settings.edit')
            ->with('success', 'Midtrans setting berhasil disimpan.');
    }
}

