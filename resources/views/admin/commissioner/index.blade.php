@extends('layouts.app')

@section('title')
Commissioner Complaints- PDMT
@endsection

@section('content')
<div class="container">

<h2 class="mb-4">Commissioner Complaints</h2>
<div class="d-flex justify-content-end mb-2">
    <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterBox">
        <i class="bi bi-funnel"></i> Filters <span id="arrow">▼</span>
    </button>
</div>

<div class="collapse {{ request()->hasAny(['division','counter','status','from','to','service_quality','rating']) ? 'show' : '' }}" id="filterBox">
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
                    <option value="commissioner" {{ request('status')=='commissioner'?'selected':'' }}>Commissioner</option>
                    <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                </select>
            </div>

            <div class="col-md-2">
                <label>From Date</label>
                <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="form-control">
            </div>

            <div class="col-md-2">
                <label>To Date</label>
                <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="form-control">
            </div>

           

            <div class="col-md-4 mt-4">
                <button class="btn btn-primary"><i class="bi bi-search"></i></button>
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
            Pending at Commissioner
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link {{ request('active_tab') == 'closed' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#closed">
            Completed Complaints
        </button>
    </li>
</ul>

<div class="tab-content">

{{-- ================= PENDING ================= --}}
    <div class="tab-pane fade {{ request('active_tab','pending') == 'pending' ? 'show active' : '' }}" id="pending">

<table class="table table-bordered table-hover">
<thead class="table-primary">
<tr>
<th>#</th>
<th>DS Division</th>
<th>Counter</th>
<th>Vehicle</th>
<th>Phone</th>
<th>Service Quality</th>
<th>Rating</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>

<tbody id="pendingcommiAccordion">
@forelse($pendingCommissioner as $c)

<tr data-bs-toggle="collapse"
    data-bs-target="#commissioner{{ $c->id }}"
    style="cursor:pointer">

<td>{{ $loop->iteration }}</td>
<td>{{ $c->counter->division_name ?? '-' }}</td>
<td>{{ $c->counter->counter_name ?? '-' }}</td>
<td>{{ $c->vehicle_number }}</td>
<td>{{ $c->phone }}</td>
<td>{{ $c->serviceQuality->name ?? '-' }}</td>
<td>{{ ['','Bad','Poor','Average','Good','Excellent'][$c->rating] ?? 'N/A' }}</td>
<td>{{ $c->created_at->format('d M Y') }}</td>

<td>
<span class="badge bg-primary">Waiting Commissioner Decision</span>
<span class="float-end">▼</span>
</td>

</tr>
<tr class="collapse bg-light"
    id="commissioner{{ $c->id }}"
    data-bs-parent="#pendingcommiAccordion">

    <td colspan="9">
        <div class="card card-sm shadow-sm border-secondary mb-2">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Complaint:</strong>
                        <p class="mb-0">{{ $c->note }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Complaint Type:</strong>
                        <p class="mb-0">{{ $c->complainType->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Supervisor Remarks:</strong>
                        <p class="mb-0">{{ $c->user_remarks ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>AO Remarks:</strong>
                        <p class="mb-0">{{ $c->ao_remarks ?? '-' }}</p>
                    </div>
                    <div class="col-md-12 mb-2">
                        <form method="POST" action="{{ route('admin.commissioner.close',$c->id) }}">
                            @csrf
                            <label><strong>Final Decision / Action</strong></label>
                            <textarea name="final_remarks" class="form-control mb-2" rows="3"></textarea>
                            <button class="btn btn-success btn-sm">Completed</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>

@empty
<tr>
<td colspan="9" class="text-center">No complaints pending for Commissioner</td>
</tr>
@endforelse
</tbody>
</table>

 <div class="d-flex justify-content-end align-items-center">
    <div class="col-md-2 p-0">
        <form method="GET">
         
            <select name="per_page" class="form-control" onchange="this.form.submit()">
                @foreach([10, 20, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected' : '' }}>
                        Page {{ $size }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    </div>
</div>


{{-- ================= COMPLETED ================= --}}
    <div class="tab-pane fade {{ request('active_tab') == 'closed' ? 'show active' : '' }}" id="closed">

<table class="table table-bordered table-hover">
<thead class="table-success">
<tr>
<th>#</th>
<th>DS Division</th>
<th>Counter</th>
<th>Vehicle</th>
<th>Phone</th>
<th>Service Quality</th>
<th>Rating</th>
<th>Date Closed</th>
<th>Status</th>
</tr>
</thead>

<tbody id="closedcommiAccordion">
@forelse($closedCommissioner as $c)

<tr data-bs-toggle="collapse"
    data-bs-target="#completed{{ $c->id }}"
    style="cursor:pointer">

<td>{{ $loop->iteration }}</td>
<td>{{ $c->counter->division_name ?? '-' }}</td>
<td>{{ $c->counter->counter_name ?? '-' }}</td>
<td>{{ $c->vehicle_number }}</td>
<td>{{ $c->phone }}</td>
<td>{{ $c->serviceQuality->name ?? '-' }}</td>
<td>{{ ['','Bad','Poor','Average','Good','Excellent'][$c->rating] ?? 'N/A' }}</td>
<td>{{ $c->updated_at->format('d M Y') }}</td>

<td>
<span class="badge bg-success">Completed</span>
<span class="float-end">▼</span>
</td>

</tr>
<tr class="collapse bg-light"
id="completed{{ $c->id }}"    data-bs-parent="#closedcommiAccordion">
<td colspan="9">
 <div class="card card-sm shadow-sm border-secondary mb-2">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Complaint:</strong>
                        <p class="mb-0">{{ $c->note }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Complaint Type:</strong>
                        <p class="mb-0">{{ $c->complainType->name ?? 'Not specified' }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>User Remarks:</strong>
                        <p class="mb-0">{{ $c->user_remarks ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>AO Remarks:</strong>
                        <p class="mb-0">{{ $c->ao_remarks ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Final Commissioner Decision:</strong>
                        <p class="mb-0">{{ $c->commissioner_remarks ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
</td>
</tr>

@empty
<tr>
<td colspan="9" class="text-center">No completed complaints</td>
</tr>
@endforelse
</tbody>
</table>

 <div class="d-flex justify-content-end align-items-center">
    <div class="col-md-2 p-0">
        <form method="GET">
         
            <select name="per_page" class="form-control" onchange="this.form.submit()">
                @foreach([10, 20, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected' : '' }}>
                        Page {{ $size }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    </div>
</div>

</div>
</div>
@endsection
@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script>
    document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(link => {
    link.addEventListener('shown.bs.tab', function (e) {
        document.getElementById('active_tab').value = e.target.dataset.bsTarget.substring(1); // "pending" or "closed"
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const filterBox = document.getElementById('filterBox');
    const arrow = document.getElementById('arrow');

    filterBox.addEventListener('show.bs.collapse', () => arrow.innerHTML = '▲');
    filterBox.addEventListener('hide.bs.collapse', () => arrow.innerHTML = '▼');
});
</script>
@endsection