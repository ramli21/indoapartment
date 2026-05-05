<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Booking</title>
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
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px;
        }

        .booking-code {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        .booking-code span {
            font-size: 28px;
            font-weight: bold;
            color: #6366f1;
            font-family: monospace;
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
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>🎉 Konfirmasi Booking Anda</h1>
            </div>
            <div class="content">
                <p>Halo <strong>{{ $booking->nama_tamu }}</strong>,</p>
                <p>Terima kasih telah melakukan pemesanan. Berikut adalah detail booking Anda:</p>

                <div class="booking-code">
                    <p style="margin: 0 0 5px 0; color: #64748b; font-size: 14px;">Kode Booking</p>
                    <span>#{{ $booking->booking_code }}</span>
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
                <div class="detail-row">
                    <span class="detail-label">Check-in</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }} (Pukul
                        14:00)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-out</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }} (Pukul
                        12:00)</span>
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
                        <span class="detail-label">Harga per malam</span>
                        <span class="detail-value">Rp {{ number_format($booking->harga_per_malam, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total</span>
                        <span class="amount">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <p style="margin-top: 20px; color: #64748b; font-size: 14px;">
                    Simpan kode booking ini untuk referensi Anda.
                    Anda dapat melacak booking anytime di: <strong>/lacak-booking</strong>
                </p>
            </div>
            <div class="footer">
                <p>IndoApart - Sistem Pemesanan Apartemen</p>
            </div>
        </div>
    </div>
</body>

</html>
