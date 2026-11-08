<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Security Update - Change Password</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/pdmt_logo.png') }}">

  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    body {
      background: #0b1528;
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #1e293b;
    }

    .security-card {
      border-radius: 18px;
      border: 1px solid rgba(255, 255, 255, 0.12);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
      background: #ffffff;
      overflow: hidden;
    }

    .security-header {
      background: linear-gradient(135deg, #071329 0%, #0f274a 100%);
      color: #ffffff;
      padding: 30px 24px;
      text-align: center;
      border-bottom: 3px solid #f59e0b;
    }

    .form-control-modern {
      height: 46px;
      border-radius: 10px;
      border: 1px solid #cbd5e1;
      font-size: 14px;
      padding-left: 40px;
    }

    .form-control-modern:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .input-wrapper {
      position: relative;
    }

    .input-wrapper i {
      position: absolute;
      left: 14px;
      top: 14px;
      color: #94a3b8;
    }
  </style>
</head>

<body>
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-5">

        <div class="card security-card">
          <div class="security-header">
            <img src="{{ asset('assets/images/pdmt_logo.png') }}" alt="PDMT Logo" width="56" class="rounded-circle mb-2" style="background:#fff; padding:3px;">
            <h4 class="fw-bold mb-1 text-white">Security Update</h4>
            <div class="text-white-50 small">Provincial Department of Motor Traffic &bull; NP</div>
          </div>

          <div class="card-body p-4">
            <div class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-shield-exclamation fs-5 flex-shrink-0"></i>
              <span>For system security, you must configure a new personalized password before proceeding.</span>
            </div>

            @if($errors->any())
            <div class="alert alert-danger py-2 px-3 small mb-3">
              @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
              @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('password.change.update') }}">
              @csrf

              <div class="mb-3">
                <label class="form-label fw-bold small text-secondary">New Password</label>
                <div class="input-wrapper">
                  <i class="bi bi-key-fill"></i>
                  <input type="password" name="password" class="form-control form-control-modern @error('password') is-invalid @enderror" placeholder="Min. 8 characters" required>
                </div>
                @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold small text-secondary">Confirm New Password</label>
                <div class="input-wrapper">
                  <i class="bi bi-check2-circle"></i>
                  <input type="password" name="password_confirmation" class="form-control form-control-modern" placeholder="Re-type new password" required>
                </div>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius:10px;">
                Update Password &amp; Continue <i class="bi bi-arrow-right ms-1"></i>
              </button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>
