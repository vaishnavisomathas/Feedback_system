<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Service Feedback</title>

  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/pdmt_logo.png') }}" />
  <link rel="stylesheet" href="/assets/css/styles.min.css" />

  <style>
    body {
      background: #f4f6f9;
    }
    .card { border-radius: 16px; }
    .rating-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 8px;
    }
    .rating-button {
      border-radius: 12px;
      padding: 10px 5px;
      text-align: center;
      transition: 0.3s;
      cursor: pointer;
      background: #fff;
    }
    .rating-button span { font-size: 26px; }
    .rating-button small { font-size: 12px; }
    .rating-button:hover {
      transform: scale(1.05);
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .active-rating {
      background: #ffc107 !important;
      color: #000;
      font-weight: 600;
    }
    .form-control, .form-select { border-radius: 10px; }
    .submit-btn { border-radius: 12px; padding: 10px; font-weight: 600; }
    .header-box { background: #fff; border-radius: 12px; padding: 10px; }
    /* MOBILE */
    @media (max-width: 576px) {
      .rating-grid { gap: 4px; }
      .rating-button span { font-size: 22px; }
      .rating-button small { font-size: 10px; }
    }
  </style>
</head>

<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="col-md-8 col-lg-6 col-xxl-4">

    <div class="card shadow-sm">
      <div class="card-body p-4">

        {{-- SUCCESS --}}
        @if(session('success'))
          <div class="alert alert-success text-center">
            {{ session('success') }}
          </div>
        @endif

        {{-- HEADER --}}
        <div class="text-center mb-3 header-box">
          <img src="{{ asset('assets/images/npc_logo.png') }}" height="80" width="100">
          <h6 class="mt-2 fw-bold">
            Provincial Department Of Motor Traffic – NP
          </h6>
          <img src="{{ asset('assets/images/pdmt_logo.png') }}" height="50" width="50"class="mt-1">
        </div>

        {{-- COUNTER --}}
        <div class="text-center mb-3">
          <div class="p-2 rounded bg-light border">
            <strong>Counter:</strong>
            <span class="text-primary fw-semibold">
              {{ $counter->division_name }} – {{ $counter->counter_name }}
            </span>
          </div>
        </div>

        <form method="POST" action="{{ route('feedback.store') }}">
          @csrf

          <input type="hidden" name="counter_id" value="{{ $counter->id }}">
          <input type="hidden" name="feedback_token" value="{{ $feedback_token }}">
          <input type="hidden" name="has_complaint" id="hasComplaintValue" value="no">

          {{-- RATING --}}
          <div class="mb-3">
            <label class="fw-semibold">Service Rating</label>
            <div class="rating-grid mt-2">
              @foreach([
                5 => ['🤩','Excellent'],
                4 => ['😊','Good'],
                3 => ['😐','Average'],
                2 => ['😕','Poor'],
                1 => ['😡','Bad'],
              ] as $value => [$emoji,$label])
                <label class="rating-button border {{ old('rating') == $value ? 'active-rating' : '' }}">
                  <input type="radio" name="rating" value="{{ $value }}" hidden
                    {{ old('rating') == $value ? 'checked' : '' }}
                    onchange="toggleRating(this)">
                  <span>{{ $emoji }}</span><br>
                  <small>{{ $label }}</small>
                </label>
              @endforeach
            </div>
            @error('rating') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- SERVICE QUALITY --}}
          <div class="mb-3">
            <label class="fw-semibold">Quality of Service</label>
            <select class="form-control" name="service_quality_id">
              <option value="">-- Select --</option>
              @foreach($qualities as $quality)
                <option value="{{ $quality->id }}"
                  {{ old('service_quality_id', $feedback->service_quality_id ?? '') == $quality->id ? 'selected' : '' }}>
                  {{ $quality->name }}
                </option>
              @endforeach
            </select>
            @error('service_quality_id') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- COMPLAINT --}}
          <div class="mb-3">
            <label class="fw-semibold">Any complaint?</label>
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" id="hasComplaint">
              <label class="form-check-label">Yes</label>
            </div>
            @error('has_complaint') <small class="text-danger">{{ $message }}</small> @enderror
          </div>

          {{-- COMPLAINT DETAILS --}}
          <div id="complaintDetails" class="border rounded p-3 bg-light" style="display:none;">
            <div class="mb-2">
              <label>Phone</label>
              <input type="tel" class="form-control" name="phone" maxlength="10" value="{{ old('phone') }}">
            </div>
            <div class="mb-2">
              <label>Vehicle Number</label>
              <input type="text" class="form-control text-uppercase" name="vehicle_number" value="{{ old('vehicle_number') }}">
            </div>
            <div class="mb-2">
              <label>Complaint</label>
              <textarea class="form-control" name="note" rows="3" maxlength="300">{{ old('note') }}</textarea>
            </div>
          </div>

          {{-- SUBMIT --}}
          <button type="submit" class="btn btn-primary w-100 submit-btn mt-3">
            🚀 Submit Feedback
          </button>
        </form>

      </div>
    </div>

  </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script>
     @if(!session('rating_access'))
    window.location.href = "{{ route('feedback.closed') }}";
@endif
  const checkbox = document.getElementById('hasComplaint');
  const hiddenInput = document.getElementById('hasComplaintValue');
  checkbox.addEventListener('change', function () {
    document.getElementById('complaintDetails').style.display = this.checked ? 'block' : 'none';
    hiddenInput.value = this.checked ? 'yes' : 'no';
  });

  function toggleRating(input) {
    document.querySelectorAll('.rating-button').forEach(btn => btn.classList.remove('active-rating'));
    input.closest('label').classList.add('active-rating');
  }

</script>

</body>
</html>