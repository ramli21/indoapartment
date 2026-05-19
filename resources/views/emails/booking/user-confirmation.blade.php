@extends('emails.layouts.table')

@section('title', 'Konfirmasi Booking')
@section('heading', '🎉 Konfirmasi Booking Anda')

@section('content')
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td style="padding-bottom:12px;">
                <p style="margin:0">Halo <strong>{{ $booking->nama_tamu }}</strong>,</p>
                <p class="muted" style="margin:8px 0 0 0;">Terima kasih telah melakukan pemesanan. Berikut adalah detail
                    booking Anda:</p>
            </td>
        </tr>

        <tr>
            <td style="padding:16px 0;">
                <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                    style="background:#f1f5f9; border-radius:6px;">
                    <tr>
                        <td align="center" style="padding:12px; color:#64748b; font-size:14px;">Kode Booking</td>
                    </tr>
                    <tr>
                        <td align="center"
                            style="padding:8px 12px 16px 12px; font-family:monospace; font-size:20px; color:#6366f1; font-weight:700;">
                            #{{ $booking->booking_code }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table width="100%" cellpadding="8" cellspacing="0" role="presentation"
                    style="border-top:1px solid #e2e8f0;">
                    <tr>
                        <td style="width:50%;" class="muted">Apartemen</td>
                        <td style="text-align:right; font-weight:600;">{{ $booking->room->judul }}</td>
                    </tr>
                    <tr>
                        <td class="muted">Tower / Lantai</td>
                        <td style="text-align:right; font-weight:600;">{{ $booking->room->nama_tower }} / Lantai
                            {{ $booking->room->lantai }}</td>
                    </tr>
                    <tr>
                        <td class="muted">Check-in</td>
                        <td style="text-align:right; font-weight:600;">
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }} (Pukul 14:00)</td>
                    </tr>
                    <tr>
                        <td class="muted">Check-out</td>
                        <td style="text-align:right; font-weight:600;">
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }} (Pukul 12:00)</td>
                    </tr>
                    <tr>
                        <td class="muted">Jumlah Tamu</td>
                        <td style="text-align:right; font-weight:600;">{{ $booking->jumlah_tamu }} orang</td>
                    </tr>
                    <tr>
                        <td class="muted">Lama Menginap</td>
                        <td style="text-align:right; font-weight:600;">{{ $booking->jumlah_malam }} malam</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="padding-top:12px;">
                <table width="100%" cellpadding="8" cellspacing="0" role="presentation"
                    style="background:#f0fdf4; border-radius:6px;">
                    <tr>
                        <td class="muted">Harga per malam</td>
                        <td style="text-align:right; font-weight:600;">Rp
                            {{ number_format($booking->harga_per_malam, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="muted">Total</td>
                        <td style="text-align:right; font-size:18px; font-weight:700; color:#16a34a;">Rp
                            {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="padding-top:16px; color:#64748b; font-size:14px;">
                <p style="margin:0;">Simpan kode booking ini untuk referensi Anda. Anda dapat melacak booking anytime di:
                    <strong>/lacak-booking</strong></p>
            </td>
        </tr>

    </table>
@endsection
