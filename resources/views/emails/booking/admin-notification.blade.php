<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #ef4444;
            padding: 20px 30px;
        }

        .header h1 {
            color: white;
            margin: 0;
            font-size: 20px;
        }

        .content {
            padding: 30px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-confirmed {
            background: #d1fae5;
            color: #059669;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #64748b;
        }

        .detail-value {
            font-weight: 600;
            color: #1e293b;
        }

        .total-price {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .total-price .amount {
            font-size: 24px;
            font-weight: bold;
            color: #16a34a;
        }

        .footer {
            padding: 20px 30px;
            background: #f8fafc;
            text-align: center;
        }

        .footer p {
            color: #94a3b8;
            font-size: 12px;
            margin: 0;
        }

        .btn {
            display: inline-block;
            background: #6366f1;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>📋 Booking Baru Masuk!</h1>
            </div>
            <div class="content">
                <p>Ada pemesanan baru yang perlu ditinjau. Berikut detail lengkapnya:</p>

                <div style="margin: 20px 0;">
                    <span class="badge badge-pending">{{ $booking->status }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Kode Booking</span>
                    <span class="detail-value">#{{ $booking->booking_code }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Apartemen</span>
                    <span class="detail-value">{{ $booking->apartment->judul }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tower / Lantai</span>
                    <span class="detail-value">{{ $booking->apartment->nama_tower }} / Lantai
                        {{ $booking->apartment->lantai }}</span>
                </div>

                <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">

                <p style="font-weight: 600; margin-bottom: 10px;">Informasi Tamu:</p>
                <div class="detail-row">
                    <span class="detail-label">Nama</span>
                    <span class="detail-value">{{ $booking->nama_tamu }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $booking->email_tamu }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">No. WhatsApp</span>
                    <span class="detail-value">{{ $booking->no_hp }}</span>
                </div>

                <hr style="margin: 20px 0; border: none; border-top: 1px solid #e2e8f0;">

                <p style="font-weight: 600; margin-bottom: 10px;">Jadwal Menginap:</p>
                <div class="detail-row">
                    <span class="detail-label">Check-in</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-out</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jumlah Tamu</span>
                    <span class="detail-value">{{ $booking->jumlah_tamu }} orang</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Lama Menginap</span>
                    <span class="detail-value">{{ $booking->jumlah_malam }} malam</span>
                </div>

                <div class="total-price">
                    <div class="detail-row">
                        <span class="detail-label">Total Pembayaran</span>
                        <span class="amount">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if ($booking->catatan)
                    <div style="margin-top: 20px; padding: 15px; background: #f8fafc; border-radius: 8px;">
                        <p style="font-weight: 600; margin: 0 0 5px 0; color: #64748b;">Catatan:</p>
                        <p style="margin: 0;">{{ $booking->catatan }}</p>
                    </div>
                @endif

                <p style="margin-top: 20px;">
                    <a href="/admin/bookings/{{ $booking->id }}" class="btn">Lihat Detail Lengkap</a>
                </p>
            </div>
            <div class="footer">
                <p>IndoApart - Admin Dashboard</p>
            </div>
        </div>
    </div>
</body>

</html>
