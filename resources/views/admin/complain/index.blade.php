@extends('layouts.app')

@section('title', 'QR Complaints Management - PDMT')

@section('content')
<style>
    .complaint-table {
        border: 1px solid #e2e8f0;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    .complaint-table .complaint-table-head th {
        background-color: #f8fafc;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        padding: 12px 14px;
        font-weight: 700;
        font-size: 13px;
    }

    .complaint-table td {
        font-size: 13.5px;
        border-top: 1px solid #f1f5f9;
        color: #475569;
        padding: 12px 14px;
    }

    .complaint-table tbody tr {
        cursor: pointer;
        transition: background-color 0.18s ease;
    }

    .complaint-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    [data-bs-theme="dark"] .complaint-table {
        border-color: #1e293b;
    }

    [data-bs-theme="dark"] .complaint-table .complaint-table-head th {
        background-color: #141e33;
        color: #cbd5e1;
        border-bottom-color: #1e293b;
    }

    [data-bs-theme="dark"] .complaint-table td {
        border-top-color: #1e293b;
        color: #94a3b8;
    }

    [data-bs-theme="dark"] .complaint-table tbody tr:hover td {
        background-color: #162238;
    }

    .nav-tabs .nav-link {
        font-weight: 600;
        color: #64748b;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 18px;
    }

    .nav-tabs .nav-link.active {
        color: #2563eb;
        border-bottom: 2px solid #2563eb;
        background: transparent;
    }
</style>

<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold mb-1" style="font-size: 22px;">Citizen Grievances &amp; Complaints</h2>
            <div class="text-muted small">QR-based citizen submissions requiring administrative review and investigation</div>
        </div>
        <div>
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterBox">
                <i class="bi bi-funnel me-1"></i> Filter Records <i class="bi bi-chevron-down ms-1" id="arrow"></i>
            </button>
        </div>
    </div>

    <!-- FILTER COLLAPSIBLE -->
    <div class="collapse {{ request()->hasAny(['division','counter','status','from','to','service_quality','rating','complain_type','search']) ? 'show' : '' }}" id="filterBox">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
            <div class="card-body p-3">
                <form method="GET" class="row g-2">
                    <input type="hidden" name="active_tab" id="active_tab" value="{{ request('active_tab','pending') }}">

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Division &amp; Counter</label>
                        <select name="counter" class="form-select form-select-sm">
                            <option value="">-- All Counters --</option>
                            @foreach($counters as $counterOption)
                            <option value="{{ $counterOption->id }}" {{ ($filters['counter'] ?? '') == $counterOption->id ? 'selected' : '' }}>
                                {{ $counterOption->division_name }} &bull; {{ $counterOption->counter_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Workflow Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending Review</option>
                            <option value="ao" {{ request('status')=='ao'?'selected':'' }}>Forwarded to A/O</option>
                            <option value="verified" {{ request('status')=='verified'?'selected':'' }}>Verified</option>
                            <option value="commissioner" {{ request('status')=='commissioner'?'selected':'' }}>Informed to Commissioner</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">From Date</label>
                        <input type="date" name="from" value="{{ request('from') }}" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">To Date</label>
                        <input type="date" name="to" value="{{ request('to') }}" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Search Keyword</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Vehicle number or citizen phone">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Service Quality</label>
                        <select name="service_quality" class="form-select form-select-sm">
                            <option value="">All Qualities</option>
                            @foreach($serviceQualities as $quality)
                            <option value="{{ $quality->id }}" {{ request('service_quality') == $quality->id ? 'selected' : '' }}>
                                {{ $quality->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Service Rating</label>
                        <select name="rating" class="form-select form-select-sm">
                            <option value="">All Ratings</option>
                            <option value="1" {{ request('rating')==1?'selected':'' }}>★ 1 - Bad</option>
                            <option value="2" {{ request('rating')==2?'selected':'' }}>★ 2 - Poor</option>
                            <option value="3" {{ request('rating')==3?'selected':'' }}>★ 3 - Average</option>
                            <option value="4" {{ request('rating')==4?'selected':'' }}>★ 4 - Good</option>
                            <option value="5" {{ request('rating')==5?'selected':'' }}>★ 5 - Excellent</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Complaint Classification</label>
                        <select name="complain_type" class="form-select form-select-sm">
                            <option value="">All Classifications</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ request('complain_type')==$type->id?'selected':'' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary btn-sm px-3">
                            <i class="bi bi-search me-1"></i> Apply Filters
                        </button>
                        <a href="{{ url()->current() }}" class="btn btn-light btn-sm border text-secondary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MAIN DATA CARD -->
    <div class="card shadow-sm border-0" style="border-radius: 14px;">
        <div class="card-body p-4">

            @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 mb-3 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <div>{{ session('success') }}</div>
            </div>
            @endif

            {{-- WORKFLOW TABS --}}
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <button class="nav-link {{ request('active_tab','pending') == 'pending' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#pending">
                        <i class="bi bi-clock-history me-1"></i> Pending Review
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link {{ request('active_tab') == 'closed' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#closed">
                        <i class="bi bi-archive me-1"></i> All Processed Complaints
                    </button>
                </li>
            </ul>

            <div class="tab-content">

                {{-- ================= TAB 1: PENDING COMPLAINTS ================= --}}
                <div class="tab-pane fade {{ request('active_tab','pending') == 'pending' ? 'show active' : '' }}" id="pending">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle complaint-table mb-0">
                            <thead class="complaint-table-head">
                                <tr>
                                    <th>#</th>
                                    <th>DS Division</th>
                                    <th>Counter</th>
                                    <th>Vehicle Reg.</th>
                                    <th>Mobile Phone</th>
                                    <th>Citizen Email</th>
                                    <th>Quality Factor</th>
                                    <th>Rating</th>
                                    <th>Date Logged</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="pendingAccordion">
                                @forelse($allRatings as $index => $rating)
                                <tr class="pending-complaint-row"
                                    data-remarks-route="{{ route('admin.complain.remarks', $rating->id) }}"
                                    data-division-counter="{{ ($rating->counter->division_name ?? '-') . ' - ' . ($rating->counter->counter_name ?? '-') }}"
                                    data-service-quality="{{ $rating->serviceQuality->name ?? '-' }}"
                                    data-rating="{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? 'N/A' }}"
                                    data-vehicle="{{ $rating->vehicle_number ?? '-' }}"
                                    data-phone="{{ $rating->phone ?? '-' }}"
                                    data-email="{{ $rating->complaint_email ?? '-' }}"
                                    data-complaint="{{ $rating->note ?? 'No complaint details provided' }}"
                                    data-selected-type="{{ $rating->complain_type_id ?? '' }}"
                                    data-user-remarks="{{ $rating->remarks ?? '' }}">

                                    <td class="text-muted">{{ $allRatings->firstItem() + $index }}</td>
                                    <td class="fw-bold text-dark">{{ $rating->counter->division_name ?? '-' }}</td>
                                    <td>{{ $rating->counter->counter_name ?? '-' }}</td>
                                    <td class="fw-bold text-primary">{{ $rating->vehicle_number ?: '-' }}</td>
                                    <td>{{ $rating->phone ?: '-' }}</td>
                                    <td><small class="text-muted">{{ $rating->complaint_email ?? '-' }}</small></td>
                                    <td>{{ $rating->serviceQuality->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-bold">
                                            ★ {{ $rating->rating }} - {{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? '' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $rating->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $rating->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        @if($rating->status == 'pending' || $rating->status == null)
                                            <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Pending</span>
                                        @elseif($rating->status == 'ao')
                                            <span class="badge bg-info"><i class="bi bi-shield me-1"></i>Sent to AO</span>
                                        @elseif($rating->status == 'verified')
                                            <span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i>Verified</span>
                                        @elseif($rating->status == 'commissioner')
                                            <span class="badge bg-primary"><i class="bi bi-award me-1"></i>Commissioner</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="bi bi-check2-all fs-2 d-block mb-2 text-success opacity-75"></i>
                                        <div class="fw-bold">No pending complaints</div>
                                        <small>All registered citizen grievances have been reviewed or forwarded.</small>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 pt-2 border-top">
                        <form method="GET" class="mb-2">
                            <input type="hidden" name="active_tab" value="pending">
                            @foreach(request()->except('per_page','pending_page','all_page','active_tab') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                                @foreach([10,20,50,100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page',10)==$size ? 'selected' : '' }}>
                                        Show {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        {{ $allRatings->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                {{-- ================= TAB 2: ALL PROCESSED COMPLAINTS ================= --}}
                <div class="tab-pane fade {{ request('active_tab') == 'closed' ? 'show active' : '' }}" id="closed">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle complaint-table mb-0">
                            <thead class="complaint-table-head">
                                <tr>
                                    <th>#</th>
                                    <th>DS Division</th>
                                    <th>Counter</th>
                                    <th>Vehicle Reg.</th>
                                    <th>Mobile Phone</th>
                                    <th>Citizen Email</th>
                                    <th>Quality Factor</th>
                                    <th>Rating</th>
                                    <th>Date Logged</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="closedAccordion">
                                @forelse($readRatings as $index => $rating)
                                <tr class="closed-complaint-row"
                                    data-division-counter="{{ ($rating->counter->division_name ?? '-') . ' - ' . ($rating->counter->counter_name ?? '-') }}"
                                    data-service-quality="{{ $rating->serviceQuality->name ?? '-' }}"
                                    data-rating="{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? 'N/A' }}"
                                    data-vehicle="{{ $rating->vehicle_number ?? '-' }}"
                                    data-phone="{{ $rating->phone ?? '-' }}"
                                    data-email="{{ $rating->complaint_email ?? '-' }}"
                                    data-complaint="{{ $rating->note ?? '-' }}"
                                    data-complaint-type="{{ $rating->complainType->name ?? 'Not specified' }}"
                                    data-user-remarks="{{ $rating->user_remarks ?? '-' }}"
                                    data-ao-remarks="{{ $rating->ao_remarks ?? '-' }}"
                                    data-commissioner-remarks="{{ $rating->commissioner_remarks ?? '-' }}"
                                    data-status="{{ $rating->status ?? 'pending' }}">

                                    <td class="text-muted">{{ $readRatings->firstItem() + $index }}</td>
                                    <td class="fw-bold text-dark">{{ $rating->counter->division_name ?? '-' }}</td>
                                    <td>{{ $rating->counter->counter_name ?? '-' }}</td>
                                    <td class="fw-bold text-primary">{{ $rating->vehicle_number ?: '-' }}</td>
                                    <td>{{ $rating->phone ?: '-' }}</td>
                                    <td><small class="text-muted">{{ $rating->complaint_email ?? '-' }}</small></td>
                                    <td>{{ $rating->serviceQuality->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-bold">
                                            ★ {{ $rating->rating }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $rating->created_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $rating->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        @switch($rating->status)
                                            @case('pending')
                                            @case(null)
                                                <span class="badge bg-warning text-dark">Pending</span>
                                                @break
                                            @case('ao')
                                                <span class="badge bg-info">Forwarded to A/O</span>
                                                @break
                                            @case('verified')
                                                <span class="badge bg-success">Verified</span>
                                                @break
                                            @case('commissioner')
                                                <span class="badge bg-primary">Informed to Commissioner</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($rating->status) }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                        <div class="fw-bold">No resolved or processed complaints found</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap mt-3 pt-2 border-top">
                        <form method="GET" class="mb-2">
                            <input type="hidden" name="active_tab" value="closed">
                            @foreach(request()->except('per_page','pending_page','all_page','active_tab') as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                                @foreach([10,20,50,100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page',10)==$size ? 'selected' : '' }}>
                                        Show {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        {{ $readRatings->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- MODAL 1: PENDING COMPLAINT ACTION --}}
<div class="modal fade" id="pendingComplaintModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 16px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-shield-exclamation text-primary me-2"></i>Review Citizen Complaint
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Vehicle Registration</label>
                        <div id="pendingDetailsVehicle" class="fw-bold text-dark fs-6">-</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Mobile</label>
                        <div id="pendingDetailsPhone" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Email</label>
                        <div id="pendingDetailsEmail" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">DS Division &amp; Counter</label>
                        <div id="pendingDetailsDivisionCounter" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold mb-1">Service Quality</label>
                        <div id="pendingDetailsServiceQuality" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold mb-1">Rating</label>
                        <div id="pendingDetailsRating" class="fw-semibold">-</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Grievance Description</label>
                        <div id="pendingDetailsComplaint" class="p-3 bg-light rounded-3 border">-</div>
                    </div>
                    <div class="col-12 mt-4 pt-3 border-top">
                        <form method="POST" id="pendingComplaintForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-secondary">Assign Complaint Classification <span class="text-danger">*</span></label>
                                <select name="complain_type_id" id="pendingComplaintType" class="form-select" required>
                                    <option value="">-- Select Classification --</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-secondary">Initial Review / User Remarks</label>
                                <textarea name="user_remarks" id="pendingComplaintRemarks" class="form-control" rows="3" placeholder="Add administrative notes before forwarding..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger d-inline-flex align-items-center gap-2">
                                <i class="bi bi-arrow-right-circle"></i>
                                <span>Forward to Administrative Officer (A/O)</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 2: CLOSED COMPLAINT AUDIT --}}
<div class="modal fade" id="closedComplaintModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 16px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-file-earmark-text text-primary me-2"></i>Complaint Redressal Audit
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Vehicle Registration</label>
                        <div id="closedDetailsVehicle" class="fw-bold text-dark fs-6">-</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Mobile</label>
                        <div id="closedDetailsPhone" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Email</label>
                        <div id="closedDetailsEmail" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">Classification Type</label>
                        <div id="closedDetailsType" class="fw-semibold text-primary">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">DS Division &amp; Counter</label>
                        <div id="closedDetailsDivisionCounter" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">Service Quality Factor</label>
                        <div id="closedDetailsServiceQuality" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Rating</label>
                        <div id="closedDetailsRating" class="fw-semibold text-warning">-</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Complaint</label>
                        <div id="closedDetailsComplaint" class="p-3 bg-light rounded-3 border">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">Desk Remarks</label>
                        <div id="closedDetailsUserRemarks" class="p-2 bg-light rounded border small">-</div>
                    </div>
                    <div class="col-md-6" id="closedDetailsAoWrap">
                        <label class="form-label text-muted small fw-bold mb-1">A/O Investigation Findings</label>
                        <div id="closedDetailsAoRemarks" class="p-2 bg-light rounded border small">-</div>
                    </div>
                    <div class="col-12" id="closedDetailsCommissionerWrap">
                        <label class="form-label text-muted small fw-bold mb-1">Commissioner Final Resolution</label>
                        <div id="closedDetailsCommissionerRemarks" class="p-2 bg-light rounded border small text-success fw-bold">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function() {
            document.getElementById('active_tab').value = this.dataset.bsTarget.replace('#', '') === 'pending' ? 'pending' : 'closed';
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const filterBox = document.getElementById('filterBox');
        const arrow = document.getElementById('arrow');
        const pendingComplaintModal = new bootstrap.Modal(document.getElementById('pendingComplaintModal'));
        const closedComplaintModal = new bootstrap.Modal(document.getElementById('closedComplaintModal'));

        if (filterBox && arrow) {
            filterBox.addEventListener('show.bs.collapse', () => arrow.className = 'bi bi-chevron-up ms-1');
            filterBox.addEventListener('hide.bs.collapse', () => arrow.className = 'bi bi-chevron-down ms-1');
        }

        document.querySelectorAll('.pending-complaint-row').forEach(function(row) {
            row.addEventListener('click', function() {
                document.getElementById('pendingDetailsVehicle').innerText = row.dataset.vehicle || '-';
                document.getElementById('pendingDetailsPhone').innerText = row.dataset.phone || '-';
                document.getElementById('pendingDetailsEmail').innerText = row.dataset.email || '-';
                document.getElementById('pendingDetailsDivisionCounter').innerText = row.dataset.divisionCounter || '-';
                document.getElementById('pendingDetailsServiceQuality').innerText = row.dataset.serviceQuality || '-';
                document.getElementById('pendingDetailsRating').innerText = row.dataset.rating || '-';
                document.getElementById('pendingDetailsComplaint').innerText = row.dataset.complaint || '-';
                document.getElementById('pendingComplaintForm').action = row.dataset.remarksRoute || '';
                document.getElementById('pendingComplaintType').value = row.dataset.selectedType || '';
                document.getElementById('pendingComplaintRemarks').value = row.dataset.userRemarks || '';
                pendingComplaintModal.show();
            });
        });

        document.querySelectorAll('.closed-complaint-row').forEach(function(row) {
            row.addEventListener('click', function() {
                document.getElementById('closedDetailsVehicle').innerText = row.dataset.vehicle || '-';
                document.getElementById('closedDetailsPhone').innerText = row.dataset.phone || '-';
                document.getElementById('closedDetailsEmail').innerText = row.dataset.email || '-';
                document.getElementById('closedDetailsDivisionCounter').innerText = row.dataset.divisionCounter || '-';
                document.getElementById('closedDetailsServiceQuality').innerText = row.dataset.serviceQuality || '-';
                document.getElementById('closedDetailsRating').innerText = row.dataset.rating || '-';
                document.getElementById('closedDetailsComplaint').innerText = row.dataset.complaint || '-';
                document.getElementById('closedDetailsType').innerText = row.dataset.complaintType || '-';
                document.getElementById('closedDetailsUserRemarks').innerText = row.dataset.userRemarks || '-';
                document.getElementById('closedDetailsAoRemarks').innerText = row.dataset.aoRemarks || '-';
                document.getElementById('closedDetailsCommissionerRemarks').innerText = row.dataset.commissionerRemarks || '-';

                document.getElementById('closedDetailsAoWrap').style.display = ['commissioner', 'completed'].includes(row.dataset.status || '') ? 'block' : 'none';
                document.getElementById('closedDetailsCommissionerWrap').style.display = (row.dataset.status || '') === 'completed' ? 'block' : 'none';
                closedComplaintModal.show();
            });
        });
    });
</script>
@endsection
