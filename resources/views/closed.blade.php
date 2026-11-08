<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Session Closed - PDMT Feedback</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/pdmt_logo.png') }}">

  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/assets/css/styles.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(180deg, #edf2f9 0%, #e2e8f0 100%);
      font-family: 'Plus Jakarta Sans', sans-serif;
      padding: 20px 14px;
    }

    .closed-card {
      border: 1px solid rgba(226, 232, 240, 0.9);
      border-radius: 20px;
      box-shadow: 0 20px 45px rgba(15, 23, 42, 0.1);
      background: #ffffff;
      max-width: 500px;
      width: 100%;
      text-align: center;
      padding: 40px 28px;
    }

    .status-icon-wrap {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: #eff6ff;
      color: #2563eb;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 38px;
      margin: 0 auto 20px auto;
      box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);
    }

    .closed-title {
      font-size: 22px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.4px;
      margin-bottom: 8px;
    }

    .closed-msg {
      font-size: 14.5px;
      color: #475569;
      line-height: 1.55;
      margin-bottom: 24px;
    }

    .qr-instruction-box {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 12px;
      padding: 16px;
      font-size: 13px;
      color: #475569;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
    }
  </style>
</head>

<body>

  <div class="closed-card">
    <div class="mb-3">
      <img src="{{ asset('assets/images/pdmt_logo.png') }}" width="56" alt="PDMT Logo" class="rounded-circle shadow-sm" style="background:#fff; padding:3px;">
    </div>

    <div class="status-icon-wrap">
      <i class="bi bi-shield-check"></i>
    </div>

    <h2 class="closed-title">Feedback Already Recorded</h2>

    <p class="closed-msg">
      This session has concluded or your response has already been registered securely in our central system.
    </p>

    <div class="qr-instruction-box">
      <i class="bi bi-qr-code-scan fs-3 text-primary flex-shrink-0"></i>
      <span class="text-start">
        Please scan the counter QR code at the service desk whenever you wish to submit new feedback or register a service complaint.
      </span>
    </div>

    <div class="mt-4 pt-3 border-top text-muted small">
      Provincial Department of Motor Traffic &bull; Northern Provincial Council
    </div>
  </div>

</body>
</html>
