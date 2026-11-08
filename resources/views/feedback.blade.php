<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <title>Service Feedback - PDMT Northern Province</title>

  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/pdmt_logo.png') }}">

  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/assets/css/styles.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

  <style>
    :root {
      --font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      --gov-navy-900: #0a192f;
      --gov-navy-800: #0f274a;
      --gov-blue-600: #1d4ed8;
      --gov-blue-500: #2563eb;
      --gov-gold-500: #f59e0b;
      --card-radius: 18px;
    }

    body {
      margin: 0;
      min-height: 100vh;
      background: linear-gradient(180deg, #edf2f9 0%, #e2e8f0 100%);
      font-family: var(--font-family);
      color: #1e293b;
      -webkit-font-smoothing: antialiased;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 20px 12px;
    }

    .feedback-card {
      border: 1px solid rgba(226, 232, 240, 0.9);
      border-radius: var(--card-radius);
      box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08), 0 3px 10px rgba(15, 23, 42, 0.03);
      overflow: hidden;
      background: #ffffff;
      max-width: 580px;
      margin: 0 auto;
      width: 100%;
    }

    /* HEADER BANNER */
    .civic-header {
      background: linear-gradient(135deg, #071329 0%, #0f274a 60%, #1e3a8a 100%);
      color: #ffffff;
      padding: 20px 18px;
      border-bottom: 3px solid #f59e0b;
      position: relative;
    }

    .civic-header-logos {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    .civic-logo-img {
      width: 48px;
      height: 48px;
      object-fit: contain;
      background: #ffffff;
      border-radius: 50%;
      padding: 4px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
      flex-shrink: 0;
    }

    .civic-header-text {
      text-align: center;
      flex: 1;
    }

    .civic-title-main {
      font-size: 15px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.2px;
      margin: 0;
      line-height: 1.25;
    }

    .civic-title-sub {
      font-size: 12px;
      font-weight: 600;
      color: #93c5fd;
      margin-top: 2px;
    }

    .civic-trilingual {
      font-size: 10.5px;
      color: #cbd5e1;
      margin-top: 4px;
      line-height: 1.3;
    }

    .card-body-content {
      padding: 24px;
    }

    /* COUNTER PILL */
    .counter-hero-pill {
      background: #eff6ff;
      border: 1px solid #bfdbfe;
      border-radius: 12px;
      padding: 12px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 22px;
    }

    .counter-hero-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #2563eb;
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }

    .counter-hero-label {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      color: #1d4ed8;
      letter-spacing: 0.5px;
    }

    .counter-hero-name {
      font-size: 15px;
      font-weight: 800;
      color: #0f172a;
    }

    /* SECTION LABELS */
    .field-section-title {
      font-size: 13.5px;
      font-weight: 800;
      color: #0f172a;
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 8px;
    }

    .field-section-subtitle {
      font-size: 12px;
      color: #64748b;
      margin-top: -4px;
      margin-bottom: 12px;
    }

    /* RATING BUTTONS GRID */
    .rating-row-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 8px;
      margin-bottom: 22px;
    }

    .rating-card-btn {
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      padding: 12px 4px;
      text-align: center;
      cursor: pointer;
      background: #ffffff;
      transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      user-select: none;
    }

    .rating-card-btn:hover {
      border-color: #93c5fd;
      background: #f8fafc;
      transform: translateY(-2px);
    }

    .rating-emoji {
      font-size: 26px;
      line-height: 1;
      margin-bottom: 6px;
      transition: transform 0.2s ease;
    }

    .rating-label-en {
      font-size: 11.5px;
      font-weight: 700;
      color: #334155;
      line-height: 1.1;
    }

    .rating-label-sub {
      font-size: 9.5px;
      font-weight: 600;
      color: #64748b;
      margin-top: 2px;
    }

    /* ACTIVE RATING STYLES */
    .rating-card-btn.active-rating {
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .rating-card-btn.active-rating[data-score="5"] {
      border-color: #10b981;
      background: #ecfdf5;
    }
    .rating-card-btn.active-rating[data-score="5"] .rating-label-en { color: #065f46; }

    .rating-card-btn.active-rating[data-score="4"] {
      border-color: #3b82f6;
      background: #eff6ff;
    }
    .rating-card-btn.active-rating[data-score="4"] .rating-label-en { color: #1e40af; }

    .rating-card-btn.active-rating[data-score="3"] {
      border-color: #f59e0b;
      background: #fffbeb;
    }
    .rating-card-btn.active-rating[data-score="3"] .rating-label-en { color: #92400e; }

    .rating-card-btn.active-rating[data-score="2"] {
      border-color: #f97316;
      background: #fff7ed;
    }
    .rating-card-btn.active-rating[data-score="2"] .rating-label-en { color: #9a3412; }

    .rating-card-btn.active-rating[data-score="1"] {
      border-color: #ef4444;
      background: #fef2f2;
    }
    .rating-card-btn.active-rating[data-score="1"] .rating-label-en { color: #991b1b; }

    /* FORM CONTROLS */
    .form-control,
    .form-select {
      border-radius: 10px;
      border: 1px solid #cbd5e1;
      font-size: 14px;
      min-height: 44px;
      color: #0f172a;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    /* SELECT2 CUSTOMIZATION */
    .select2-container .select2-selection--single {
      height: 46px !important;
      border: 1px solid #cbd5e1 !important;
      border-radius: 10px !important;
      display: flex !important;
      align-items: center !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 44px !important;
      padding-left: 12px !important;
      font-size: 14px !important;
      color: #0f172a !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 44px !important;
      right: 12px !important;
    }

    /* COMPLAINT TOGGLE ACCORDION */
    .complaint-toggle-card {
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 12px 16px;
      background: #f8fafc;
      transition: all 0.2s ease;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 16px;
    }

    .complaint-toggle-card.active-complaint {
      border-color: #93c5fd;
      background: #eff6ff;
    }

    .complaint-details-box {
      border: 1px solid #bfdbfe;
      border-radius: 14px;
      background: #f8fafc;
      padding: 18px;
      margin-bottom: 20px;
      animation: fadeIn 0.25s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-6px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* SUBMIT BUTTON */
    .btn-submit-feedback {
      height: 50px;
      border-radius: 12px;
      background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
      border: none;
      color: #ffffff;
      font-size: 15.5px;
      font-weight: 700;
      letter-spacing: -0.2px;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-submit-feedback:hover {
      background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
      box-shadow: 0 6px 18px rgba(37, 99, 235, 0.45);
      color: #ffffff;
      transform: translateY(-1px);
    }

    @media (max-width: 576px) {
      .card-body-content {
        padding: 18px 14px;
      }

      .rating-row-grid {
        gap: 5px;
      }

      .rating-card-btn {
        padding: 10px 2px;
      }

      .rating-emoji {
        font-size: 22px;
      }

      .rating-label-en {
        font-size: 10.5px;
      }

      .civic-title-main {
        font-size: 13.5px;
      }

      .civic-logo-img {
        width: 40px;
        height: 40px;
      }
    }
  </style>
</head>

<body>

  <div class="feedback-card">

    <!-- CIVIC OFFICIAL HEADER -->
    <div class="civic-header">
      <div class="civic-header-logos">
        <img src="{{ asset('assets/images/npc_logo.png') }}" class="civic-logo-img" alt="Northern Provincial Council">

        <div class="civic-header-text">
          <h1 class="civic-title-main">Provincial Department of Motor Traffic</h1>
          <div class="civic-title-sub">Northern Province &bull; Sri Lanka</div>
          <div class="civic-trilingual">
            மாகாண மோட்டார் போக்குவரத்துத் திணைக்களம் &bull; පළාත් මෝටර් රථ ප්‍රවාහන දෙපාර්තමේන්තුව
          </div>
        </div>

        <img src="{{ asset('assets/images/pdmt_logo.png') }}" class="civic-logo-img" alt="PDMT Emblem">
      </div>
    </div>

    <!-- CARD BODY -->
    <div class="card-body-content">

      {{-- Success Banner --}}
      @if(session('success'))
      <div class="alert alert-success d-flex align-items-center gap-2 mb-3 rounded-3" role="alert">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <div>{{ session('success') }}</div>
      </div>
      @endif

      <form method="POST" action="{{ route('feedback.store') }}" id="feedbackForm">
        @csrf

        <input type="hidden" name="feedback_token" value="{{ $feedback_token }}">
        <input type="hidden" name="has_complaint" id="hasComplaintValue" value="no">

        {{-- COUNTER SPECIFICATION --}}
        @if(isset($counter) && $counter)
          {{-- Specific Counter Scanned --}}
          <input type="hidden" name="counter_id" value="{{ $counter->id }}">

          <div class="counter-hero-pill">
            <div class="counter-hero-icon">
              <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div>
              <div class="counter-hero-label">Service Counter Location</div>
              <div class="counter-hero-name">
                {{ $counter->division_name }} – {{ $counter->counter_name }}
              </div>
            </div>
          </div>
        @else
          {{-- Common QR: Searchable Dropdown --}}
          <div class="mb-4">
            <label class="field-section-title" for="counter_id">
              <i class="bi bi-building text-primary"></i>
              <span>Select Counter <span class="text-danger">*</span></span>
            </label>
            <div class="field-section-subtitle">
              Choose the service counter or online service you visited today
            </div>

            <select class="form-select select2" name="counter_id" id="counter_id" required>
              <option value="">-- Search &amp; Select Counter --</option>
              @php
                $groupedCounters = isset($counters) ? $counters->groupBy('district') : collect();
              @endphp
              @foreach($groupedCounters as $districtName => $divisionCounters)
                @php
                  $isProvinceWide = in_array(strtolower($districtName), ['northern province', 'province', 'online', 'online services', 'head office', 'pdmt']) || str_ends_with(strtolower($districtName), 'district') || str_ends_with(strtolower($districtName), 'province');
                  $groupLabel = $isProvinceWide ? $districtName : $districtName . ' District';
                @endphp
                <optgroup label="{{ $groupLabel }}">
                  @foreach($divisionCounters as $cntr)
                    @php
                      $isOnlineOrNamed = stripos($cntr->counter_name, 'online') !== false || strlen($cntr->counter_name) > 2;
                      $displayCounterLabel = $isOnlineOrNamed ? $cntr->counter_name : 'Counter ' . $cntr->counter_name;
                    @endphp
                    <option value="{{ $cntr->id }}" {{ (old('counter_id') == $cntr->id || (request('counter_id') == $cntr->id)) ? 'selected' : '' }}>
                      {{ $cntr->division_name }} - {{ $displayCounterLabel }}
                    </option>
                  @endforeach
                </optgroup>
              @endforeach
            </select>
            @error('counter_id')
              <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
          </div>
        @endif

        {{-- 1. RATING SELECTION (1-5) --}}
        <div class="mb-4">
          <label class="field-section-title">
            <i class="bi bi-star-fill text-warning"></i>
            <span>Rate Your Service Experience <span class="text-danger">*</span></span>
          </label>
          <div class="field-section-subtitle">
            Please tap to select how satisfied you were with the service provided
          </div>

          <div class="rating-row-grid">
            @foreach([
              5 => ['😍', 'Excellent', 'விசேடம்', 'විශිෂ්ටයි'],
              4 => ['😊', 'Good', 'நன்று', 'හොඳයි'],
              3 => ['😐', 'Average', 'சராசரி', 'සාමාන්‍යයි'],
              2 => ['🙁', 'Poor', 'மோசம்', 'දුර්වලයි'],
              1 => ['😡', 'Very Poor', 'மிக மோசம்', 'ඉතා දුර්වල'],
            ] as $score => [$emoji, $labelEn, $labelTa, $labelSi])
              <label class="rating-card-btn {{ old('rating') == $score ? 'active-rating' : '' }}" data-score="{{ $score }}">
                <input type="radio" name="rating" value="{{ $score }}" hidden {{ old('rating') == $score ? 'checked' : '' }} onchange="handleRatingSelection(this)">
                <div class="rating-emoji">{{ $emoji }}</div>
                <div class="rating-label-en">{{ $labelEn }}</div>
                <div class="rating-label-sub">{{ $labelTa }}</div>
              </label>
            @endforeach
          </div>
          @error('rating')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
        </div>

        {{-- 2. SERVICE QUALITY FACTOR --}}
        <div class="mb-4">
          <label class="field-section-title" for="service_quality_id">
            <i class="bi bi-check2-circle text-primary"></i>
            <span>Primary Reason / Service Quality <span class="text-danger">*</span></span>
          </label>
          <div class="field-section-subtitle">
            What was the primary factor behind your rating?
          </div>

          <select class="form-select" name="service_quality_id" id="service_quality_id" required>
            <option value="">-- Select Service Factor --</option>
            @foreach($qualities as $quality)
              <option value="{{ $quality->id }}" {{ old('service_quality_id') == $quality->id ? 'selected' : '' }}>
                {{ $quality->name }}
              </option>
            @endforeach
          </select>
          @error('service_quality_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
        </div>

        {{-- 3. CITIZEN COMPLAINT / SUGGESTION ACCORDION --}}
        <div class="mb-3">
          <div class="complaint-toggle-card" id="complaintToggleCard">
            <input class="form-check-input mt-0" type="checkbox" id="hasComplaint" {{ old('has_complaint') === 'yes' ? 'checked' : '' }}>
            <label class="form-check-label mb-0 fw-bold small text-dark" for="hasComplaint" style="cursor: pointer;">
              Do you have a specific complaint or grievance to register?
            </label>
          </div>

          {{-- Expandable Complaint Details Drawer --}}
          <div id="complaintDetails" class="complaint-details-box" style="display: none;">
            <div class="d-flex align-items-center gap-2 mb-3 text-primary">
              <i class="bi bi-shield-exclamation fs-5"></i>
              <span class="fw-bold small">Official Grievance Redressal Form</span>
            </div>

            <!-- Phone -->
            <div class="mb-3">
              <label class="form-label fw-bold small text-secondary">
                Citizen Mobile Number <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-phone"></i></span>
                <input type="tel"
                       class="form-control @error('phone') is-invalid @enderror"
                       name="phone"
                       id="phoneInput"
                       placeholder="07XXXXXXXX"
                       value="{{ old('phone') }}"
                       maxlength="10">
              </div>
              <small class="text-muted" style="font-size: 11px;">Enter a valid 10-digit Sri Lankan phone number (e.g. 0771234567)</small>
              @error('phone')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Email (Optional) -->
            <div class="mb-3">
              <label class="form-label fw-bold small text-secondary">
                Email Address <span class="text-muted fw-normal">(Optional)</span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                <input type="email"
                       class="form-control @error('complaint_email') is-invalid @enderror"
                       name="complaint_email"
                       placeholder="citizen@example.com"
                       value="{{ old('complaint_email') }}">
              </div>
              @error('complaint_email')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Vehicle Number -->
            <div class="mb-3">
              <label class="form-label fw-bold small text-secondary">
                Vehicle Registration Number <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-car-front"></i></span>
                <input type="text"
                       class="form-control text-uppercase @error('vehicle_number') is-invalid @enderror"
                       name="vehicle_number"
                       placeholder="e.g. NP CAH-9891 or 65-1234"
                       value="{{ old('vehicle_number') }}"
                       maxlength="12">
              </div>
              @error('vehicle_number')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>

            <!-- Complaint Note -->
            <div class="mb-2">
              <label class="form-label fw-bold small text-secondary">
                Description of Complaint / Issue <span class="text-danger">*</span>
              </label>
              <textarea class="form-control @error('note') is-invalid @enderror"
                        name="note"
                        id="noteTextarea"
                        rows="3"
                        maxlength="300"
                        placeholder="Please describe the issue faced at the counter...">{{ old('note') }}</textarea>
              <div class="d-flex justify-content-between text-muted mt-1" style="font-size: 11px;">
                <span>Maximum 300 characters</span>
                <span id="charCounter">0 / 300</span>
              </div>
              @error('note')
                <div class="text-danger small mt-1">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        {{-- SUBMIT BUTTON --}}
        <button type="submit" class="btn btn-submit-feedback w-100" id="submitFeedbackBtn">
          <span>Submit Official Feedback</span>
          <i class="bi bi-arrow-right"></i>
        </button>

      </form>

      <div class="text-center mt-4 pt-3 border-top">
        <small class="text-muted d-block" style="font-size: 11.5px;">
          Provincial Department of Motor Traffic &bull; Northern Provincial Council
        </small>
        <small class="text-secondary" style="font-size: 10.5px;">
          Your feedback is kept confidential and directly monitors departmental service standards.
        </small>
      </div>

    </div>

  </div>

  <!-- SCRIPTS -->
  <script src="/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    @if(!session('rating_access'))
      window.location.href = "{{ route('feedback.closed') }}";
    @endif

    const qualities = @json($qualities);
    const oldServiceQualityId = @json(old('service_quality_id'));
    const qualitySelect = document.getElementById('service_quality_id');

    $(document).ready(function() {
      if ($('#counter_id').length) {
        $('#counter_id').select2({
          placeholder: '-- Search & Select Counter --',
          allowClear: true,
          width: '100%'
        });
      }

      $('#feedbackForm').on('submit', function(e) {
        if ($('#counter_id').length && !$('#counter_id').val()) {
          e.preventDefault();
          alert('Please select a counter before submitting your feedback.');
          $('#counter_id').select2('open');
          return false;
        }

        const selectedRating = $('input[name="rating"]:checked').val();
        if (!selectedRating) {
          e.preventDefault();
          alert('Please tap to select a service rating from 1 to 5.');
          return false;
        }

        const submitBtn = document.getElementById('submitFeedbackBtn');
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Submitting Feedback...';
        }
      });
    });

    // Rating Selection & Dynamic Quality Population
    function loadServiceQualities(rating, selectedQualityId = null) {
      let type = '';
      const r = parseInt(rating);
      if (r === 5 || r === 4) {
        type = 'good';
      } else if (r === 3) {
        type = 'average';
      } else if (r === 2 || r === 1) {
        type = 'bad';
      }

      qualitySelect.innerHTML = '<option value="">-- Select Service Factor --</option>';

      const filtered = qualities.filter(q => q.type === type);
      filtered.forEach(q => {
        const opt = document.createElement('option');
        opt.value = q.id;
        opt.textContent = q.name;
        if (selectedQualityId !== null && String(selectedQualityId) === String(q.id)) {
          opt.selected = true;
        }
        qualitySelect.appendChild(opt);
      });

      if (filtered.length === 0) {
        qualitySelect.innerHTML = '<option value="">No specific quality factors listed</option>';
      }
    }

    function handleRatingSelection(input) {
      document.querySelectorAll('.rating-card-btn').forEach(btn => btn.classList.remove('active-rating'));
      const parentLabel = input.closest('.rating-card-btn');
      if (parentLabel) {
        parentLabel.classList.add('active-rating');
      }
      loadServiceQualities(input.value);
    }

    // Init active rating if old value exists
    const initialRating = document.querySelector('input[name="rating"]:checked');
    if (initialRating) {
      loadServiceQualities(initialRating.value, oldServiceQualityId);
    }

    // Complaint Accordion Handling
    const complaintCheckbox = document.getElementById('hasComplaint');
    const complaintHidden = document.getElementById('hasComplaintValue');
    const complaintDetails = document.getElementById('complaintDetails');
    const complaintCard = document.getElementById('complaintToggleCard');

    function toggleComplaintBox(checked) {
      complaintDetails.style.display = checked ? 'block' : 'none';
      complaintHidden.value = checked ? 'yes' : 'no';
      complaintCard.classList.toggle('active-complaint', checked);
    }

    if (complaintCheckbox) {
      complaintCheckbox.addEventListener('change', function() {
        toggleComplaintBox(this.checked);
      });
    }

    @if(old('has_complaint') === 'yes' || $errors->has('phone') || $errors->has('complaint_email') || $errors->has('vehicle_number') || $errors->has('note'))
      if (complaintCheckbox) {
        complaintCheckbox.checked = true;
        toggleComplaintBox(true);
      }
    @endif

    // Phone Auto-formatting
    const phoneInput = document.getElementById('phoneInput');
    if (phoneInput) {
      phoneInput.addEventListener('input', function(e) {
        let val = e.target.value.replace(/\D/g, '');
        if (val.startsWith('94')) {
          val = '0' + val.substring(2);
        }
        if (!val.startsWith('0') && val.length > 0) {
          val = '0' + val;
        }
        e.target.value = val.substring(0, 10);
      });
    }

    // Character Counter
    const noteTextarea = document.getElementById('noteTextarea');
    const charCounter = document.getElementById('charCounter');
    if (noteTextarea && charCounter) {
      function updateCharCount() {
        charCounter.textContent = `${noteTextarea.value.length} / 300`;
      }
      noteTextarea.addEventListener('input', updateCharCount);
      updateCharCount();
    }

    // Prevent Back Button Resubmission
    window.addEventListener("pageshow", function(event) {
      if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
        window.location.href = "{{ route('feedback.closed') }}";
      }
    });
  </script>

</body>
</html>
