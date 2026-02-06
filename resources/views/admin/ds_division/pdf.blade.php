<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { text-align: center; font-family: DejaVu Sans; }
        img { margin-top: 20px; }
        .url { margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <h2>{{ $counter->division_name }} – {{ $counter->counter_name }}</h2>

    <img src="data:image/svg+xml;base64,{{ $qrSvg }}" width="300">

    <div class="url">
        <strong>QR URL:</strong><br>
        {{ $url }}
    </div>
</body>
</html>
