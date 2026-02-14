<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Thank You</title>

<link rel="stylesheet" href="/assets/css/styles.min.css" />

<style>
.center-box{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f6f9fc;
}
.icon{
    font-size:60px;
}
</style>
</head>

<body>

<div class="center-box">
    <div class="col-md-6 col-lg-4">

        <div class="card shadow-sm border-0 text-center">
            <div class="card-body p-5">

                <div class="text-success icon mb-3">✔</div>

                <h3 class="fw-bold text-success">Thank You!</h3>

                <p class="text-muted mt-2">
                    Your feedback has been recorded successfully.
                </p>

                <p class="small text-secondary">
                    To give another rating, please scan the QR code again.
                </p>

            </div>
        </div>

    </div>
</div>

<script>
// prevents back button form resubmit
window.history.replaceState(null, null, window.location.href);
</script>

</body>
</html>
