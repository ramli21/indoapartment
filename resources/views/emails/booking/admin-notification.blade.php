<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Baru</title>
</head>

<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">

    <!-- outer wrapper (table based) -->
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;">
        <tr>
            <td align="center" style="padding:20px;">

                <!-- main card -->
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; border:0; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background:#ef4444; padding:20px 30px;">
                            <div style="color:#ffffff; font-size:20px; font-weight:700;">
                                🚫 Booking Baru Masuk!
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:30px;">
                            <div style="font-size:14px; color:#334155; line-height:1.5;">
                                Ada pemesanan baru yang perlu ditinjau. Berikut detail lengkapnya:
                            </div>

                            <div style="margin:20px 0;">
                                <span
                                    style="display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; text-transform:uppercase; background:#fef3c7; color:#d97706;">
                                    {{ $booking->status }}
                                </span>
                            </div>

                            <!-- Section: Booking Summary -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;">
                                <tr>
                                    <td
                                        style="padding:12px 0; color:#64748b; font-size:14px; width:45%; border-bottom:1px solid #e2e8f0;">
                                        Kode Booking</td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%; border-bottom:1px solid #e2e8f0;">
                                        #{{ $booking->booking_code }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:12px 0; color:#64748b; font-size:14px; width:45%; border-bottom:1px solid #e2e8f0;">
                                        Apartemen</td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%; border-bottom:1px solid #e2e8f0;">
                                        {{ $booking->room->judul }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:12px 0; color:#64748b; font-size:14px; width:45%; border-bottom:1px solid #e2e8f0;">
                                        Tower / Lantai</td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%; border-bottom:1px solid #e2e8f0;">
                                        {{ $booking->room->nama_tower }} / Lantai<br>{{ $booking->room->lantai }}</td>
                                </tr>
                            </table>

                            <div style="height:1px; background:#e2e8f0; margin:20px 0;"></div>

                            <!-- Section: Informasi Tamu -->
                            <div style="font-weight:700; margin-bottom:10px; color:#334155; font-size:14px;">Informasi
                                Tamu:</div>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;">
                                <tr>
                                    <td
                                        style="padding:12px 0; color:#64748b; font-size:14px; width:45%; border-bottom:1px solid #e2e8f0;">
                                        Nama</td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%; border-bottom:1px solid #e2e8f0;">
                                        {{ $booking->nama_tamu }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:12px 0; color:#64748b; font-size:14px; width:45%; border-bottom:1px solid #e2e8f0;">
                                        Email</td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%; border-bottom:1px solid #e2e8f0;">
                                        {{ $booking->email_tamu }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#64748b; font-size:14px; width:45%;">No. WhatsApp
                                    </td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%;">
                                        {{ $booking->no_hp }}</td>
                                </tr>
                            </table>

                            <div style="height:1px; background:#e2e8f0; margin:20px 0;"></div>

                            <!-- Section: Jadwal Menginap -->
                            <div style="font-weight:700; margin-bottom:10px; color:#334155; font-size:14px;">Jadwal
                                Menginap:</div>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;">
                                <tr>
                                    <td
                                        style="padding:12px 0; color:#64748b; font-size:14px; width:45%; border-bottom:1px solid #e2e8f0;">
                                        Check-in</td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%; border-bottom:1px solid #e2e8f0;">
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:12px 0; color:#64748b; font-size:14px; width:45%; border-bottom:1px solid #e2e8f0;">
                                        Check-out</td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%; border-bottom:1px solid #e2e8f0;">
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding:12px 0; color:#64748b; font-size:14px; width:45%; border-bottom:1px solid #e2e8f0;">
                                        Jumlah Tamu</td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%; border-bottom:1px solid #e2e8f0;">
                                        {{ $booking->jumlah_tamu }} orang</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 0; color:#64748b; font-size:14px; width:45%;">Lama Menginap
                                    </td>
                                    <td
                                        style="padding:12px 0; color:#1e293b; font-weight:700; font-size:14px; width:55%;">
                                        {{ $booking->jumlah_malam }} malam</td>
                                </tr>
                            </table>

                            <!-- Total -->
                            <div style="background:#f0fdf4; padding:15px; border-radius:8px; margin-top:20px;">
                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                    style="border-collapse:collapse;">
                                    <tr>
                                        <td style="padding:0; color:#64748b; font-size:14px; width:50%;">Total
                                            Pembayaran</td>
                                        <td
                                            style="padding:0; text-align:right; color:#16a34a; font-weight:800; font-size:24px; width:50%;">
                                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>

                            @if ($booking->catatan)
                                <div
                                    style="margin-top:20px; padding:15px; background:#f8fafc; border-radius:8px; border:1px solid #e2e8f0;">
                                    <div style="font-weight:700; margin:0 0 5px 0; color:#64748b; font-size:14px;">
                                        Catatan:</div>
                                    <div style="margin:0; color:#334155; font-size:14px; line-height:1.5;">
                                        {{ $booking->catatan }}</div>
                                </div>
                            @endif

                            <div style="margin-top:20px;">
                                <a href="/admin/bookings/{{ $booking->id }}"
                                    style="display:inline-block; background:#6366f1; color:#ffffff; padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:700; font-size:14px;">
                                    Lihat Detail Lengkap
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 30px; background:#f8fafc; text-align:center;">
                            <div style="color:#94a3b8; font-size:12px;">IndoApart - Admin Dashboard</div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>
