<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PDMT - Feedback Management System Login</title>

  <link rel="shortcut icon" type="image/png" href="/assets/images/logos/pdmt-logo.png" />
  <link rel="stylesheet" href="/assets/css/styles.min.css" />
</head>

<body>

<div class="page-wrapper" id="main-wrapper" data-layout="vertical"
     data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">

  <div class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">

        <div class="col-md-8 col-lg-6 col-xxl-3">
          <div class="card shadow">
            <div class="card-body">

              <!-- LOGO AREA -->
              <div class="text-center py-3">
               <img src="{{ asset('assets/images/pdmt_Logo.png') }}"
             alt="PDMT Logo"
             class="img-fluid"
             style="max-width:90px;">
                <h5 class="mt-3 mb-1 fw-bold">
                  Provincial Department of Motor Traffic
                </h5>

                <small class="text-muted d-block mb-2">
                  Northern Province
                </small>

                <p class="fw-semibold mb-0">Digital Feedback Management System</p>
                <small class="text-muted">Please sign in to continue</small>
              </div>

              <!-- LOGIN FORM -->
              <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-3">
                  <label class="form-label">Email Address</label>
                  <input type="email"
                         name="email"
                         value="{{ old('email') }}"
                         class="form-control @error('email') is-invalid @enderror"
                         required>

                  @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input type="password"
                         name="password"
                         class="form-control @error('password') is-invalid @enderror"
                         required>

                  @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                  @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                  Sign In
                </button>

           

              </form>

              <!-- FOOTER -->
              <div class="text-center mt-4">
                <small class="text-muted">
                  © {{ date('Y') }} PDMT Northern Province — All Rights Reserved
                </small>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>
</html>
