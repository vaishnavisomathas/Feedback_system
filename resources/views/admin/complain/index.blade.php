@extends('layouts.app')

@section('title')
Complaints - PDMT
@endsection
<style>
    .complaint-table {
        border: 1px solid #dbe3ee;
        border-collapse: separate;
        border-spacing: 0;
    }

    .complaint-table .complaint-table-head th {
        background-color: #f3f6fa;
        color: #243b53;
        border-bottom: 1px solid #d2dceb;
        white-space: nowrap;
        padding: 12px 14px;
    }

    .complaint-table th {
        font-weight: 600;
        font-size: 14px;
    }

    .complaint-table td {
        font-size: 14px;
        border-top: 1px solid #edf1f5;
        color: #5f6c7b;
        padding: 12px 14px;
    }

    .complaint-table tbody tr {
        cursor: pointer;
    }

    .complaint-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    .card-sm {
        border-radius: 8px;
    }

    @media (max-width:768px) {

        .complaint-table th,
        .complaint-table td {
            font-size: 12px;
            padding: 6px;
        }

        h2 {
            font-size: 20px;
        }

        .card-body {
            padding: 10px;
        }

        textarea {
            font-size: 13px;
        }

    }
</style>
@section('content')
<div class="container">

    <h2 class="mb-0">Complaint Management</h2>
<div class="card shadow border-0">

        <div class="card-body">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex justify-content-end mb-2">
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterBox">
            <i class="bi bi-funnel"></i> Filters <span id="arrow">▼</span>
        </button>
    </div>

    <div class="collapse {{ request()->hasAny(['division','counter','status','from','to']) ? 'show' : '' }}" id="filterBox">

        <div class="card card-body mb-3">

            <form method="GET" class="row">
                <input type="hidden" name="active_tab" id="active_tab" value="{{ request('active_tab','all') }}">

                <div class="col-md-2">
                    <label>Division-Counter</label>
                    <select name="counter" class="form-control">
                        <option value="">-- All Counters --</option>
                        @foreach($counters as $counterOption)
                        <option value="{{ $counterOption->id }}"
                            {{ ($filters['counter'] ?? '') == $counterOption->id ? 'selected' : '' }}>
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
                        <option value="ao" {{ request('status')=='ao'?'selected':'' }}>Fowarded A/O</option>
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
                    <label>Service Quality</label>
                    <select name="service_quality" class="form-control">
                        <option value="">All</option>
                        @foreach($serviceQualities as $quality)
                        <option value="{{ $quality->id }}"
                            {{ request('service_quality') == $quality->id ? 'selected' : '' }}>
                            {{ $quality->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Rating</label>
                    <select name="rating" class="form-control">
                        <option value="">All</option>
                        <option value="1" {{ request('rating')==1?'selected':'' }}>Bad</option>
                        <option value="2" {{ request('rating')==2?'selected':'' }}>Poor</option>
                        <option value="3" {{ request('rating')==3?'selected':'' }}>Average</option>
                        <option value="4" {{ request('rating')==4?'selected':'' }}>Good</option>
                        <option value="5" {{ request('rating')==5?'selected':'' }}>Excellent</option>
                    </select>
                </div>


                <div class="col-md-2">
                    <label>Complaint Type</label>
                    <select name="complain_type" class="form-control">
                        <option value="">All</option>

                        @foreach($types as $type)
                        <option value="{{ $type->id }}"
                            {{ request('complain_type')==$type->id?'selected':'' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-2">
                    <label>Search</label>
                    <input type="text" name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Vehicle or Phone">
                </div>
                <div class="col-md-8 mt-4 d-flex justify-content-end">
                    <button class="btn btn-primary "> <i class="bi bi-search"></i> </button>
                    <a href="{{ url()->current() }}" class="btn btn-danger"><i class="bi bi-arrow-clockwise me-1"></i></a>
                </div>

            </form>

        </div>

    </div>

    {{-- TABS --}}
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <button class="nav-link {{ request('active_tab','pending') == 'pending' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#pending">
                Pending Complaints
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link {{ request('active_tab') == 'closed' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#closed"> All Complaints
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ================= ALL COMPLAINTS ================= --}}
        <div class="tab-pane fade {{ request('active_tab','pending') == 'pending' ? 'show active' : '' }}" id="pending">

            <table class="table table-hover align-middle complaint-table">
                <thead class="complaint-table-head">
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
                        data-complaint="{{ $rating->note ?? 'No complaint provided' }}"
                        data-selected-type="{{ $rating->complain_type_id ?? '' }}"
                        data-user-remarks="{{ $rating->remarks ?? '' }}"
                        style="cursor:pointer">

                        <td>{{ $allRatings->firstItem() + $index }}</td>

                        <td>
                            {{ $rating->counter->division_name ?? '-' }}

                        </td>
                        <td> {{ $rating->counter->counter_name ?? '-' }}</td>
                        <td>{{ $rating->vehicle_number }}</td>
                        <td>{{ $rating->phone }}</td>
                        <td>{{ $rating->complaint_email ?? '-' }}</td>
                        <td>{{ $rating->serviceQuality->name ?? '-' }}</td>


                        <td>
                            {{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $rating->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @if($rating->status == 'pending' || $rating->status == null)
                            <span class="badge bg-warning text-dark">Pending</span>

                            @elseif($rating->status == 'ao')
                            <span class="badge bg-info">Sent to AO</span>

                       @elseif($rating->status == 'verified')
    <span class="badge bg-success">Verified</span>

@elseif($rating->status == 'commissioner')
    <span class="badge bg-primary">Informed to Commissioner</span>

                            @else
                            <span class="badge bg-secondary">-</span>
                            @endif
                        </td>


                    </tr>

                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No complaints</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end align-items-center">
               <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
    <form method="GET" class="mb-2">
        <input type="hidden" name="active_tab" value="pending">

        @foreach(request()->except('per_page','pending_page','all_page','active_tab') as $key => $value)
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

    {{ $allRatings->links('pagination::bootstrap-5') }}
</div>
            </div>
        </div>

        {{-- ================= All COMPLAINTS ================= --}}
        <div class="tab-pane fade {{ request('active_tab') == 'closed' ? 'show active' : '' }}" id="closed">

            <table class="table table-hover align-middle complaint-table">
                <thead class="complaint-table-head">
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
                        data-status="{{ $rating->status ?? 'pending' }}"
                        style="cursor:pointer">

                        <td>{{ $readRatings->firstItem() + $index }}</td>

                        <td>
                            {{ $rating->counter->division_name ?? '-' }}

                        </td>
                        <td> {{ $rating->counter->counter_name ?? '-' }}</td>
                        <td>{{ $rating->vehicle_number }}</td>
                        <td>{{ $rating->phone }}</td>
                        <td>{{ $rating->complaint_email ?? '-' }}</td>

                        <td>{{ $rating->serviceQuality->name ?? '-' }}</td>

                        <td>
                            {{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $rating->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @switch($rating->status)

                            @case(null)
                            @case('pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @break

                            @case('ao')
                            <span class="badge bg-secondary">Fowarded A/O</span>
                            @break

                          @case('verified')
    <span class="badge bg-success">Verified</span>
@break

@case('commissioner')
    <span class="badge bg-primary">Informed to Commissioner</span>
@break
                           

                            @default
                            <span class="badge bg-secondary">-</span>

                            @endswitch
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No resolved complaints</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

                <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
    <form method="GET" class="mb-2">
        <input type="hidden" name="active_tab" value="closed">

        @foreach(request()->except('per_page','pending_page','all_page','active_tab') as $key => $value)
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

    {{ $readRatings->links('pagination::bootstrap-5') }}
</div>
        </div>

    </div>
</div>
</div>
</div>

<div class="modal fade" id="pendingComplaintModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complaint Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Vehicle</label>
                        <div id="pendingDetailsVehicle" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Phone</label>
                        <div id="pendingDetailsPhone" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Email</label>
                        <div id="pendingDetailsEmail" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">DS Division - Counter</label>
                        <div id="pendingDetailsDivisionCounter" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Service Quality</label>
                        <div id="pendingDetailsServiceQuality" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Rating</label>
                        <div id="pendingDetailsRating" class="fw-semibold">-</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted mb-1">Complaint</label>
                        <div id="pendingDetailsComplaint" class="p-3 bg-light rounded border">-</div>
                    </div>
                    <div class="col-12">
                        <form method="POST" id="pendingComplaintForm">
                            @csrf
                            <div class="mb-3">
                                <label><strong>Complaint Type:</strong></label>
                                <select name="complain_type_id" id="pendingComplaintType" class="form-control">
                                    <option value="">-- Select Type --</option>
                                    @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label><strong>Remarks:</strong></label>
                                <textarea name="user_remarks" id="pendingComplaintRemarks" class="form-control" rows="3"></textarea>
                            </div>
                            <button class="btn btn-danger btn-sm">Forward to Administrative Officer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="closedComplaintModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complaint Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Vehicle</label>
                        <div id="closedDetailsVehicle" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Phone</label>
                        <div id="closedDetailsPhone" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Email</label>
                        <div id="closedDetailsEmail" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Complaint Type</label>
                        <div id="closedDetailsType" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">DS Division - Counter</label>
                        <div id="closedDetailsDivisionCounter" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted mb-1">Service Quality</label>
                        <div id="closedDetailsServiceQuality" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted mb-1">Rating</label>
                        <div id="closedDetailsRating" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">User Remarks</label>
                        <div id="closedDetailsUserRemarks" class="p-2 bg-light rounded border">-</div>
                    </div>
                    <div class="col-md-6" id="closedDetailsAoWrap">
                        <label class="form-label text-muted mb-1">AO Remarks</label>
                        <div id="closedDetailsAoRemarks" class="p-2 bg-light rounded border">-</div>
                    </div>
                    <div class="col-md-6" id="closedDetailsCommissionerWrap">
                        <label class="form-label text-muted mb-1">Final Commissioner Decision</label>
                        <div id="closedDetailsCommissionerRemarks" class="p-2 bg-light rounded border">-</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted mb-1">Complaint</label>
                        <div id="closedDetailsComplaint" class="p-3 bg-light rounded border">-</div>
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
</style>

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

        filterBox.addEventListener('show.bs.collapse', () => arrow.innerHTML = '▲');
        filterBox.addEventListener('hide.bs.collapse', () => arrow.innerHTML = '▼');

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