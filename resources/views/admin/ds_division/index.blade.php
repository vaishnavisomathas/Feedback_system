@extends('layouts.app')

@section('title')
DS Divisions QR - PDMT
@endsection

@section('content')
<style>
    .table td,
    .table th {
        font-size: 14px;
        vertical-align: middle;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #ced4da !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 38px !important;
        color: #374151 !important;
        padding-left: 8px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
        right: 8px !important;
    }

    .select2-dropdown {
        border: 1px solid #ced4da !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
    }

    .common-qr-row {
        background: #f0f6ff !important;
        border-left: 4px solid #2d66d4 !important;
    }

    .common-qr-row:hover {
        background: #e6f0ff !important;
    }

    @media (max-width:768px) {
        h2 {
            font-size: 20px;
        }

        .table td,
        .table th {
            font-size: 12px;
            padding: 6px;
        }

        img {
            max-width: 120px;
        }
    }
</style>

<div class="container-fluid px-0">

    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="fw-bold mb-1">DS Divisions</h2>
    </div>

    <!-- Search Form Filters -->
    <form method="GET" action="" class="mb-3 row g-2 align-items-center">
        <div class="col-md-3">
            <select name="district" class="form-select select2-district" onchange="this.form.submit()">
                <option value="">-- All Districts --</option>
                @foreach($districts as $d)
                <option value="{{ $d }}" {{ request('district') == $d ? 'selected' : '' }}>
                    {{ $d }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="counter" class="form-select select2-counter" onchange="this.form.submit()">
                <option value="">-- All Counters --</option>
                @foreach($counterOptions as $cOpt)
                <option value="{{ $cOpt->id }}" {{ ($selectedCounter ?? '') == $cOpt->id ? 'selected' : '' }}>
                    {{ $cOpt->division_name }} – {{ $cOpt->counter_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <a href="{{ url()->current() }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center" style="height: 38px; width: 38px;" title="Reset Filters">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </form>

    <!-- Table Card -->
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card table-card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <span class="fw-bold text-dark">
                        <i class="bi bi-grid-3x3-gap text-primary me-2"></i>DS Divisions Counters
                    </span>
                    <span class="badge bg-light text-secondary border px-2.5 py-1.5">
                        Total: {{ $counters->total() }} Counters
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table dashboard-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>District</th>
                                <th>DS Division</th>
                                <th>Counter</th>
                                <th>QR Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Pinned Common QR Row (Shown when no specific counter filter is selected) -->
                            @if(!request('counter') && !request('search'))
                            <tr class="common-qr-row">
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill px-2 py-1">Common</span>
                                </td>
                                <td class="fw-bold text-primary">
                                    <i class="bi bi-building me-1"></i> Northern Province
                                </td>
                                <td class="fw-bold text-dark">
                                    All Divisions
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">
                                        General (Searchable Dropdown)
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#commonQrModal">
                                        <i class="bi bi-qr-code"></i> View Common QR
                                    </button>
                                    <a href="{{ route('ds-divisions.commonQrPdf') }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1 ms-1" target="_blank" title="Download PDF">
                                        <i class="bi bi-download"></i> PDF
                                    </a>
                                </td>
                            </tr>
                            @endif

                            <!-- Individual Counter Rows -->
                            @forelse($counters as $index => $counter)
                            <tr>
                                <td>
                                    {{ ($counters->currentPage() - 1) * $counters->perPage() + $index + 1 }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $counter->district }}
                                </td>
                                <td>
                                    {{ $counter->division_name }}
                                </td>
                                <td>
                                    {{ $counter->counter_name }}
                                </td>
                                <td>
                                    @if(stripos($counter->counter_name, 'online') !== false || stripos($counter->division_name, 'online') !== false)
                                        <span class="badge bg-light text-secondary border px-2.5 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-globe text-primary"></i> Online (No QR Needed)
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('generateQr') }}">
                                            @csrf
                                            <input type="hidden" name="counter_id" value="{{ $counter->id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-primary mb-2">
                                                <i class="bi bi-qr-code"></i> Generate QR
                                            </button>
                                        </form>

                                        @if(session('selectedCounter') && session('selectedCounter')->id === $counter->id)
                                        <div class="mt-2 p-2 bg-light rounded border d-inline-block">
                                            <img src="{{ session('generatedQr') }}" style="max-width:120px" class="d-block mb-2">
                                            <input class="form-control form-control-sm mb-2" readonly value="{{ session('generatedQrUrl') }}">
                                            <a href="{{ route('ds-divisions.downloadQrPdf', $counter->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-download"></i> Download QR PDF
                                            </a>
                                        </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No counters found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
        <form method="GET" class="d-flex align-items-center mb-2">
            @foreach(request()->except('per_page','page') as $key => $value)
                @if(is_array($value))
                    @foreach($value as $v)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach

            <select name="per_page" class="form-control" onchange="this.form.submit()">
                @foreach([10, 20, 50, 100] as $size)
                <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                    Show {{ $size }}
                </option>
                @endforeach
            </select>
        </form>

        <div class="mb-2">
            {{ $counters->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Common QR Modal -->
    <div class="modal fade" id="commonQrModal" tabindex="-1" aria-labelledby="commonQrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow border-0" style="border-radius: 12px;">
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center" id="commonQrModalLabel">
                        <i class="bi bi-qr-code text-primary me-2 fs-4"></i> Common Feedback QR Code
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="d-flex justify-content-center mb-2">
                        <span class="badge bg-primary text-white rounded-pill px-3 py-1.5 small">
                            Department Wide (All Counters)
                        </span>
                    </div>

                    <div class="p-3 bg-white rounded-3 shadow-sm d-inline-block border my-3" style="border-color: #e2e8f0 !important;">
                        {!! $commonQrSvg !!}
                    </div>

                   

                    <div class="text-start bg-light p-3 rounded border">
                        <label class="form-label small fw-semibold text-secondary mb-1">
                            <i class="bi bi-link-45deg"></i> Direct Feedback URL
                        </label>
                        <div class="input-group input-group-sm">
                            <input type="text" id="commonQrUrlInput" class="form-control" readonly value="{{ $commonQrUrl }}">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyCommonQrUrl()" title="Copy Link">
                                <i class="bi bi-clipboard"></i> Copy
                            </button>
                        </div>
                        <div id="copySuccessMsg" class="text-success small mt-1 d-none">
                            <i class="bi bi-check-circle-fill me-1"></i> Copied to clipboard!
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light py-2.5 justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <div class="d-flex gap-2">
                        <a href="{{ $commonQrUrl }}" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
                            <i class="bi bi-box-arrow-up-right"></i> Open Page
                        </a>
                        <a href="{{ route('ds-divisions.commonQrPdf') }}" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 shadow-sm" target="_blank">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    function copyCommonQrUrl() {
        const input = document.getElementById('commonQrUrlInput');
        input.select();
        navigator.clipboard.writeText(input.value);
        const msg = document.getElementById('copySuccessMsg');
        msg.classList.remove('d-none');
        setTimeout(() => msg.classList.add('d-none'), 2000);
    }

    $(document).ready(function() {
        $('.select2-district').select2({
            placeholder: "-- All Districts --",
            allowClear: true,
            width: '100%'
        });

        $('.select2-counter').select2({
            placeholder: "-- All Counters --",
            allowClear: true,
            width: '100%'
        });

        // Reset counter when district changes
        $('select[name="district"]').on('change', function() {
            $('select[name="counter"]').val('').trigger('change');
        });
    });
</script>
@endsection
