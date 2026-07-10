@extends('layouts.app')

@section('content')

<style>

/* ======================
SECTION TITLE
====================== */

.section-title{
font-size:18px;
font-weight:600;
margin:25px 0 15px 0;
color:#2c3e50;
border-left:4px solid #0d6efd;
padding-left:10px;
}

/* ======================
STAT CARDS
====================== */

.stat-card{
border-radius:12px;
transition:all 0.2s ease;
border:1px solid #dbe3ee;
box-shadow:0 2px 8px rgba(15, 23, 42, 0.06);
}

.stat-card:hover{
transform:translateY(-2px);
box-shadow:0 10px 22px rgba(15, 23, 42, 0.10);
}

.stat-icon{
font-size:20px;
width:42px;
height:42px;
margin:0 auto;
display:flex;
align-items:center;
justify-content:center;
border-radius:50%;
background:rgba(255,255,255,0.78);
}

.stat-number{
font-size:28px;
font-weight:700;
margin-bottom:3px;
}

/* GOVERNMENT STYLE COLORS */

.bg-total{
background:linear-gradient(180deg, #eef8f1 0%, #e4f2e9 100%);
color:#176a3d;
}

.bg-today{
background:linear-gradient(180deg, #f0f7fc 0%, #e6f1f8 100%);
color:#114d67;
}

.bg-month{
background:#eef2ff;
color:#2f4db3;
}

.bg-pending{
background:#fff3cd;
color:#856404;
}

.bg-ao{
background:#e2e3e5;
color:#383d41;
}

.bg-commissioner{
background:#fde2e1;
color:#842029;
}

/* ======================
TABLE DESIGN
====================== */

.dashboard-table{
background:#ffffff;
border-radius:10px;
overflow:hidden;
}

.dashboard-table thead{
background:#2f4db3;
color:#fff;
font-size:14px;
}

.dashboard-table thead th{
padding:12px;
border:none;
}

.dashboard-table tbody td{
padding:12px;
font-size:14px;
vertical-align:middle;
}

.dashboard-table tbody tr{
border-bottom:1px solid #f0f0f0;
transition:0.2s;
}

.dashboard-table tbody tr:hover{
background:#f5f8ff;
}

.table-card{
border-radius:10px;
box-shadow:0 3px 10px rgba(0,0,0,0.05);
}

.table-header{
background:#f4f6f9;
font-weight:600;
font-size:15px;
padding:12px;
}

/* STATUS BADGES */

.status-badge{
padding:6px 12px;
border-radius:20px;
font-size:12px;
font-weight:600;
}

.status-pending{
background:#fff3cd;
color:#856404;
}

.status-ao{
background:#d1ecf1;
color:#0c5460;
}

.status-commissioner{
background:#cfe2ff;
color:#084298;
}

.status-completed{
background:#d1e7dd;
color:#0f5132;
}

.status-rejected{
background:#f8d7da;
color:#842029;
}

/* ======================
RESPONSIVE
====================== */

@media (max-width:768px){

.stat-number{
font-size:24px;
}

.section-title{
font-size:16px;
}

}

</style>



{{-- ======================
TOP PERFORMING COUNTERS
====================== --}}

<div class="section-title">Top Performing Counters</div>

<div class="row g-3">

@foreach(['Today'=>$highestToday,'This Week'=>$highestWeek,'This Month'=>$highestMonth] as $period=>$data)

<div class="col-lg-4 col-md-6">

<div class="card shadow-sm border-0">

<div class="card-body text-center">

<h6 class="fw-bold">
🏆 Highest Feedback {{ $period }}
</h6>

<p class="text-muted small">
Division / Counter with most feedback
</p>

<h6>
{{ $data->counter->division_name ?? '-' }} /
{{ $data->counter->counter_name ?? '-' }}
</h6>

<span class="badge bg-warning text-dark mb-2">
{{ $data->total ?? 0 }} Feedbacks
</span>

<div class="fw-bold text-primary">
⭐ {{ number_format($data->avg_rating ?? 0,1) }} / 5
</div>

</div>

</div>

</div>

@endforeach

</div>



{{-- ======================
STATISTICS
====================== --}}

<div class="section-title">Dashboard Overview</div>

<div class="row g-3">

<div class="col-lg-4 col-md-6 col-12">
<a href="{{ route('admin.feedback.index') }}" class="text-decoration-none text-reset d-block h-100">
<div class="card stat-card bg-total h-100">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-star-fill"></i></div>
<div class="stat-number">{{ $totalRatings ?? 0 }}</div>
<div>Total Feedback</div>
</div>
</div>
</a>
</div>

<div class="col-lg-4 col-md-6 col-12">
<a href="{{ route('admin.complain.index') }}" class="text-decoration-none text-reset d-block h-100">
<div class="card stat-card bg-today h-100">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-chat-left-text-fill"></i></div>
<div class="stat-number">{{ $totalComplaints ?? 0 }}</div>
<div>Total Complaints</div>
</div>
</div>
</a>
</div>

<div class="col-lg-4 col-md-6 col-12">
<a href="{{ route('admin.manual-complaints.index') }}" class="text-decoration-none text-reset d-block h-100">
<div class="card stat-card bg-today h-100">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-clipboard-check"></i></div>
<div class="stat-number">{{ $totalManualFeedbackCount ?? 0 }}</div>
<div>Total Manual Feedback Count</div>
</div>
</div>
</a>
</div>

</div>



{{-- ======================
TABLE SECTION
====================== --}}

<div class="row mt-4 g-3">


{{-- Latest Complaints --}}
<div class="col-lg-6">

<div class="card table-card shadow-sm">

<div class="card-header table-header d-flex justify-content-between">

<span>Latest Complaints</span>

@php $role = auth()->user()->role; @endphp

@if($role == 'Administrative Officer')
    <a href="{{ route('admin.ao.index') }}" class="btn btn-sm btn-primary">
        View All
    </a>

@elseif($role == 'Commissioner')
    <a href="{{ route('admin.commissioner.index') }}" class="btn btn-sm btn-primary">
        View All
    </a>

@else
    <a href="{{ route('admin.complain.index') }}" class="btn btn-sm btn-primary">
        View All
    </a>
@endif

</div>

<div class="table-responsive">

<table class="table dashboard-table mb-0">

<thead>
<tr>
<th>Vehicle</th>
<th>Division</th>
<th>Rating</th>
<th>Status</th>
</tr>
</thead>

<tbody>

@forelse($latestComplaints as $complaint)

<tr>

<td class="fw-semibold">
{{ $complaint->vehicle_number }}
</td>

<td>
{{ $complaint->counter->division_name ?? '-' }}
</td>

<td>
{{ ['','⭐','⭐⭐','⭐⭐⭐','⭐⭐⭐⭐','⭐⭐⭐⭐⭐'][$complaint->rating] ?? '' }}
</td>

<td>

@if($complaint->status == null || $complaint->status == 'pending')
<span class="status-badge status-pending">Pending</span>

@elseif($complaint->status == 'ao')
<span class="status-badge status-ao">AO</span>

@elseif($complaint->status == 'commissioner')
<span class="status-badge status-commissioner">Commissioner</span>

@elseif($complaint->status == 'completed')
<span class="status-badge status-completed">Completed</span>

@elseif($complaint->status == 'rejected')
<span class="status-badge status-rejected">Rejected</span>
@endif

</td>

</tr>

@empty

<tr>
<td colspan="4" class="text-center">
No complaints found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>



{{-- Top DS Divisions --}}
<div class="col-lg-6">

<div class="card table-card shadow-sm">

<div class="card-header table-header">

<div class="row align-items-center">

<div class="col-md-9">
Top DS Divisions (Average Rating)
</div>
<div class="col-md-3">
<form method="GET" class="d-flex">

<select name="period" class="form-select form-select-sm"
onchange="this.form.submit()">

<option value="today" {{ request('period')=='today'?'selected':'' }}>
Today
</option>

<option value="week" {{ request('period')=='week'?'selected':'' }}>
This Week
</option>

<option value="month" {{ request('period')=='month'?'selected':'' }}>
This Month
</option>

<option value="year" {{ request('period')=='year'?'selected':'' }}>
This Year
</option>

</select>

</form>

</div>
</div>
</div>

<div class="table-responsive">

<table class="table dashboard-table mb-0">

<thead>
<tr>
<th>Rank</th>
<th>Division</th>
<th>Average Rating</th>
</tr>
</thead>

<tbody>

@forelse($topDivisions as $index => $division)

<tr>

<td>
<span class="badge bg-primary">
{{ $index + 1 }}
</span>
</td>

<td class="fw-semibold">
{{ $division->counter->division_name ?? '-' }}
</td>

<td class="text-warning fw-bold">
⭐ {{ number_format($division->avg_rating,1) }}
</td>

</tr>

@empty

<tr>
<td colspan="3" class="text-center">
No ranking data
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</div>

@endsection



@push('scripts')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@endpush
