<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Pembayaran Masuk</title>
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
            background: #ef4444;
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
            <h2>Pembayaran Masuk — Tindakan Diperlukan</h2>
        </div>
        <div style="padding:16px">
            <p>Halo,</p>
            <p>Ada pembayaran masuk untuk pesanan dengan kode <strong>#{{ $booking->booking_code }}</strong>.</p>
            <p>Mohon verifikasi pembayaran dan konfirmasi status booking melalui dashboard admin.</p>

            <p style="margin-top:12px">Ringkasan:</p>
            <ul>
                <li>Apartemen: {{ $booking->room->judul }}</li>
                <li>Tamu: {{ $booking->nama_tamu }} — {{ $booking->no_hp }}</li>
                <li>Total: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</li>
            </ul>

            <p style="margin-top:16px"><a class="btn" href="{{ url('/admin/bookings/' . $booking->id) }}">Buka Booking
                    di Admin</a></p>
            <p style="color:#64748b;font-size:13px;margin-top:14px">-- IndoApart</p>
        </div>
    </div>
</body>

</html>
