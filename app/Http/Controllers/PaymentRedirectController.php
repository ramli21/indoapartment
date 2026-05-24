<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentRedirectController extends Controller
{
    public function handleRedirect(Request $request)
    {
        // 1. Tangkap invoice_number yang dibawa dari DOKU
        $invoiceNumber = $request->query('invoice_number');

        if (!$invoiceNumber) {
            return redirect('/')->with('error', 'Transaksi tidak ditemukan.');
        }

        // 2. Cek status invoice terbaru di database
        $booking = DB::table('bookings')
            ->where('booking_code', $invoiceNumber)
            ->first();

        if (!$booking) {
            return redirect('/')->with('error', 'Invoice tidak terdaftar.');
        }

        // 3. Jika Webhook backend sudah berhasil mengubah status jadi PAID
        if ($booking->paid_at !== null) {
            return redirect()->route('booking.success', $booking);
        }

        // 4. JIKA WEBHOOK BELUM MASUK (Delay Jaringan):
        // Bawa ke halaman tunggu sementara yang akan melakukan refresh otomatis (Akan dibahas di poin 3)
        return view('payment.waiting', compact('invoiceNumber'));
    }

    public function showSuccessPage(Request $request)
    {
        $bookingCode = $request->query('code');
        return view('payment.success', compact('bookingCode'));
    }
}
