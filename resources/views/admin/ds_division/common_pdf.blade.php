<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Common Feedback QR</title>
    <style>
        body {
            text-align: center;
            font-family: DejaVu Sans, sans-serif;
            padding: 30px;
            color: #1e293b;
        }
        .header {
            margin-bottom: 25px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 6px;
            color: #0f172a;
        }
        .subtitle {
            font-size: 15px;
            color: #475569;
            margin-bottom: 4px;
        }
        .badge {
            display: inline-block;
            padding: 6px 16px;
            background-color: #2563eb;
            color: #ffffff;
            font-size: 13px;
            font-weight: bold;
            border-radius: 20px;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .qr-container {
            margin: 20px auto;
            padding: 15px;
            display: inline-block;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
        }
        .instructions {
            margin-top: 25px;
            font-size: 14px;
            line-height: 1.6;
            color: #334155;
        }
        .url {
            margin-top: 15px;
            font-size: 12px;
            color: #64748b;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Provincial Department of Motor Traffic</div>
        <div class="subtitle">Northern Province</div>
    </div>

    <div class="qr-container">
        <img src="data:image/svg+xml;base64,{{ $qrSvg }}" width="280">
    </div>

  


</body>
</html>

