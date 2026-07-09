@extends('layouts.app')

@section('title')
Administrative Officer Complaints- PDMT
@endsection
<style>
    .ao-table {
        border: 1px solid #dbe3ee;
        border-collapse: separate;
        border-spacing: 0;
    }

    .ao-table .ao-table-head th {
        background-color: #f3f6fa;
        color: #243b53;
        border-bottom: 1px solid #d2dceb;
        white-space: nowrap;
        padding: 12px 14px;
    }

    .ao-table th {
        font-weight: 600;
        font-size: 14px;
    }

    .ao-table td {
        font-size: 14px;
        border-top: 1px solid #edf1f5;
        color: #5f6c7b;
        padding: 12px 14px;
    }

    .ao-table tbody tr {
        cursor: pointer;
    }

    .ao-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    .modal-content {
        border-radius: 8px;
    }

    @media (max-width:768px) {

        .ao-table th,
        .ao-table td {
            font-size: 12px;
            padding: 6px;
        }

        h2 {
            font-size: 20px;
        }

        textarea {
            font-size: 13px;
        }

    }
</style>
@section('content')
<div class="container">

    <h2 class="mb-0">Administrative Officer Complaints</h2>
<div class="card shadow border-0">

        <div class="card-body">
    <div class="d-flex justify-content-end mb-2">
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterBox">
            <i class="bi bi-funnel"></i> Filters <span id="arrow">▼</span>
        </button>
    </div>

    {{-- ✅ FIXED: added status --}}
    <div class="collapse {{ request()->hasAny(['division','counter','status','from','to']) ? 'show' : '' }}" id="filterBox">
        <div class="card card-body mb-3">
            <form method="GET" class="row">

                <input type="hidden" name="active_tab" id="active_tab" value="{{ request('active_tab','pending') }}">

                <div class="col-md-2">
                    <label>Division-Counter</label>
                    <select name="counter" class="form-control">
                        <option value="">-- All Counters --</option>
                        @foreach($counters as $counterOption)
                        <option value="{{ $counterOption->id }}"
                            {{ request('counter') == $counterOption->id ? 'selected' : '' }}>
                            {{ $counterOption->division_name }} – {{ $counterOption->counter_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="ao" {{ request('status')=='ao'?'selected':'' }}>At A/O</option>
                     <option value="verified"
            {{ request('status') == 'verified' ? 'selected' : '' }}>
            Verified
        </option>

        <option value="commissioner"
            {{ request('status') == 'commissioner' ? 'selected' : '' }}>
            Informed to Commissioner
        </option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>From Date</label>
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>To Date</label>
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control">
                </div>


                <div class="col-md-2">
                    <label>Complaint Type</label>
                    <select name="complain_type" class="form-control">
                        <option value="">All Types</option>

                        @foreach($complainTypes as $type)
                        <option value="{{ $type->id }}"
                            {{ request('complain_type') == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-2">
                    <label>Search</label>
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Vehicle or Phone">
                </div>
                <div class="col-md-12 mt-4 text-end">
                    <button class="btn btn-primary "><i class="bi bi-search"></i></button>
                    <a href="{{ url()->current() }}" class="btn btn-danger">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= TABS ================= --}}
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <button class="nav-link {{ request('active_tab','pending') == 'pending' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#pending">
                Pending at A/O
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ request('active_tab') == 'closed' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#closed">
                Verified / Forwarded
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ================= PENDING ================= --}}
        <div class="tab-pane fade {{ request('active_tab','pending') == 'pending' ? 'show active' : '' }}" id="pending">
            <table class="table table-hover align-middle ao-table">

                <thead class="ao-table-head">
                    <tr>
                        <th>#</th>
                        <th>DS Division</th>
                        <th>Counter</th>
                        <th>Vehicle</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Service Quality</th>
                        <th>Rating</th>
                        <th>Date</th>
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
                        data-user-remarks="{{ $rating->user_remarks ?? '-' }}"
                        style="cursor:pointer">

<td>{{ $pendingAO->firstItem() + $loop->index }}</td>
                        <td>{{ $rating->counter->division_name ?? '-' }}</td>
                        <td>{{ $rating->counter->counter_name ?? '-' }}</td>
                        <td>{{ $rating->vehicle_number }}</td>
                        <td>{{ $rating->phone }}</td>
                        <td>{{ $rating->complaint_email ?? '-' }}</td>
                        <td>{{ $rating->serviceQuality->name ?? '-' }}</td>
                        <td>{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? 'N/A' }}</td>
                        <td>{{ $rating->created_at->format('d M Y') }}</td>

                        <td>
                            <span class="badge bg-info">At Administrative Officer</span>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No complaints at Administrative Officer</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- ✅ FIXED PAGINATION --}}
               <div class="d-flex justify-content-end align-items-center">
                <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
    <form method="GET" class="mb-2">
        <input type="hidden" name="active_tab" value="pending">

        @foreach(request()->except('per_page','page','pending','closed','active_tab') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <select name="per_page" class="form-control" onchange="this.form.submit()">
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

        </div>

        {{-- ================= CLOSED ================= --}}
        <div class="tab-pane fade {{ request('active_tab') == 'closed' ? 'show active' : '' }}" id="closed">

            <table class="table table-hover align-middle ao-table">

                <thead class="ao-table-head">
                    <tr>
                        <th>#</th>
                        <th>DS Division</th>
                        <th>Counter</th>
                        <th>Vehicle</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Service Quality</th>
                        <th>Rating</th>
                        <th>Date</th>
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
                        data-ao-remarks="{{ $c->ao_remarks ?? '-' }}"
                        style="cursor:pointer">

<td>{{ $closedAO->firstItem() + $loop->index }}</td>
                        <td>{{ $c->counter->division_name ?? '-' }}</td>
                        <td>{{ $c->counter->counter_name ?? '-' }}</td>
                        <td>{{ $c->vehicle_number }}</td>
                        <td>{{ $c->phone }}</td>
                        <td>{{ $c->complaint_email ?? '-' }}</td>
                        <td>{{ $c->serviceQuality->name ?? '-' }}</td>
                        <td>{{ ['','Bad','Poor','Average','Good','Excellent'][$c->rating] ?? 'N/A' }}</td>
                        <td>{{ $c->updated_at->format('d M Y') }}</td>

                        <td>
                         @if($c->status == 'pending' || is_null($c->status))
    <span class="badge bg-warning text-dark">Pending</span>

@elseif($c->status == 'ao')
    <span class="badge bg-info">Forwarded to A/O</span>

@elseif($c->status == 'verified')
    <span class="badge bg-success">Verified</span>

@elseif($c->status == 'commissioner')
    <span class="badge bg-primary">Informed to Commissioner</span>



@else
    <span class="badge bg-secondary">-</span>
@endif
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No completed complaints</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
<div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
    <form method="GET" class="mb-2">
        <input type="hidden" name="active_tab" value="closed">

        @foreach(request()->except('per_page','page','pending','closed','active_tab') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <select name="per_page" class="form-control" onchange="this.form.submit()">
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

<div class="modal fade" id="pendingAoDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complaint Details - A/O</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6"><strong>Vehicle:</strong> <span id="pendingAoVehicle">-</span></div>
                    <div class="col-md-6"><strong>Phone:</strong> <span id="pendingAoPhone">-</span></div>
                    <div class="col-md-6"><strong>Email:</strong> <span id="pendingAoEmail">-</span></div>
                    <div class="col-md-6"><strong>DS Division - Counter:</strong> <span id="pendingAoDivisionCounter">-</span></div>
                    <div class="col-md-6"><strong>Service Quality:</strong> <span id="pendingAoServiceQuality">-</span></div>
                    <div class="col-md-6"><strong>Rating:</strong> <span id="pendingAoRating">-</span></div>
                    <div class="col-md-6"><strong>Complaint Type:</strong> <span id="pendingAoType">-</span></div>
                    <div class="col-md-6"><strong>User Remarks:</strong> <span id="pendingAoUserRemarks">-</span></div>
                    <div class="col-12">
                        <strong>Complaint:</strong>
                        <div class="p-2 bg-light rounded border" id="pendingAoComplaint">-</div>
                    </div>
                    <div class="col-12">
                        <form method="POST" id="pendingAoActionForm">
                            @csrf
                            <label><strong>AO Final Remarks</strong></label>
                            <textarea name="ao_remarks" class="form-control mb-2"></textarea>
                            <button class="btn btn-success btn-sm" name="action" value="verify">Verified</button>
                            <button class="btn btn-warning btn-sm text-dark" name="action" value="inform_commissioner">Inform By Commissioner</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="closedAoDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complaint Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6"><strong>Vehicle:</strong> <span id="closedAoVehicle">-</span></div>
                    <div class="col-md-6"><strong>Phone:</strong> <span id="closedAoPhone">-</span></div>
                    <div class="col-md-6"><strong>Email:</strong> <span id="closedAoEmail">-</span></div>
                    <div class="col-md-6"><strong>DS Division - Counter:</strong> <span id="closedAoDivisionCounter">-</span></div>
                    <div class="col-md-6"><strong>Service Quality:</strong> <span id="closedAoServiceQuality">-</span></div>
                    <div class="col-md-6"><strong>Rating:</strong> <span id="closedAoRating">-</span></div>
                    <div class="col-md-6"><strong>Complaint Type:</strong> <span id="closedAoType">-</span></div>
                    <div class="col-md-6"><strong>User Remarks:</strong> <span id="closedAoUserRemarks">-</span></div>
                    <div class="col-md-6"><strong>AO Remarks:</strong> <span id="closedAoAoRemarks">-</span></div>
                    <div class="col-12">
                        <strong>Complaint:</strong>
                        <div class="p-2 bg-light rounded border" id="closedAoComplaint">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    tr[aria-expanded="true"] span {
        transform: rotate(180deg);
    }

    span {
        transition: 0.2s;
    }
</style>

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

        filterBox.addEventListener('show.bs.collapse', () => arrow.innerHTML = '▲');
        filterBox.addEventListener('hide.bs.collapse', () => arrow.innerHTML = '▼');

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