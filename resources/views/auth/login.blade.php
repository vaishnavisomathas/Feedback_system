<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>PDMT - Feedback Management System Login</title>

<link rel="shortcut icon" href="{{ asset('assets/images/pdmt_logo.png') }}">
<link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

<style>

body{
background:#f4f6f9;
}

/* Login Card */

.login-card{
border-radius:12px;
padding:10px;
}

/* Logo */

.login-logo{
max-width:120px;
}

/* Mobile adjustments */

@media (max-width:768px){

.login-logo{
max-width:90px;
}

.login-title{
font-size:16px;
}

.login-subtitle{
font-size:13px;
}

.login-system{
font-size:14px;
}

}

</style>

</head>

<body>

<div class="min-vh-100 d-flex align-items-center justify-content-center">

<div class="container">

<div class="row justify-content-center">

<div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">

<div class="card shadow login-card">

<div class="card-body">

<!-- LOGO -->

<div class="text-center mb-4">

<img src="{{ asset('assets/images/pdmt_logo.png') }}"
class="img-fluid login-logo"
alt="PDMT">

<h5 class="fw-bold mt-3 login-title">
Provincial Department of Motor Traffic
</h5>

<div class="text-muted login-subtitle">
Northern Province
</div>

<p class="fw-semibold mt-2 mb-0 login-system">
Digital Feedback Management System
</p>

<small class="text-muted">
Please sign in to continue
</small>

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


<button type="submit"
class="btn btn-primary w-100 mb-3">

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


<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>