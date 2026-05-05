<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Apartemen Dipesan</title>
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
            background: #10b981;
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

        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .info-box p {
            margin: 0;
            color: #1e40af;
            font-size: 14px;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>🏠 Apartemen Dipesan!</h1>
            </div>
            <div class="content">
                <p>Yth. Pemilik Apartemen,</p>
                <p>Apartemen Anda telah dipesan oleh tamu. Berikut informasi pemesanan:</p>

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

                <p style="font-weight: 600; margin-bottom: 10px;">Jadwal Tamu:</p>
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

                <div class="info-box">
                    <p>📱 Admin akan menghubungi Anda melalui WhatsApp untuk koordinasi lebih lanjut.</p>
                </div>

                <p style="margin-top: 20px; color: #64748b; font-size: 14px;">
                    Silakan tunggu kontak dari admin atau hubungi admin jika ada perubahan jadwal.
                </p>
            </div>
            <div class="footer">
                <p>IndoApart - Sistem Pemesanan Apartemen</p>
            </div>
        </div>
    </div>
</body>

</html>
