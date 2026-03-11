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
border-radius:10px;
transition:0.25s;
box-shadow:0 2px 6px rgba(0,0,0,0.06);
}

.stat-card:hover{
transform:translateY(-3px);
box-shadow:0 12px 25px rgba(0,0,0,0.10);
}

.stat-icon{
font-size:24px;
}

.stat-number{
font-size:28px;
font-weight:700;
margin-bottom:3px;
}

/* GOVERNMENT STYLE COLORS */

.bg-total{
background:#e6f4ea;
color:#1e7e34;
}

.bg-today{
background:#e8f7fb;
color:#0c5460;
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

@foreach(['Today'=>$highestToday,'This Month'=>$highestMonth,'This Year'=>$highestYear] as $period=>$data)

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

<div class="col-lg-2 col-md-4 col-6">
<div class="card stat-card bg-total border-0">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-star-fill"></i></div>
<div class="stat-number">{{ $totalRatings ?? 0 }}</div>
<div>Total Ratings</div>
</div>
</div>
</div>


<div class="col-lg-2 col-md-4 col-6">
<div class="card stat-card bg-today border-0">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-calendar-day"></i></div>
<div class="stat-number">{{ $todayRatings ?? 0 }}</div>
<div>Today's Feedback</div>
</div>
</div>
</div>


<div class="col-lg-2 col-md-4 col-6">
<div class="card stat-card bg-month border-0">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-calendar-month"></i></div>
<div class="stat-number">{{ $monthRatings ?? 0 }}</div>
<div>This Month</div>
</div>
</div>
</div>


<div class="col-lg-2 col-md-4 col-6">
<div class="card stat-card bg-pending border-0">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-hourglass-split"></i></div>
<div class="stat-number">{{ $pending ?? 0 }}</div>
<div>Pending</div>
</div>
</div>
</div>


<div class="col-lg-2 col-md-4 col-6">
<div class="card stat-card bg-ao border-0">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-person-badge"></i></div>
<div class="stat-number">{{ $ao ?? 0 }}</div>
<div>At AO</div>
</div>
</div>
</div>


<div class="col-lg-2 col-md-4 col-6">
<div class="card stat-card bg-commissioner border-0">
<div class="card-body text-center">
<div class="stat-icon mb-2"><i class="bi bi-person-workspace"></i></div>
<div class="stat-number">{{ $commissioner ?? 0 }}</div>
<div>Commissioner</div>
</div>
</div>
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

<a href="{{ route('admin.complain.index') }}" 
class="btn btn-sm btn-primary">
View All
</a>

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
Top DS Divisions (Average Rating)
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