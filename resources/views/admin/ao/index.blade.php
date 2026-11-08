@extends('layouts.app')

@section('title', 'Administrative Officer Complaints - PDMT')

@section('content')
<style>
    .ao-table {
        border: 1px solid #e2e8f0;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
    }

    .ao-table .ao-table-head th {
        background-color: #f8fafc;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
        padding: 12px 14px;
        font-weight: 700;
        font-size: 13px;
    }

    .ao-table td {
        font-size: 13.5px;
        border-top: 1px solid #f1f5f9;
        color: #475569;
        padding: 12px 14px;
    }

    .ao-table tbody tr {
        cursor: pointer;
        transition: background-color 0.18s ease;
    }

    .ao-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    [data-bs-theme="dark"] .ao-table {
        border-color: #1e293b;
    }

    [data-bs-theme="dark"] .ao-table .ao-table-head th {
        background-color: #141e33;
        color: #cbd5e1;
        border-bottom-color: #1e293b;
    }

    [data-bs-theme="dark"] .ao-table td {
        border-top-color: #1e293b;
        color: #94a3b8;
    }

    [data-bs-theme="dark"] .ao-table tbody tr:hover td {
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
            <h2 class="fw-bold mb-1" style="font-size: 22px;">A/O Investigation Management</h2>
            <div class="text-muted small">Complaints escalated to the Administrative Officer for verification and inquiry</div>
        </div>
        <div>
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterBox">
                <i class="bi bi-funnel me-1"></i> Filter Records <i class="bi bi-chevron-down ms-1" id="arrow"></i>
            </button>
        </div>
    </div>

    <!-- FILTER COLLAPSIBLE -->
    <div class="collapse {{ request()->hasAny(['division','counter','status','from','to','complain_type','search']) ? 'show' : '' }}" id="filterBox">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px;">
            <div class="card-body p-3">
                <form method="GET" class="row g-2">
                    <input type="hidden" name="active_tab" id="active_tab" value="{{ request('active_tab','pending') }}">

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Division &amp; Counter</label>
                        <select name="counter" class="form-select form-select-sm">
                            <option value="">-- All Counters --</option>
                            @foreach($counters as $counterOption)
                            <option value="{{ $counterOption->id }}" {{ request('counter') == $counterOption->id ? 'selected' : '' }}>
                                {{ $counterOption->division_name }} &bull; {{ $counterOption->counter_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending Initial</option>
                            <option value="ao" {{ request('status')=='ao'?'selected':'' }}>Under A/O Review</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="commissioner" {{ request('status') == 'commissioner' ? 'selected' : '' }}>Informed to Commissioner</option>
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
                        <label class="form-label small fw-bold text-secondary">Classification Type</label>
                        <select name="complain_type" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            @foreach($complainTypes as $type)
                            <option value="{{ $type->id }}" {{ request('complain_type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-secondary">Search Keyword</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Vehicle number or citizen phone">
                    </div>

                    <div class="col-md-8 d-flex align-items-end justify-content-end gap-2">
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

    <!-- MAIN CARD -->
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
                        <i class="bi bi-shield-exclamation me-1"></i> Pending Action at A/O
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link {{ request('active_tab') == 'closed' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#closed">
                        <i class="bi bi-check-all me-1"></i> Verified &amp; Forwarded
                    </button>
                </li>
            </ul>

            <div class="tab-content">

                {{-- ================= TAB 1: PENDING AT AO ================= --}}
                <div class="tab-pane fade {{ request('active_tab','pending') == 'pending' ? 'show active' : '' }}" id="pending">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle ao-table mb-0">
                            <thead class="ao-table-head">
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
                            <tbody id="pendingaoAccordion">
                                @forelse($pendingAO as $rating)
                                <tr class="pending-ao-row"
                                    data-ao-save-route="{{ route('admin.ao.save', $rating->id) }}"
                                    data-division-counter="{{ ($rating->counter->division_name ?? '-') . ' - ' . ($rating->counter->counter_name ?? '-') }}"
                                    data-service-quality="{{ $rating->serviceQuality->name ?? '-' }}"
                                    data-rating="{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? 'N/A' }}"
                                    data-vehicle="{{ $rating->vehicle_number ?? '-' }}"
                                    data-phone="{{ $rating->phone ?? '-' }}"
                                    data-email="{{ $rating->complaint_email ?? '-' }}"
                                    data-complaint="{{ $rating->note ?? '-' }}"
                                    data-complaint-type="{{ $rating->complainType->name ?? '-' }}"
                                    data-user-remarks="{{ $rating->user_remarks ?? '-' }}">

                                    <td class="text-muted">{{ $pendingAO->firstItem() + $loop->index }}</td>
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
                                        <span class="badge bg-info text-dark"><i class="bi bi-shield me-1"></i>At A/O Review</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="bi bi-shield-check fs-2 d-block mb-2 text-success opacity-75"></i>
                                        <div class="fw-bold">No complaints currently pending at Administrative Officer</div>
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
                            @foreach(request()->except('per_page','page','pending','closed','active_tab') as $key => $value)
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

                        {{ $pendingAO->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                {{-- ================= TAB 2: CLOSED / VERIFIED AT AO ================= --}}
                <div class="tab-pane fade {{ request('active_tab') == 'closed' ? 'show active' : '' }}" id="closed">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle ao-table mb-0">
                            <thead class="ao-table-head">
                                <tr>
                                    <th>#</th>
                                    <th>DS Division</th>
                                    <th>Counter</th>
                                    <th>Vehicle Reg.</th>
                                    <th>Mobile Phone</th>
                                    <th>Citizen Email</th>
                                    <th>Quality Factor</th>
                                    <th>Rating</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="closedaoAccordion">
                                @forelse($closedAO as $c)
                                <tr class="closed-ao-row"
                                    data-division-counter="{{ ($c->counter->division_name ?? '-') . ' - ' . ($c->counter->counter_name ?? '-') }}"
                                    data-service-quality="{{ $c->serviceQuality->name ?? '-' }}"
                                    data-rating="{{ ['','Bad','Poor','Average','Good','Excellent'][$c->rating] ?? 'N/A' }}"
                                    data-vehicle="{{ $c->vehicle_number ?? '-' }}"
                                    data-phone="{{ $c->phone ?? '-' }}"
                                    data-email="{{ $c->complaint_email ?? '-' }}"
                                    data-complaint="{{ $c->note ?? '-' }}"
                                    data-complaint-type="{{ $c->complainType->name ?? '-' }}"
                                    data-user-remarks="{{ $c->user_remarks ?? '-' }}"
                                    data-ao-remarks="{{ $c->ao_remarks ?? '-' }}">

                                    <td class="text-muted">{{ $closedAO->firstItem() + $loop->index }}</td>
                                    <td class="fw-bold text-dark">{{ $c->counter->division_name ?? '-' }}</td>
                                    <td>{{ $c->counter->counter_name ?? '-' }}</td>
                                    <td class="fw-bold text-primary">{{ $c->vehicle_number ?: '-' }}</td>
                                    <td>{{ $c->phone ?: '-' }}</td>
                                    <td><small class="text-muted">{{ $c->complaint_email ?? '-' }}</small></td>
                                    <td>{{ $c->serviceQuality->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle fw-bold">
                                            ★ {{ $c->rating }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $c->updated_at->format('d M Y') }}</div>
                                        <small class="text-muted">{{ $c->updated_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        @if($c->status == 'pending' || is_null($c->status))
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($c->status == 'ao')
                                            <span class="badge bg-info">Under A/O Review</span>
                                        @elseif($c->status == 'verified')
                                            <span class="badge bg-success"><i class="bi bi-check2-circle me-1"></i>Verified</span>
                                        @elseif($c->status == 'commissioner')
                                            <span class="badge bg-primary"><i class="bi bi-award me-1"></i>Informed to Commissioner</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($c->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                        <div class="fw-bold">No verified complaints found</div>
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
                            @foreach(request()->except('per_page','page','pending','closed','active_tab') as $key => $value)
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

                        {{ $closedAO->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- MODAL 1: PENDING AO INVESTIGATION ACTION --}}
<div class="modal fade" id="pendingAoDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 16px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-shield-check text-primary me-2"></i>A/O Complaint Investigation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Vehicle Registration</label>
                        <div id="pendingAoVehicle" class="fw-bold text-dark fs-6">-</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Mobile</label>
                        <div id="pendingAoPhone" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Email</label>
                        <div id="pendingAoEmail" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">DS Division &amp; Counter</label>
                        <div id="pendingAoDivisionCounter" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold mb-1">Quality Factor</label>
                        <div id="pendingAoServiceQuality" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold mb-1">Rating</label>
                        <div id="pendingAoRating" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">Classification Type</label>
                        <div id="pendingAoType" class="fw-semibold text-primary">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">Desk / Officer Remarks</label>
                        <div id="pendingAoUserRemarks" class="p-2 bg-light rounded border small">-</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Grievance Description</label>
                        <div class="p-3 bg-light rounded-3 border" id="pendingAoComplaint">-</div>
                    </div>
                    <div class="col-12 mt-4 pt-3 border-top">
                        <form method="POST" id="pendingAoActionForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-secondary">A/O Findings &amp; Investigation Remarks <span class="text-danger">*</span></label>
                                <textarea name="ao_remarks" class="form-control" rows="3" placeholder="Enter findings, verification details, and corrective actions taken..." required></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-1" name="action" value="verify">
                                    <i class="bi bi-check2-circle"></i> Mark as Verified
                                </button>
                                <button type="submit" class="btn btn-warning text-dark d-inline-flex align-items-center gap-1" name="action" value="inform_commissioner">
                                    <i class="bi bi-award"></i> Inform to Commissioner
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 2: CLOSED AO DETAILS --}}
<div class="modal fade" id="closedAoDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 16px;">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-file-earmark-text text-primary me-2"></i>A/O Investigation Record
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Vehicle Registration</label>
                        <div id="closedAoVehicle" class="fw-bold text-dark fs-6">-</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Mobile</label>
                        <div id="closedAoPhone" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Email</label>
                        <div id="closedAoEmail" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">DS Division &amp; Counter</label>
                        <div id="closedAoDivisionCounter" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold mb-1">Service Quality</label>
                        <div id="closedAoServiceQuality" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold mb-1">Rating</label>
                        <div id="closedAoRating" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">Classification Type</label>
                        <div id="closedAoType" class="fw-semibold text-primary">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold mb-1">Desk Remarks</label>
                        <div id="closedAoUserRemarks" class="p-2 bg-light rounded border small">-</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-bold mb-1">A/O Official Investigation Findings</label>
                        <div id="closedAoAoRemarks" class="p-3 bg-light rounded-3 border text-primary fw-semibold">-</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small fw-bold mb-1">Citizen Complaint</label>
                        <div class="p-3 bg-light rounded-3 border" id="closedAoComplaint">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(link => {
        link.addEventListener('shown.bs.tab', function(e) {
            document.getElementById('active_tab').value = e.target.dataset.bsTarget.substring(1);
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const filterBox = document.getElementById('filterBox');
        const arrow = document.getElementById('arrow');
        const pendingAoModal = new bootstrap.Modal(document.getElementById('pendingAoDetailsModal'));
        const closedAoModal = new bootstrap.Modal(document.getElementById('closedAoDetailsModal'));
        const pendingAoActionForm = document.getElementById('pendingAoActionForm');

        if (filterBox && arrow) {
            filterBox.addEventListener('show.bs.collapse', () => arrow.className = 'bi bi-chevron-up ms-1');
            filterBox.addEventListener('hide.bs.collapse', () => arrow.className = 'bi bi-chevron-down ms-1');
        }

        document.querySelectorAll('.pending-ao-row').forEach(function(row) {
            row.addEventListener('click', function() {
                document.getElementById('pendingAoVehicle').innerText = this.dataset.vehicle || '-';
                document.getElementById('pendingAoPhone').innerText = this.dataset.phone || '-';
                document.getElementById('pendingAoEmail').innerText = this.dataset.email || '-';
                document.getElementById('pendingAoDivisionCounter').innerText = this.dataset.divisionCounter || '-';
                document.getElementById('pendingAoServiceQuality').innerText = this.dataset.serviceQuality || '-';
                document.getElementById('pendingAoRating').innerText = this.dataset.rating || '-';
                document.getElementById('pendingAoType').innerText = this.dataset.complaintType || '-';
                document.getElementById('pendingAoUserRemarks').innerText = this.dataset.userRemarks || '-';
                document.getElementById('pendingAoComplaint').innerText = this.dataset.complaint || '-';
                pendingAoActionForm.action = this.dataset.aoSaveRoute || '';
                pendingAoModal.show();
            });
        });

        document.querySelectorAll('.closed-ao-row').forEach(function(row) {
            row.addEventListener('click', function() {
                document.getElementById('closedAoVehicle').innerText = this.dataset.vehicle || '-';
                document.getElementById('closedAoPhone').innerText = this.dataset.phone || '-';
                document.getElementById('closedAoEmail').innerText = this.dataset.email || '-';
                document.getElementById('closedAoDivisionCounter').innerText = this.dataset.divisionCounter || '-';
                document.getElementById('closedAoServiceQuality').innerText = this.dataset.serviceQuality || '-';
                document.getElementById('closedAoRating').innerText = this.dataset.rating || '-';
                document.getElementById('closedAoType').innerText = this.dataset.complaintType || '-';
                document.getElementById('closedAoUserRemarks').innerText = this.dataset.userRemarks || '-';
                document.getElementById('closedAoAoRemarks').innerText = this.dataset.aoRemarks || '-';
                document.getElementById('closedAoComplaint').innerText = this.dataset.complaint || '-';
                closedAoModal.show();
            });
        });
    });
</script>
@endsection
