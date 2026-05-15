<?php

namespace App\Http\Controllers;

use App\Mail\InquiryNotification;
use App\Models\Apartment;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\AdminInfo;

class InquiryController extends Controller
{
    /**
     * Show inquiry form
     */
    public function create(Request $request)
    {
        $adminInfo = AdminInfo::first();
        $apartment = null;
        if ($request->filled('apartment_id')) {
            $apartment = Apartment::find($request->apartment_id);
        }
        $apartments = Apartment::orderBy('nama')->get();

        return view('inquiry.create', compact('apartment', 'apartments', 'adminInfo'));
    }

    /**
     * Store new inquiry
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'apartment_id' => 'nullable|exists:apartments,id',
            'nama' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\.\-\']+$/',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20|regex:/^[0-9+\s]+$/',
            'subjek' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\.\-\']+$/',
            'pesan' => 'required|string|min:10|max:5000',
        ]);

        // Sanitize input to prevent XSS and SQL injection
        $sanitized = [
            'apartment_id' => $validated['apartment_id'] ?? null,
            'nama' => strip_tags($validated['nama']),
            'email' => filter_var($validated['email'], FILTER_SANITIZE_EMAIL),
            'no_hp' => preg_replace('/[^0-9+]/', '', $validated['no_hp']),
            'subjek' => strip_tags($validated['subjek']),
            'pesan' => strip_tags($validated['pesan']),
            'status' => 'baru',
        ];

        // Create inquiry
        $inquiry = Inquiry::create($sanitized);

        // Load apartment relation
        $inquiry->load('apartment');

        // Send email notification to admin
        $this->sendAdminNotification($inquiry);

        return redirect()->route('inquiry.success')
            ->with('success', 'Pesan Anda telah dikirim! Kami akan segera menghubungi Anda.');
    }

    /**
     * Show success page
     */
    public function success()
    {
        return view('inquiry.success');
    }

    /**
     * Admin: List all inquiries
     */
    public function index(Request $request)
    {
        $query = Inquiry::with('apartment')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subjek', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->paginate(15)->withQueryString();

        // Stats
        $stats = [
            'total' => Inquiry::count(),
            'baru' => Inquiry::where('status', 'baru')->count(),
            'dibaca' => Inquiry::where('status', 'dibaca')->count(),
            'dijawab' => Inquiry::where('status', 'dijawab')->count(),
            'selesai' => Inquiry::where('status', 'selesai')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'stats'));
    }

    /**
     * Admin: Show inquiry details
     */
    public function show(Inquiry $inquiry)
    {
        $inquiry->load('apartment');

        // Mark as read if baru
        if ($inquiry->status === 'baru') {
            $inquiry->update(['status' => 'dibaca']);
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    /**
     * Admin: Update inquiry status
     */
    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:baru,dibaca,dijawab,selesai',
        ]);

        $inquiry->update(['status' => $validated['status']]);

        return redirect()->route('admin.inquiries.show', $inquiry->id)
            ->with('success', 'Status inquiry berhasil diperbarui!');
    }

    /**
     * Admin: Delete inquiry
     */
    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries.index')
            ->with('success', 'Inquiry berhasil dihapus!');
    }

    /**
     * Send notification email to admin
     */
    private function sendAdminNotification(Inquiry $inquiry)
    {
        $adminEmail = config('app.admin_email', false);
        if (!$adminEmail) {
            $admin = \App\Models\User::where('is_admin', true)->first();
            $adminEmail = $admin?->email;
        }

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new InquiryNotification($inquiry));
        }
    }
}
