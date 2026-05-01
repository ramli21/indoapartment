<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inquiry Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #6366f1;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 14px;
        }

        .info-value {
            color: #1f2937;
            font-size: 16px;
            margin-top: 4px;
        }

        .message-box {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
        }

        .message-text {
            white-space: pre-wrap;
            color: #1f2937;
        }

        .apartment-info {
            background-color: #e0e7ff;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .apartment-name {
            font-weight: 600;
            color: #4338ca;
            font-size: 18px;
        }

        .footer {
            background-color: #f9fafb;
            padding: 15px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📬 Inquiry Baru</h1>
        </div>

        <div class="content">
            @if ($inquiry->apartment)
                <div class="apartment-info">
                    <div class="apartment-name">{{ $inquiry->apartment->judul }}</div>
                    <div style="color: #6366f1; font-size: 14px;">{{ $inquiry->apartment->nama_tower }}</div>
                </div>
            @endif

            <div class="info-row">
                <div class="info-label">Nama</div>
                <div class="info-value">{{ $inquiry->nama }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $inquiry->email }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">No. WhatsApp</div>
                <div class="info-value">{{ $inquiry->no_hp }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Subjek</div>
                <div class="info-value">{{ $inquiry->subjek }}</div>
            </div>

            <div class="info-row">
                <div class="info-label">Pesan</div>
                <div class="message-box">
                    <div class="message-text">{{ $inquiry->pesan }}</div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Waktu</div>
                <div class="info-value">{{ $inquiry->created_at->format('d M Y, H:i') }} WIB</div>
            </div>
        </div>

        <div class="footer">
            <p>IndoApartment - Sistem Manajemen Apartemen</p>
            <a href="{{ url('/admin/inquiries') }}" style="color: #6366f1;">Lihat di Dashboard Admin</a>
        </div>
    </div>
</body>

</html>
