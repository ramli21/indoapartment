<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminInfo;

use Illuminate\Support\Facades\Redirect;

class AdminInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Show form to edit admin info (bank, contact)
     */
    public function edit()
    {
        $info = AdminInfo::first();
        return view('admin.admin_info.edit', compact('info'));
    }

    /**
     * Update or create AdminInfo
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:100',
            'account_holder' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        $info = AdminInfo::first();
        if ($info) {
            $info->update($validated);
        } else {
            AdminInfo::create($validated);
        }

        return redirect()->route('admin.info.edit')->with('success', 'Admin info berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
