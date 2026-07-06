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
      margin: 0;
      min-height: 100vh;
      background: #e9edf3;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      color: #2f3743;
    }

    .form-panel {
      border: 1px solid #d8dee8;
      border-radius: 10px;
      box-shadow: 0 8px 24px rgba(17, 24, 39, 0.08);
      overflow: hidden;
    }

    .panel-body {
      padding: 1.25rem;
      background: #ffffff;
    }

    .form-title {
      margin: 0;
      font-size: 28px;
      line-height: 1;
      font-weight: 900;
      letter-spacing: 0.8px;
      color: #212733;
    }

    .form-subtitle {
      margin: 8px 0 0;
      color: #5b6574;
      font-size: 13px;
      font-weight: 600;
    }

    .header-box {
      background: #f4f7fb;
      border: 1px solid #d7dfeb;
      border-radius: 10px;
      padding: 10px;
      gap: 10px;
    }

    .header-logo {
      height: 44px;
      width: auto;
      object-fit: contain;
    }

    .header-title {
      margin: 0;
      line-height: 1.2;
      color: #2e394b;
      font-size: 13px;
      letter-spacing: 0;
    }

    .counter-pill {
      border: 1px solid #d3dbe8;
      border-radius: 10px;
      background: #f7f9fc;
      padding: 10px;
      color: #344154;
      font-weight: 600;
      text-align: center;
    }

    .counter-pill .counter-name {
      color: #2d57b8;
      font-weight: 700;
    }

    .section-label {
      font-size: 0.95rem;
      font-weight: 800;
      color: #303b4d;
      margin-bottom: 8px;
    }

    .rating-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 10px;
    }

    .rating-button {
      border: 1px solid #d8dee8;
      border-radius: 10px;
      padding: 10px 6px;
      text-align: center;
      transition: border-color 0.2s ease, background-color 0.2s ease;
      cursor: pointer;
      background: #fdfefe;
    }

    .rating-button span {
      font-size: 25px;
      display: block;
      line-height: 1;
      margin-bottom: 6px;
    }

    .rating-button small {
      font-size: 12px;
      font-weight: 700;
      color: #4d5c73;
    }

    .rating-button:hover {
      border-color: #95aad1;
      background: #f4f8ff;
    }

    .active-rating {
      background: #e9f0ff !important;
      border-color: #2f6de2 !important;
    }

    .form-control,
    .form-select {
      border-radius: 10px;
      border-color: #cfd7e4;
      min-height: 42px;
      color: #1f2a3a;
      background: #ffffff;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #3970dc;
      box-shadow: 0 0 0 0.16rem rgba(57, 112, 220, 0.18);
    }

    .complaint-toggle {
      display: flex;
      align-items: center;
      gap: 10px;
      border: 1px solid #d2d9e4;
      border-radius: 10px;
      padding: 8px 12px;
      background: #f8fafe;
      width: 100%;
      min-height: 44px;
    }

    .complaint-toggle .form-check-input {
      margin-top: 0;
      flex: 0 0 auto;
    }

    .complaint-toggle .form-check-label {
      font-weight: 700;
      color: #5d6b80;
      line-height: 1.25;
    }

    .complaint-toggle.active-complaint {
      border-color: #2f6de2 !important;
      background: #e9f0ff !important;
    }

    .complaint-toggle.active-complaint .form-check-label {
      color: #1e45a8;
    }

    #complaintDetails {
      border: 1px solid #d8dee8 !important;
      border-radius: 10px !important;
      background: #f6f9fd !important;
    }

    .submit-btn {
      border: 0;
      border-radius: 10px;
      padding: 12px;
      font-weight: 700;
      font-size: 16px;
      letter-spacing: 0.2px;
      background: #2d66d4;
      box-shadow: none;
      transition: background-color 0.2s ease;
    }

    .submit-btn:hover {
      background: #2458bd;
    }

    /* MOBILE */
    @media (max-width: 576px) {
      .panel-body {
        padding: 1rem;
      }

      .rating-grid {
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 6px;
      }

      .rating-button span {
        font-size: 20px;
      }

      .rating-button small {
        font-size: 10px;
      }

      .header-logo {
        height: 36px;
      }

      .header-title {
        font-size: 12px;
      }

      .complaint-toggle .form-check-label {
        font-size: 13px;
      }

      .submit-btn {
        font-size: 15px;
      }
    }
  </style>
</head>

<body>
<div class="container d-flex align-items-center justify-content-center min-vh-100 py-4">
  <div class="col-md-8 col-lg-6 col-xxl-4">

    <div class="card form-panel">
      <div class="card-body panel-body">

    
        {{-- SUCCESS --}}
        @if(session('success'))
          <div class="alert alert-success text-center">
            {{ session('success') }}
          </div>
        @endif

        {{-- HEADER --}}
        
<div class="d-flex align-items-center justify-content-between mb-3 header-box text-center">
    
    <!-- Left Logo -->
    <img src="{{ asset('assets/images/npc_logo.png') }}" class="header-logo">

    <!-- Center Text -->
    <div class="flex-grow-1 px-2">
        <h6 class="fw-bold mb-0 header-title">
            Provincial Department Of Motor Traffic
      </h6>
        <h6 class="fw-bold mb-0 header-title">
            Northern Province
      </h6>
    </div>

    <!-- Right Logo -->
    <img src="{{ asset('assets/images/pdmt_logo.png') }}" class="header-logo">

</div>

        {{-- COUNTER --}}
        <div class="text-center mb-3">
          <div class="counter-pill">
            <strong>Counter:</strong>
            <span class="counter-name">
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
            <label class="section-label">Service Rating</label>
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
            <label class="section-label">Quality of Service</label>
            <select class="form-select" name="service_quality_id">
              <option value="">-- Select --</option>
              @foreach($qualities as $quality)
                <option value="{{ $quality->id }}"
                  {{ old('service_quality_id', $feedback->service_quality_id ?? '') == $quality->id ? 'selected' : '' }}>
                  {{ $quality->name }}
                </option>
              @endforeach
            </select>
            {{-- @error('service_quality_id') <small class="text-danger">{{ $message }}</small> @enderror --}}
          </div>

          {{-- COMPLAINT --}}
      <div class="mb-3">
            <label class="section-label">Any complaint?</label>
            <div class="form-check mt-2 complaint-toggle">
              <input class="form-check-input" type="checkbox" id="hasComplaint"
                {{ old('has_complaint') === 'yes' ? 'checked' : '' }}>
              <label class="form-check-label mb-0">Yes, I want to submit a complaint</label>
            </div>
          </div>

          {{-- COMPLAINT DETAILS --}}
          <div id="complaintDetails" class="border rounded p-3 bg-light" style="display:none;">
            <div class="mb-2">
              <label class="section-label">Phone</label>
<input type="tel" class="form-control" name="phone" placeholder="07XXXXXXXX" value="{{ old('phone') }}" maxlength="10">
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror

            </div>
            <div class="mb-2">
              <label class="section-label">Email (Optional)</label>
              <input type="email" class="form-control" name="complaint_email" placeholder="you@example.com" value="{{ old('complaint_email') }}">
              <small class="text-muted">Enter Your Email.</small>
              @error('complaint_email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="mb-2">
              <label class="section-label">Vehicle Number</label>
              <input type="text" class="form-control text-uppercase" name="vehicle_number" placeholder="CAH-9891/7-652" value="{{ old('vehicle_number') }}" maxlength="12" >
                          @error('vehicle_number') <small class="text-danger">{{ $message }}</small> @enderror

            </div>
            <div class="mb-2">
              <label class="section-label">Complaint</label>
              <textarea class="form-control" name="note" rows="3" maxlength="300">{{ old('note') }}</textarea>
                                        @error('note') <small class="text-danger">{{ $message }}</small> @enderror

            </div>
          </div>

          {{-- SUBMIT --}}
          <button type="submit" class="btn btn-primary w-100 submit-btn mt-3">
            Submit Feedback
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

// PHONE FORMAT
const phoneInput = document.querySelector('input[name="phone"]');

if (phoneInput) {
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');

        if (value.startsWith('94')) {
            value = '0' + value.substring(2);
        }

        if (!value.startsWith('0')) {
            value = '0' + value;
        }

        e.target.value = value.substring(0, 10);
    });
}

const checkbox = document.getElementById('hasComplaint');
const hiddenInput = document.getElementById('hasComplaintValue');
const complaintBox = document.getElementById('complaintDetails');
const complaintToggle = checkbox.closest('.complaint-toggle');

function updateComplaintCard(isChecked) {
    complaintBox.style.display = isChecked ? 'block' : 'none';
    hiddenInput.value = isChecked ? 'yes' : 'no';
    complaintToggle.classList.toggle('active-complaint', isChecked);
}

checkbox.addEventListener('change', function () {
    updateComplaintCard(this.checked);
});

// ✅ FIX: Only open if complaint was selected before
@if(old('has_complaint') === 'yes')
    checkbox.checked = true;
    updateComplaintCard(true);
@endif


@if($errors->has('phone') || $errors->has('complaint_email') || $errors->has('vehicle_number') || $errors->has('note'))
  checkbox.checked = true;
  updateComplaintCard(true);
  complaintBox.scrollIntoView({ behavior: 'smooth' });
@endif


function toggleRating(input) {
    document.querySelectorAll('.rating-button').forEach(btn => btn.classList.remove('active-rating'));
    input.closest('label').classList.add('active-rating');
}


window.addEventListener("pageshow", function (event) {
    if (event.persisted || performance.navigation.type === 2) {
        window.location.href = "{{ route('feedback.closed') }}";
    }
});

</script>

</body>
</html>