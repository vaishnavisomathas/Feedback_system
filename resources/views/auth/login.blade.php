<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Northern PDMT Login</title>

  <link rel="shortcut icon" type="image/png" href="/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="/assets/css/styles.min.css" />
</head>

<body>
  <!-- Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <div class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">

                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <!-- Optional Logo Link -->
                </a>

                <div class="text-center py-3">
                  <img src="assets/images/logos/northern-pdmt-logo.png" 
                       alt="Northern PDMT"
                       class="img-fluid"
                       style="max-width:150px;">

                  <p class="mt-2 fw-semibold mb-0">Northern PDMT System</p>
                  <small class="text-muted">Please log in to continue</small>
                </div>

                <form method="POST" action="{{ route('login.post') }}">
                  @csrf

                  <div class="mb-3">
                    <label>Email</label>
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
                    <label>Password</label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                  </div>

                  <button type="submit" class="btn btn-primary w-100">
                      Sign In
                  </button>

                  <div class="mb-3 text-end">
                      <a href="{{ route('password.request') }}" class="text-primary fw-bold">
                          Forgot Password?
                      </a>
                  </div>

                </form>

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
