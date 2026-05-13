<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pembayaran Diterima</title>
    <style>
        body {
            font-family: system-ui, Segoe UI, Arial;
            background: #f8fafc;
            margin: 0
        }

        .card {
            max-width: 600px;
            margin: 24px auto;
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(2, 6, 23, .08)
        }

        .header {
            background: #10b981;
            color: #fff;
            padding: 16px;
            border-radius: 8px 8px 0 0;
            text-align: center
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #0f3d2e;
            color: #fff;
            border-radius: 8px;
            text-decoration: none
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="header">
            <h2>Terima kasih — Pembayaran Diterima</h2>
        </div>
        <div style="padding:16px">
            <p>Halo <strong>{{ $booking->nama_tamu }}</strong>,</p>
            <p>Kami menerima pembayaran untuk booking Anda dengan kode <strong>#{{ $booking->booking_code }}</strong>.
            </p>
            <p>Tim admin akan segera memverifikasi dan memproses pesanan Anda. Kami akan menghubungi Anda jika ada
                informasi tambahan yang diperlukan.</p>
            <p style="margin-top:16px">Detail singkat:</p>
            <ul>
                <li>Apartemen: {{ $booking->room->judul }}</li>
                <li>Check-in: {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</li>
                <li>Check-out: {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</li>
                <li>Total: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</li>
            </ul>
            <p style="margin-top:18px"><a class="btn"
                    href="{{ route('booking.success', $booking->booking_code) }}">Lihat Detail Booking</a></p>
            <p style="color:#64748b;font-size:13px;margin-top:14px">Terima kasih telah memilih IndoApart.</p>
        </div>
    </div>
</body>

</html>
