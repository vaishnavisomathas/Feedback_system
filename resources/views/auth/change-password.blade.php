<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/pdmt_logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">
</head>

<body style="background:#f4f6f9;">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/pdmt_logo.png') }}" alt="PDMT" style="max-width:100px;">
                                <h5 class="fw-bold mt-3">Change Your Password</h5>
                                <small class="text-muted">You must set a new password before continuing.</small>
                            </div>

                            <form method="POST" action="{{ route('password.change.update') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
