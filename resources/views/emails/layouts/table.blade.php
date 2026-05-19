<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        /* Basic resets for email clients */
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        table {
            border-collapse: collapse;
        }

        img {
            border: 0;
            display: block;
        }

        .wrapper {
            width: 100%;
            background-color: #f1f5f9;
            padding: 20px 0;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #ffffff;
            text-align: center;
            padding: 30px;
        }

        .inner {
            padding: 24px;
            color: #1e293b;
        }

        .muted {
            color: #64748b;
        }

        .btn {
            display: inline-block;
            background: #6366f1;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 6px;
            text-decoration: none;
        }

        @media only screen and (max-width:480px) {
            .content {
                width: 100% !important;
            }

            .inner {
                padding: 16px !important;
            }
        }
    </style>
</head>

<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="600" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="card">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td class="header">
                                        <h1 style="margin:0; font-size:20px;">@yield('heading')</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="inner">
                                        @yield('content')
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="background:#f8fafc; text-align:center; padding:16px; color:#94a3b8; font-size:12px;">
                                        <p style="margin:0">IndoApart - Sistem Pemesanan Apartemen</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
