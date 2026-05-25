<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingPaymentLog;

class PaymentRedirectController extends Controller
{
    public function handleRedirect(Request $request)
    {
        // 1. Tangkap invoice_number yang dibawa dari DOKU
        $invoiceNumber = $request->query('invoice_number');

        if (!$invoiceNumber) {
            Log::channel('doku_webhook')->warning("Payment redirect missing invoice_number", ['request' => $request->all()]);
            return redirect('/')->with('error', 'Transaksi tidak ditemukan.');
        }

        // 2. Cek status invoice terbaru di database
        $booking = Booking::where('booking_code', $invoiceNumber)
            ->first();

        if (!$booking) {
            Log::channel('doku_webhook')->warning("Payment redirect invoice not found", ['invoice_number' => $invoiceNumber]);
            return redirect('/')->with('error', 'Invoice tidak terdaftar.');
        }

        // 3. Jika Webhook backend sudah berhasil mengubah status jadi PAID
        if ($booking->paid_at !== null) {
            return redirect()->route('booking.success', $booking);
        }

        // 4. JIKA WEBHOOK BELUM MASUK (Delay Jaringan):
        // Bawa ke halaman tunggu sementara yang akan melakukan refresh otomatis (Akan dibahas di poin 3)
        return view('booking.waiting_payment', compact('invoiceNumber'));
    }

    public function showSuccessPage(Request $request)
    {
        $bookingCode = $request->query('code');
        $booking = Booking::with('room.apartment')
            ->where('booking_code', $bookingCode)
            ->first();
        return view('booking.success', compact('booking'));
    }

    public function checkStatusJson(Request $request)
    {
        $invoiceNumber = $request->query('invoice_number');

        if (!$invoiceNumber) {
            return response()->json(['status' => 'NOT_FOUND'], 404);
        }

       $booking = DB::table('bookings')
            ->where('booking_code', $invoiceNumber)
            ->first();

        if (!$booking) {
            return response()->json(['status' => 'NOT_FOUND'], 404);
        }

        // Mengembalikan status murni ('PENDING', 'PAID', 'EXPIRED', dll)
        return response()->json([
            'status' => $booking->status
        ], 200);
    }
}
