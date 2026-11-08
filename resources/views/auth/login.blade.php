<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PDMT - Official Staff Sign In</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/pdmt_logo.png') }}">

  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>
    :root {
      --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    body {
      margin: 0;
      font-family: var(--font-sans);
      background: #0b1528;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #1e293b;
    }

    .login-container {
      width: 100%;
      max-width: 1100px;
      margin: 20px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
      background: #ffffff;
    }

    /* LEFT BRANDING PANEL */
    .brand-side {
      background: linear-gradient(135deg, #071329 0%, #0f274a 45%, #1e3a8a 100%);
      color: #ffffff;
      padding: 48px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    .brand-side::before {
      content: '';
      position: absolute;
      width: 320px;
      height: 320px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(37, 99, 235, 0.25) 0%, rgba(37, 99, 235, 0) 70%);
      top: -60px;
      right: -60px;
      pointer-events: none;
    }

    .brand-crest-group {
      display: flex;
      align-items: center;
      gap: 16px;
      margin-bottom: 28px;
    }

    .brand-crest {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: #ffffff;
      padding: 6px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
      object-fit: contain;
    }

    .brand-tagline {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: #fbbf24;
      background: rgba(251, 191, 36, 0.12);
      border: 1px solid rgba(251, 191, 36, 0.3);
      padding: 5px 12px;
      border-radius: 20px;
      margin-bottom: 14px;
    }

    .brand-heading {
      font-size: 26px;
      font-weight: 800;
      line-height: 1.25;
      letter-spacing: -0.4px;
      color: #ffffff;
    }

    .brand-subheading {
      font-size: 14px;
      color: #cbd5e1;
      margin-top: 8px;
      line-height: 1.5;
    }

    .feature-list {
      margin-top: 36px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .feature-item {
      display: flex;
      align-items: center;
      gap: 12px;
      background: rgba(255, 255, 255, 0.07);
      backdrop-filter: blur(8px);
      padding: 12px 16px;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.12);
      font-size: 13.5px;
      font-weight: 600;
      color: #f1f5f9;
    }

    .feature-icon {
      width: 32px;
      height: 32px;
      border-radius: 8px;
      background: rgba(37, 99, 235, 0.4);
      color: #93c5fd;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .gov-security-note {
      font-size: 11.5px;
      color: #94a3b8;
      border-top: 1px solid rgba(255, 255, 255, 0.15);
      padding-top: 18px;
      margin-top: 30px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* RIGHT FORM PANEL */
    .form-side {
      padding: 48px;
      background: #ffffff;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-title {
      font-size: 24px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.4px;
      margin-bottom: 4px;
    }

    .form-subtitle {
      font-size: 14px;
      color: #64748b;
      margin-bottom: 28px;
    }

    .form-label {
      font-size: 13px;
      font-weight: 700;
      color: #334155;
      margin-bottom: 6px;
    }

    .input-group-modern {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-icon-lead {
      position: absolute;
      left: 14px;
      color: #94a3b8;
      font-size: 16px;
      pointer-events: none;
      z-index: 5;
    }

    .form-control-modern {
      width: 100%;
      height: 48px;
      padding: 10px 14px 10px 42px;
      border: 1px solid #cbd5e1;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 500;
      color: #0f172a;
      background: #f8fafc;
      transition: all 0.2s ease;
    }

    .form-control-modern:focus {
      outline: none;
      border-color: #2563eb;
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .password-toggle-btn {
      position: absolute;
      right: 12px;
      background: none;
      border: none;
      color: #64748b;
      cursor: pointer;
      font-size: 16px;
      padding: 4px;
      z-index: 5;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .password-toggle-btn:hover {
      color: #0f172a;
    }

    .btn-submit-login {
      height: 48px;
      border-radius: 10px;
      background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
      border: none;
      color: #ffffff;
      font-size: 15px;
      font-weight: 700;
      letter-spacing: -0.2px;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-submit-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(37, 99, 235, 0.45);
      background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
      color: #ffffff;
    }

    @media (max-width: 991px) {
      .brand-side {
        display: none;
      }

      .form-side {
        padding: 36px 24px;
      }
    }
  </style>
</head>

<body>

  <div class="login-container">
    <div class="row g-0">

      <!-- LEFT: CIVIC BRANDING HERO -->
      <div class="col-lg-6 brand-side">
        <div>
          <div class="brand-crest-group">
            <img src="{{ asset('assets/images/npc_logo.png') }}" class="brand-crest" alt="Northern Provincial Council">
            <img src="{{ asset('assets/images/pdmt_logo.png') }}" class="brand-crest" alt="Department of Motor Traffic">
          </div>

          <div class="brand-tagline">
            <i class="bi bi-shield-check"></i> Official Government Portal
          </div>

          <h1 class="brand-heading">
            Provincial Department of Motor Traffic
          </h1>
          <div class="brand-subheading">
            Northern Provincial Council &bull; Sri Lanka
          </div>

          <div class="feature-list">
            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-star-fill"></i>
              </div>
              <div>Real-Time Citizen Service Rating &amp; Feedback Tracking</div>
            </div>

            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-shield-lock-fill"></i>
              </div>
              <div>Multi-Tier Grievance Investigation &amp; Redressal Workflow</div>
            </div>

            <div class="feature-item">
              <div class="feature-icon">
                <i class="bi bi-bar-chart-line-fill"></i>
              </div>
              <div>Executive Performance Analytics &amp; Division Leaderboards</div>
            </div>
          </div>
        </div>

        <div class="gov-security-note">
          <i class="bi bi-lock-fill text-warning"></i>
          <span>Secure authentication restricted to authorized PDMT personnel only.</span>
        </div>
      </div>

      <!-- RIGHT: SIGN IN FORM -->
      <div class="col-lg-6 form-side">
        <div class="text-center d-lg-none mb-4">
          <img src="{{ asset('assets/images/pdmt_logo.png') }}" width="64" alt="PDMT Logo" class="mb-2">
          <h5 class="fw-bold text-dark mb-0">PDMT Northern Province</h5>
          <small class="text-muted">Digital Feedback Management System</small>
        </div>

        <div>
          <h2 class="form-title">Staff Portal Sign In</h2>
          <p class="form-subtitle">Enter your official credentials to access the executive dashboard</p>

          {{-- Validation Errors --}}
          @if($errors->any())
          <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0"></i>
            <div class="small">
              @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
              @endforeach
            </div>
          </div>
          @endif

          <form method="POST" action="{{ route('login.post') }}" id="loginForm">
            @csrf

            <!-- EMAIL ADDRESS -->
            <div class="mb-3">
              <label class="form-label" for="emailInput">Official Email Address</label>
              <div class="input-group-modern">
                <i class="bi bi-envelope input-icon-lead"></i>
                <input type="email"
                       id="emailInput"
                       name="email"
                       value="{{ old('email') }}"
                       class="form-control-modern @error('email') is-invalid @enderror"
                       placeholder="name@pdmt.gov.lk"
                       autocomplete="email"
                       required
                       autofocus>
              </div>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label mb-0" for="passwordInput">Password</label>
              </div>
              <div class="input-group-modern">
                <i class="bi bi-lock input-icon-lead"></i>
                <input type="password"
                       id="passwordInput"
                       name="password"
                       class="form-control-modern @error('password') is-invalid @enderror"
                       placeholder="Enter your secure password"
                       autocomplete="current-password"
                       required>
                <button type="button" class="password-toggle-btn" id="togglePasswordBtn" aria-label="Toggle password visibility">
                  <i class="bi bi-eye" id="passwordEyeIcon"></i>
                </button>
              </div>
            </div>

            <!-- REMEMBER ME -->
            <div class="d-flex align-items-center justify-content-between mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                <label class="form-check-label small text-secondary fw-semibold" for="rememberMe">
                  Remember this device
                </label>
              </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <button type="submit" class="btn btn-submit-login w-100" id="submitBtn">
              <span>Sign In to Dashboard</span>
              <i class="bi bi-arrow-right"></i>
            </button>
          </form>

          <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted d-block">
              &copy; {{ date('Y') }} Provincial Department of Motor Traffic &bull; Northern Province
            </small>
            <small class="text-secondary" style="font-size: 11px;">
              For account provisioning or credential reset, contact the System Administrator.
            </small>
          </div>

        </div>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    // Toggle Password Visibility
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('passwordInput');
    const eyeIcon = document.getElementById('passwordEyeIcon');

    if (toggleBtn && passwordInput && eyeIcon) {
      toggleBtn.addEventListener('click', function() {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        eyeIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
      });
    }

    // Submit Loading State
    const form = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    if (form && submitBtn) {
      form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Authenticating...';
      });
    }
  </script>

</body>
</html>
