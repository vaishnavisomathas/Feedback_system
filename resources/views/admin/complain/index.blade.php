@extends('layouts.app')

@section('title')
<title>Complaints - PDMT</title>
@endsection

@section('content')
<div class="container">

<h2 class="mb-4">Complaint Management</h2>

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

            <div class="col-md-3">
                <label>DS Division</label>
                <input type="text" name="division" value="{{ request('division') }}" class="form-control" placeholder="Enter Division">
            </div>

            <div class="col-md-3">
                <label>Counter</label>
                <input type="text" name="counter" value="{{ request('counter') }}" class="form-control" placeholder="Enter Counter">
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

            <div class="col-md-12 mt-3">
                <button class="btn btn-primary"> <i class="bi bi-search"></i> </button>
                <a href="{{ url()->current() }}" class="btn btn-danger"><i class="bi bi-arrow-clockwise me-1"></i></a>
            </div>

        </form>

    </div>

</div>

{{-- TABS --}}
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all">
            Pending Complaints
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#read">
            All Complaints
        </button>
    </li>
</ul>

<div class="tab-content">

{{-- ================= ALL COMPLAINTS ================= --}}
<div class="tab-pane fade show active" id="all">

<table class="table table-bordered table-hover">
<thead class="table-dark">
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

<tbody>
@forelse($allRatings as $index => $rating)

<tr data-bs-toggle="collapse"
    data-bs-target="#complaint{{ $rating->id }}"
    style="cursor:pointer">

<td>{{ $allRatings->firstItem() + $index }}</td>

<td>
    {{ $rating->counter->division_name ?? '-' }} 
  
</td>
<td>  {{ $rating->counter->counter_name ?? '-' }}</td>
<td>{{ $rating->vehicle_number }}</td>
<td>{{ $rating->phone }}</td>
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

    @elseif($rating->status == 'commissioner')
        <span class="badge bg-primary">Sent to Commissioner</span>

    @elseif($rating->status == 'completed')
        <span class="badge bg-success">Completed</span>

    @else
        <span class="badge bg-secondary">Unknown</span>
    @endif
        &nbsp;&nbsp;<span class="float-end">▼</span>

</td>


</tr>

{{-- DETAILS --}}
<tr class="collapse bg-light" id="complaint{{ $rating->id }}">
<td colspan="9">

<div class="p-3">

<div class="mb-3">
<strong>Complaint:-</strong>{{ $rating->note ?? 'No complaint provided' }}
</div>

<form method="POST" action="{{ route('admin.complain.remarks',$rating->id) }}">
@csrf

<div class="mb-3">
<label><strong>Complaint Type:-</strong></label>
<select name="complain_type_id" class="form-control">
    <option value="">-- Select Type --</option>
    @foreach($types as $type)
        <option value="{{ $type->id }}"
            {{ $rating->complain_type_id == $type->id ? 'selected' : '' }}>
            {{ $type->name }}
        </option>
    @endforeach
</select>
</div>

<label><strong>Remarks:-</strong></label>
<textarea name="user_remarks" class="form-control" rows="3">{{ $rating->remarks }}</textarea>

<button class="btn btn-danger btn-sm">
    Forward to Administrative Officer
</button>



</form>

</div>

</td>
</tr>

@empty
<tr><td colspan="9" class="text-center">No complaints</td></tr>
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

{{-- ================= All COMPLAINTS ================= --}}
<div class="tab-pane fade" id="read">

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
<th>Date</th>
<th>Status</th>
</tr>
</thead>

<tbody>
@forelse($readRatings as $index => $rating)

<tr data-bs-toggle="collapse"
    data-bs-target="#readComplaint{{ $rating->id }}"
    style="cursor:pointer">

<td>{{ $readRatings->firstItem() + $index }}</td>

<td>
    {{ $rating->counter->division_name ?? '-' }} 
  
</td>
<td>  {{ $rating->counter->counter_name ?? '-' }}</td>
<td>{{ $rating->vehicle_number }}</td>
<td>{{ $rating->phone }}</td>

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

        @case('ao')
            <span class="badge bg-info"></span>
        @break

        @case('commissioner')
            <span class="badge bg-primary">At Commissioner</span>
        @break

        @case('completed')
            <span class="badge bg-success">Completed</span>
        @break

        @case('rejected')
            <span class="badge bg-danger">Rejected</span>
        @break

        @default
            <span class="badge bg-dark">Unknown</span>

    @endswitch
            &nbsp;&nbsp;<span class="float-end">▼</span>

</td>
</tr>

<tr class="collapse bg-light" id="readComplaint{{ $rating->id }}">
<td colspan="9">

<div class="p-3">

<div class="mb-3">
<strong>Complaint:-</strong>{{ $rating->note }}
</div>

<div class="mb-3">
<strong>Complaint Type:-</strong><br>
{{ $rating->complainType->name ?? 'Not specified' }}
</div>

<div class="mb-3">
<strong>Remarks:-</strong><br>
{{ $rating->user_remarks ?? 'No remarks added' }}
</div>


</div>

</td>
</tr>

@empty
<tr><td colspan="9" class="text-center">No resolved complaints</td></tr>
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

<style>
tr[aria-expanded="true"] span { transform: rotate(180deg); }
span { transition: 0.2s; }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const filterBox = document.getElementById('filterBox');
    const arrow = document.getElementById('arrow');

    filterBox.addEventListener('show.bs.collapse', () => arrow.innerHTML = '▲');
    filterBox.addEventListener('hide.bs.collapse', () => arrow.innerHTML = '▼');
});
</script>

@endsection