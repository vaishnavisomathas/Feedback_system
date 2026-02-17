<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Feedback</title>

    <link rel="shortcut icon" type="image/png" href="/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="/assets/css/styles.min.css" />

    <style>
        @media (max-width: 576px) {
            .rating-grid {
                display: flex;
                justify-content: space-between;
                gap: 0.3rem;
            }
            .rating-button {
                flex: 1;
                padding: 0.6rem 0.25rem;
            }
            .rating-button span {
                font-size: 22px;
            }
            .rating-button small {
                font-size: 11px;
            }
        }
    </style>
</head>

<body>
<div class="page-wrapper" id="main-wrapper">

    <div class="position-relative overflow-hidden text-bg-light min-vh-100
                d-flex align-items-center justify-content-center">

        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-4">

                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        {{-- SUCCESS MESSAGE --}}
                        @if(session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- HEADER --}}
                        <div class="text-center mb-3">
                            <img src="/assets/img/npc_logo.png" height="45">
                            <h6 class="mt-2 fw-semibold">
                                Provincial Department Of Motor Traffic – NP
                            </h6>
                            <img src="/assets/img/pdmt_Logo.png" height="50" class="mt-2">
                        </div>

                        {{-- COUNTER INFO --}}
                        <div class="text-center mb-3">
                            <strong>Counter:</strong>
                            <span class="text-primary">
                                {{ $counter->division_name }} – {{ $counter->counter_name }}
                            </span>
                        </div>

                        <form method="POST" action="{{ route('feedback.store') }}">
                            @csrf
                            <input type="hidden" name="counter_id" value="{{ $counter->id }}">

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
        <label class="btn border rating-button {{ old('rating') == $value ? 'btn-warning' : 'btn-light' }}">
            <input type="radio" name="rating" value="{{ $value }}" hidden
                {{ old('rating') == $value ? 'checked' : '' }} onchange="toggleRating(this)">
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

    @error('service_quality_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                            {{-- COMPLAINT --}}
                            <div class="mb-3">
                                <label class="fw-semibold">Any complaint?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="has_complaint" value="yes"
                                           {{ old('has_complaint')=='yes'?'checked':'' }}>
                                    <label class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="has_complaint" value="no"
                                           {{ old('has_complaint')=='no'?'checked':'' }}>
                                    <label class="form-check-label">No</label>
                                </div>
                                @error('has_complaint') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            {{-- COMPLAINT DETAILS --}}
                            <div id="complaintDetails"
                                 style="{{ old('has_complaint')=='yes'?'display:block':'display:none' }}">

                                <div class="mb-3">
                                    <label>Phone</label>
                                    <input type="tel" class="form-control"
                                           name="phone" maxlength="10"
                                           value="{{ old('phone') }}">
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Vehicle Number</label>
                                    <input type="text" class="form-control text-uppercase"
                                           name="vehicle_number"
                                           value="{{ old('vehicle_number') }}">
                                </div>

                                <div class="mb-3">
                                    <label>Complaint</label>
                                    <textarea class="form-control"
                                              name="note" rows="3"
                                              maxlength="300">{{ old('note') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-2">
                                Submit Feedback
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script src="/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="has_complaint"]');
    const details = document.getElementById('complaintDetails');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            details.style.display = radio.value === 'yes' ? 'block' : 'none';
        });
    });
});
function toggleRating(input) {
    document.querySelectorAll('.rating-button').forEach(label => {
        label.classList.remove('btn-warning');
        label.classList.add('btn-light');
    });

    input.closest('label').classList.add('btn-warning');
    input.closest('label').classList.remove('btn-light');
}
</script>

</body>
</html>
