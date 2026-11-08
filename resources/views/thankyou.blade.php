<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thank You - PDMT Feedback</title>

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

    .thankyou-card {
      border: 1px solid rgba(226, 232, 240, 0.9);
      border-radius: 20px;
      box-shadow: 0 20px 45px rgba(15, 23, 42, 0.1);
      background: #ffffff;
      max-width: 500px;
      width: 100%;
      text-align: center;
      padding: 40px 28px;
    }

    .success-icon-wrap {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: #ecfdf5;
      color: #10b981;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 42px;
      margin: 0 auto 20px auto;
      box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25);
      animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes popIn {
      0% { transform: scale(0.4); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }

    .thankyou-title {
      font-size: 24px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.4px;
      margin-bottom: 6px;
    }

    .trilingual-thankyou {
      font-size: 13.5px;
      color: #059669;
      font-weight: 700;
      margin-bottom: 16px;
    }

    .thankyou-msg {
      font-size: 14.5px;
      color: #475569;
      line-height: 1.55;
      margin-bottom: 24px;
    }

    .qr-again-box {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 12px;
      padding: 14px 18px;
      font-size: 12.5px;
      color: #64748b;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
  </style>
</head>

<body>

  <div class="thankyou-card">
    <div class="mb-3">
      <img src="{{ asset('assets/images/pdmt_logo.png') }}" width="56" alt="PDMT Logo" class="rounded-circle shadow-sm" style="background:#fff; padding:3px;">
    </div>

    <div class="success-icon-wrap">
      <i class="bi bi-check2-circle"></i>
    </div>

    <h2 class="thankyou-title">Feedback Submitted!</h2>
    <div class="trilingual-thankyou">
      உங்கள் கருத்து பதிவாகியுள்ளது &bull; ඔබගේ ප්‍රතිචාරය සටහන් විය
    </div>

    <p class="thankyou-msg">
      Thank you for taking the time to share your experience with the <strong>Provincial Department of Motor Traffic (PDMT)</strong>. Your input helps us continuously improve public service standards.
    </p>

    <div class="qr-again-box">
      <i class="bi bi-qr-code fs-4 text-primary"></i>
      <span>To submit another feedback or complaint, please scan the service counter QR code again.</span>
    </div>

    <div class="mt-4 pt-3 border-top text-muted small">
      Northern Provincial Council &bull; Sri Lanka
    </div>
  </div>

  <script>
    // Prevents browser back button from re-submitting form data
    window.history.replaceState(null, null, window.location.href);
  </script>

</body>
</html>
