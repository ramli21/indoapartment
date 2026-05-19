@extends('emails.layouts.table')

@section('title', 'Pembayaran Diterima')
@section('heading', 'Terima kasih — Pembayaran Diterima')

@section('content')
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td style="padding-bottom:8px;">
                <p style="margin:0">Halo <strong>{{ $booking->nama_tamu }}</strong>,</p>
                <p class="muted" style="margin:8px 0 0 0;">Kami menerima pembayaran untuk booking Anda dengan kode
                    <strong>#{{ $booking->booking_code }}</strong>.</p>
            </td>
        </tr>

        <tr>
            <td style="padding-top:12px;">
                <table width="100%" cellpadding="8" cellspacing="0" role="presentation"
                    style="border-top:1px solid #e2e8f0;">
                    <tr>
                        <td class="muted">Apartemen</td>
                        <td style="text-align:right; font-weight:600;">{{ $booking->room->judul }}</td>
                    </tr>
                    <tr>
                        <td class="muted">Check-in</td>
                        <td style="text-align:right; font-weight:600;">
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="muted">Check-out</td>
                        <td style="text-align:right; font-weight:600;">
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="muted">Total</td>
                        <td style="text-align:right; font-weight:700;">Rp
                            {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="padding-top:18px;">
                <a href="{{ route('booking.success', $booking->booking_code) }}" class="btn"
                    style="background:#0f3d2e; color:#fff; padding:10px 14px; border-radius:8px; text-decoration:none; display:inline-block;">Lihat
                    Detail Booking</a>
            </td>
        </tr>

        <tr>
            <td style="padding-top:14px; color:#64748b; font-size:13px;">Terima kasih telah memilih IndoApart.</td>
        </tr>
    </table>
@endsection
