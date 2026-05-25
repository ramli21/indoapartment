<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserBookingConfirmation;
use App\Mail\AdminBookingNotification;
use App\Mail\UserPaymentReceived;
use App\Mail\AdminPaymentReceived;
use App\Mail\OwnerBookingNotification;
use Illuminate\Support\Str;
use App\Models\AdminInfo;
use App\Models\PaymentConfig;
use App\Services\DokuService;

class BookingController extends Controller
{
    protected DokuService $doku;

    public function __construct(DokuService $doku)
    {
        $this->doku = $doku;
    }

    /**
     * Show booking form for a room
     */
    public function create(Room $room)
    {

        // if ($apartment->status !== 'Tersedia') {
        //     return redirect()->route('apartments.list')
        //         ->with('error', 'Apartemen ini sedang tidak tersedia.');
        // }

        return view('booking.create', compact('room'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request, Room $room)
    {
        $validated = $request->validate([
            'nama_tamu' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\.\-\']+$/',
            'email_tamu' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20|regex:/^[0-9+\s]+$/',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'jumlah_tamu' => 'required|integer|min:1|max:' . ($room->tamu_dewasa + $room->tamu_anak),
            'catatan' => 'nullable|string|max:1000',
        ]);

        // Check for overlapping bookings (only pending/confirmed block)
        $overlapping = Booking::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($validated) {
                $q->where('check_in', '<', $validated['check_out'])
                  ->where('check_out', '>', $validated['check_in']);
            })
            ->exists();

        if ($overlapping) {
            return back()->withInput()->withErrors(['check_in' => 'Rentang tanggal sudah dibooking. Silakan pilih tanggal lain (check-in 14:00, check-out 12:00).']);
        }

        // Sanitize input to prevent XSS and SQL injection
        $sanitized = [
            'nama_tamu' => strip_tags($validated['nama_tamu']),
            'email_tamu' => filter_var($validated['email_tamu'], FILTER_SANITIZE_EMAIL),
            'no_hp' => preg_replace('/[^0-9+]/', '', $validated['no_hp']),
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'jumlah_tamu' => (int) $validated['jumlah_tamu'],
            'catatan' => $validated['catatan'] ? strip_tags($validated['catatan']) : null,
        ];

        // Calculate total price
        $checkIn = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out']);
        $jumlahMalam = $checkIn->diffInDays($checkOut);
        $hargaPerMalam = (float) $room->harga_per_malam;
        $totalHarga = $hargaPerMalam * $jumlahMalam;

        // Generate unique 6-char alphanumeric booking code
        do {
            $bookingCode = strtoupper(Str::random(6));
        } while (Booking::where('booking_code', $bookingCode)->exists());

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'room_id' => $room->id,
            'nama_tamu' => $sanitized['nama_tamu'],
            'email_tamu' => $sanitized['email_tamu'],
            'no_hp' => $sanitized['no_hp'],
            'check_in' => $sanitized['check_in'],
            'check_out' => $sanitized['check_out'],
            'jumlah_tamu' => $sanitized['jumlah_tamu'],
            'harga_per_malam' => $hargaPerMalam,
            'jumlah_malam' => $jumlahMalam,
            'total_harga' => $totalHarga,
            'catatan' => $sanitized['catatan'],
            'status' => 'pending',
        ]);

        // Update room status to Terisi (occupied)
        $room->update(['status' => 'Terisi']);

        // Send email notifications
        $this->sendBookingEmails($booking);

        return redirect()->route('booking.success', $booking->booking_code)
            ->with('success', 'Booking berhasil dibuat! Kode booking Anda: ' . $booking->booking_code);
    }

    /**
     * Show booking success page
     */
    public function success($booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();
        $booking->load('room');
        $room = $booking->room;

        return view('booking.success', compact('booking', 'room'));
    }


    /**
     * Show payment page
     */
    public function payment($booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();
        $booking->load('room');
        $room = $booking->room;

        $paymentInfo = AdminInfo::first();


        // Check if already paid
        if ($booking->paid_at) {
            return redirect()->route('booking.success', ['booking_code' => $booking->booking_code])
                ->with('info', 'Booking ini sudah lunas.');
        }

        $dokuConfig = PaymentConfig::where('provider_name', 'doku')->orderBy('id', 'desc')->first();
        $dokuAvailable = (bool) $dokuConfig;

        return view('booking.payment', compact('booking', 'room', 'paymentInfo', 'dokuAvailable'));

    }

    public function directPayWithDoku(Booking $booking)
    {
        // Handle Doku payment: create invoice/session and redirect or store VA info
        try {
            $doku = new DokuService();
            $amount = (float) $booking->total_harga;
            $invoiceNumber = $booking->booking_code;
            $customer = [
                'name' => $booking->nama_tamu,
                'email' => $booking->email_tamu,
                'phone' => $booking->no_hp,
            ];

            $result = $doku->createInvoice($amount, $invoiceNumber, $customer);

            if (!empty($result['success']) && !empty($result['data'])) {
                // try common keys: payment_url, redirect_url, virtual_account
                $data = $result['data'];
                $payment = $result['data']['response']['payment'];

                if (!empty($payment['url'])) {
                    return redirect()->away($payment['url']);
                }
            }

            Log::error('Doku payment creation failed', ['result' => $result, 'booking_code' => $booking_code]);

            return redirect()->back()->with('error', 'Gagal membuat pembayaran via Doku, atau bisa melakukan pembayaran secara manual melalui transfer bank');
        } catch (\Throwable $e) {
            \Log::error('Doku payment error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyambungkan ke Doku.');
        }
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, $booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();

        // allow doku if configured
        $dokuConfig = PaymentConfig::where('provider_name', 'doku')->orderBy('id', 'desc')->first();
        $paymentMethods = ['bank_transfer', 'qris'];
        if ($dokuConfig) $paymentMethods[] = 'doku';

        $validated = $request->validate([
            'payment_method' => ['required', 'in:' . implode(',', $paymentMethods)],
            'payment_notes' => 'nullable|string|max:500',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle payment proof upload for bank transfer
        if ($request->payment_method === 'bank_transfer' && $request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof'] = $path;
            $validated['paid_at'] = now();
        }

        // For QRIS, mark as paid immediately (instant payment)
        if ($request->payment_method === 'qris') {
            $validated['paid_at'] = now();
        }

        $validated['payment_notes'] = $request->payment_notes ? strip_tags($request->payment_notes) : null;

        $booking->update($validated);

        // Update booking status to confirmed if paid
        if ($booking->paid_at) {
            $booking->update(['status' => 'confirmed']);
            // Send payment-specific notification emails to user and admin
            try {
                $this->sendPaymentEmails($booking);
            } catch (\Exception $e) {
                \Log::error('Failed to send payment notification emails: ' . $e->getMessage());
            }
        }

        return redirect()->route('booking.success', $booking)
            ->with('success', 'Pembayaran berhasil diproses!');
    }

    /**
     * Admin: List all bookings
     */
    public function index(Request $request)
    {
        $query = Booking::with('room')->latest();


        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by room
        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }


        // Filter by date range
        if ($request->filled('tanggal_mulai')) {
            $query->where('check_in', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->where('check_out', '<=', $request->tanggal_akhir);
        }

        // Search by guest name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tamu', 'like', "%{$search}%")
                    ->orWhere('email_tamu', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15)->withQueryString();
        // $apartments = \App\Models\Apartment::orderBy('nama')->get();


        // Stats
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));

    }

    /**
     * Admin: Show booking details
     */
    public function show(Booking $booking)
    {
        $booking->load('room');
        return view('admin.bookings.show', compact('booking'));

    }

    /**
     * Admin: Update booking status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $oldStatus = $booking->status;
        $booking->update(['status' => $validated['status']]);

        // If cancelled, make apartment available again
        if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
            $booking->room->update(['status' => 'Tersedia']);
        }


        // If confirmed/completed, ensure apartment is marked as occupied
        if (in_array($validated['status'], ['pending', 'confirmed', 'completed'])) {
            $booking->room->update(['status' => 'Terisi']);
        }


        return redirect()->route('admin.bookings.show', $booking->id)
            ->with('success', 'Status booking berhasil diperbarui!');
    }

    /**
     * Admin: Cancel/delete booking
     */
    public function destroy(Booking $booking)
    {
        // Make room available again
        if ($booking->room) {
            $booking->room->update(['status' => 'Tersedia']);
        }

        $booking->delete();


        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dibatalkan!');
    }

    /**
     * Public: Track booking page
     */
    public function track()
    {
        return view('booking.track');
    }

    /**
     * Public: Search booking by code
     */
    public function searchBooking(Request $request)
    {
        $bookingCode = $request->input('booking_code');

        if (!$bookingCode) {
            return redirect()->route('booking.track')
                ->with('error', 'Silakan masukkan kode booking.');
        }

        // Try to find by ID (remove leading zeros) or by booking code
        // $bookingId = (int) ltrim($bookingCode, '0');

        $booking = Booking::with('room')

            ->where('booking_code', $bookingCode)
            ->first();

        if (!$booking) {
            return redirect()->route('booking.track')
                ->with('error', 'Booking tidak ditemukan. Silakan periksa kode booking Anda.');
        }

        return view('booking.track-result', compact('booking'));
    }

    /**
     * Admin: Show calendar view
     */
    public function calendar(Request $request)
    {
        $apartments = Apartment::orderBy('judul')->get();

        // Get date range from request or default to current month
        $start = $request->filled('start')
            ? \Carbon\Carbon::parse($request->start)->startOfMonth()
            : \Carbon\Carbon::now()->startOfMonth();
        $end = $request->filled('end')
            ? \Carbon\Carbon::parse($request->end)->endOfMonth()
            : \Carbon\Carbon::now()->endOfMonth();

        // Get bookings within date range
        $bookings = Booking::with('apartment')
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('check_in', [$start, $end])
                    ->orWhereBetween('check_out', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('check_in', '<=', $start)
                            ->where('check_out', '>=', $end);
                    });
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('check_in')
            ->get();

        return view('admin.bookings.calendar', compact('apartments', 'bookings', 'start', 'end'));
    }

    /**
     * Admin: Store new booking from admin panel
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'nama_tamu' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\.\-\']+$/',
            'email_tamu' => 'required|email|max:255',
            'no_hp' => 'required|string|max:20|regex:/^[0-9+\s]+$/',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'jumlah_tamu' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,confirmed',
        ]);

        // Sanitize input
        $sanitized = [
            'nama_tamu' => strip_tags($validated['nama_tamu']),
            'email_tamu' => filter_var($validated['email_tamu'], FILTER_SANITIZE_EMAIL),
            'no_hp' => preg_replace('/[^0-9+]/', '', $validated['no_hp']),
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'jumlah_tamu' => (int) $validated['jumlah_tamu'],
            'catatan' => $validated['catatan'] ? strip_tags($validated['catatan']) : null,
        ];

        $apartment = Apartment::findOrFail($validated['apartment_id']);

        // Validate guest count
        $maxGuests = $apartment->tamu_dewasa + $apartment->tamu_anak;
        if ($validated['jumlah_tamu'] > $maxGuests) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah tamu melebihi kapasitas apartemen (maksimal ' . $maxGuests . ' tamu)',
            ], 422);
        }

        // Calculate total price
        $checkIn = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out']);
        $jumlahMalam = $checkIn->diffInDays($checkOut);

        if ($jumlahMalam < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pemesanan adalah 1 malam',
            ], 422);
        }

        $hargaPerMalam = (float) $apartment->harga_per_malam;
        $totalHarga = $hargaPerMalam * $jumlahMalam;

        $booking = Booking::create([
            'apartment_id' => $validated['apartment_id'],
            'nama_tamu' => $sanitized['nama_tamu'],
            'email_tamu' => $sanitized['email_tamu'],
            'no_hp' => $sanitized['no_hp'],
            'check_in' => $sanitized['check_in'],
            'check_out' => $sanitized['check_out'],
            'jumlah_tamu' => $sanitized['jumlah_tamu'],
            'harga_per_malam' => $hargaPerMalam,
            'jumlah_malam' => $jumlahMalam,
            'total_harga' => $totalHarga,
            'catatan' => $sanitized['catatan'],
            'status' => $validated['status'],
        ]);

        // Update apartment status
        $apartment->update(['status' => 'Terisi']);

        // Send email notifications
        $this->sendBookingEmails($booking);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat!',
            'booking_id' => $booking->id,
        ]);
    }

    /**
     * API: Get bookings schedule for calendar
     */
    public function getSchedule(Request $request)
    {
        $start = $request->filled('start')
            ? \Carbon\Carbon::parse($request->start)->startOfMonth()
            : \Carbon\Carbon::now()->startOfMonth();
        $end = $request->filled('end')
            ? \Carbon\Carbon::parse($request->end)->endOfMonth()
            : \Carbon\Carbon::now()->endOfMonth();

        $bookings = Booking::with('apartment:id,judul,nama_tower')
            ->select([
                'id',
                'apartment_id',
                'nama_tamu',
                'email_tamu',
                'no_hp',
                'check_in',
                'check_out',
                'jumlah_tamu',
                'harga_per_malam',
                'jumlah_malam',
                'total_harga',
                'catatan',
                'status',
            ])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('check_in', [$start, $end])
                    ->orWhereBetween('check_out', [$start, $end])
                    ->orWhere(function ($q) use ($start, $end) {
                        $q->where('check_in', '<=', $start)
                            ->where('check_out', '>=', $end);
                    });
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('check_in')
            ->get()
            ->map(function ($booking) {
                $statusColors = [
                    'pending' => '#f59e0b',
                    'confirmed' => '#10b981',
                    'completed' => '#6366f1',
                    'cancelled' => '#94a3b8',
                ];

                return [
                    'id' => $booking->id,
                    'title' => $booking->room->judul . ' - ' . $booking->nama_tamu,
                    'start' => $booking->check_in,
                    'end' => \Carbon\Carbon::parse($booking->check_out)->addDay()->format('Y-m-d'),
                    'backgroundColor' => $statusColors[$booking->status] ?? '#6366f1',
                    'borderColor' => $statusColors[$booking->status] ?? '#6366f1',
                    'extendedProps' => [
                        'apartment_id' => $booking->room_id,
                        'apartment_name' => $booking->room->judul,
                        'tower_name' => $booking->room->nama_tower,
                        'guest_name' => $booking->nama_tamu,
                        'guest_email' => $booking->email_tamu,
                        'guest_phone' => $booking->no_hp,
                        'check_in' => $booking->check_in,
                        'check_out' => $booking->check_out,
                        'guest_count' => $booking->jumlah_tamu,
                        'nights' => $booking->jumlah_malam,
                        'price_per_night' => $booking->harga_per_malam,
                        'total_price' => $booking->total_harga,
                        'notes' => $booking->catatan,
                        'status' => $booking->status,
                    ],
                ];
            });

        return response()->json($bookings);
    }

    /**
     * API: Check room availability for date range
     */
    public function checkAvailability(Request $request)
    {
        $validated = $request->validate([
            'apartment_id' => 'required|exists:apartments,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out']);

        // Find conflicting bookings
        $conflicts = Booking::where('apartment_id', $validated['apartment_id'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->where(function ($q) use ($checkIn, $checkOut) {
                    $q->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                });
            })
            ->with('apartment:id,judul,nama_tower')
            ->get();

        $isAvailable = $conflicts->isEmpty();

        return response()->json([
            'available' => $isAvailable,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'conflicts' => $conflicts->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'guest_name' => $booking->nama_tamu,
                    'check_in' => $booking->check_in,
                    'check_out' => $booking->check_out,
                ];
            }),
        ]);
    }

/**
     * Send booking notification emails to user, admin, and owner
     */
    private function sendBookingEmails(Booking $booking)
    {
        $booking->load('room');
        $room = $booking->room;


        // 1. Send confirmation email to user
        Mail::to($booking->email_tamu)->send(new UserBookingConfirmation($booking));

        // 2. Send notification to admin (from config or first admin user)
        $adminEmail = false;
        // Prefer admin email from AdminInfo if available
        try {
            $adminInfo = AdminInfo::first();
            if ($adminInfo && !empty($adminInfo->email)) {
                $adminEmail = $adminInfo->email;
            }
        } catch (\Exception $e) {
            // ignore and fallback
        }

        if (!$adminEmail) {
            $adminEmail = config('app.admin_email', false);
        }

        if (!$adminEmail) {
            $admin = User::where('is_admin', true)->first();
            $adminEmail = $admin?->email;
        }
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new AdminBookingNotification($booking));
        }

        // 3. Send notification to owner via WhatsApp (owner email not stored, using WA for contact)
        // The owner notification will be shown in the owner dashboard
        // For now, we'll just indicate the notification was sent
    }

    /**
     * Send payment received emails to user and admin
     */
    private function sendPaymentEmails(Booking $booking)
    {
        $booking->load('room');


        // 1. Send thank-you email to user
        try {
            Mail::to($booking->email_tamu)->send(new UserPaymentReceived($booking));
        } catch (\Exception $e) {
            \Log::error('Failed to send user payment email: ' . $e->getMessage());
        }

        // 2. Notify admin (prefer AdminInfo email)
        $adminEmail = false;
        try {
            $adminInfo = AdminInfo::first();
            if ($adminInfo && !empty($adminInfo->email)) {
                $adminEmail = $adminInfo->email;
            }
        } catch (\Exception $e) {
            // ignore
        }

        if (!$adminEmail) {
            $adminEmail = config('app.admin_email', false);
        }
        if (!$adminEmail) {
            $admin = User::where('is_admin', true)->first();
            $adminEmail = $admin?->email;
        }

        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new AdminPaymentReceived($booking));
            } catch (\Exception $e) {
                \Log::error('Failed to send admin payment email: ' . $e->getMessage());
            }
        }
    }

    /**
     * Show cancel booking page for user
     */
    public function cancelForm($booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();
        $booking->load('room');
        
        // Only allow cancellation if not already cancelled or completed
        if (in_array($booking->status, ['cancelled', 'completed'])) {
            return redirect()->route('booking.track')
                ->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        return view('booking.cancel', compact('booking'));
    }

    /**
     * Process cancel booking by user
     */
    public function cancelBooking(Request $request, $booking_code)
    {
        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();

        $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ]);

        // Only allow cancellation if not already cancelled or completed
        if (in_array($booking->status, ['cancelled', 'completed'])) {
            return redirect()->route('booking.track')
                ->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        // Determine if paid or not
        $isPaid = !empty($booking->paid_at);
        $oldStatus = $booking->status;

        // Update booking to cancelled
        $booking->update([
            'status' => 'cancelled',
            'cancel_reason' => strip_tags($request->cancel_reason),
            'cancelled_by' => 'user',
            'cancelled_at' => now(),
        ]);

        // Make apartment available again
        if ($booking->room) {
            $booking->room->update(['status' => 'Tersedia']);
        }

        // Send notification to admin about cancellation
        $this->sendCancellationNotification($booking, $oldStatus, $isPaid);

        return redirect()->route('booking.track')
            ->with('success', 'Booking berhasil dibatalkan. ' . ($isPaid ? 'Silakan hubungi owner untuk pengembalian dana.' : ''));    
    }

    /**
     * Send cancellation notification email
     */
    private function sendCancellationNotification(Booking $booking, string $oldStatus, bool $isPaid)
    {
        $booking->load('apartment');
        
        // Notify admin about the cancellation
        $adminEmail = config('app.admin_email', false);
        if (!$adminEmail) {
            $admin = User::where('is_admin', true)->first();
            $adminEmail = $admin?->email;
        }
        
        if ($adminEmail) {
            // You can create a new Mailable for cancellation notifications
            // For now, we'll just log it or skip
            \Log::info("Booking {$booking->id} cancelled by user. Was paid: " . ($isPaid ? 'Yes' : 'No'));
        }
    }
}
