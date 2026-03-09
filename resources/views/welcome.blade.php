@extends('layouts.app')

@section('content')

<style>

.dashboard-card{
border-radius:12px;
transition:0.25s;
}

.dashboard-card:hover{
transform:translateY(-4px);
box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.card-icon{
font-size:28px;
margin-bottom:8px;
}

.card-number{
font-size:32px;
font-weight:700;
}

/* Light backgrounds */

.bg-total{ background:#e8f8f1; color:#28a745; }
.bg-today{ background:#e7f9ff; color:#17a2b8; }
.bg-month{ background:#eef3ff; color:#4e73df; }
.bg-pending{ background:#fff8e1; color:#f6c23e; }
.bg-ao{ background:#f1f3f5; color:#6c757d; }
.bg-commissioner{ background:#fdecea; color:#dc3545; }

.feedback-card{
background:#ffffff;
border-radius:12px;
}

</style>

<div class="row g-3">
<!-- Highest Feedback -->
@foreach(['Today' => $highestToday, 'This Month' => $highestMonth, 'This Year' => $highestYear] as $period => $data)

<div class="col-lg-4 col-md-6">
<div class="card feedback-card shadow-sm border-0">

<div class="card-body text-center">

<h6 class="fw-bold">
🏆 Highest Feedback {{ $period }}
</h6>

<p class="text-muted small">
Division / Counter with most feedbacks
</p>

<h6>
{{ $data->counter->division_name ?? '-' }} /
{{ $data->counter->counter_name ?? '-' }}
</h6>

<span class="badge bg-warning text-dark mb-2">
{{ $data->total ?? 0 }} Feedbacks
</span>

<div class="fw-bold text-primary">
⭐ {{ number_format($data->avg_rating ?? 0, 1) }} / 5
</div>

</div>

</div>
</div>

@endforeach
<!-- Total Ratings -->
<div class="col-lg-4 col-md-6">
<div class="card dashboard-card bg-total border-0">
<div class="card-body text-center">
<div class="card-icon"><i class="bi bi-star-fill"></i></div>
<h6>Total Ratings</h6>
<div class="card-number">{{ $totalRatings ?? 0 }}</div>
</div>
</div>
</div>

<!-- Today Ratings -->
<div class="col-lg-4 col-md-6">
<div class="card dashboard-card bg-today border-0">
<div class="card-body text-center">
<div class="card-icon"><i class="bi bi-calendar-day"></i></div>
<h6>New Ratings Today</h6>
<div class="card-number">{{ $todayRatings ?? 0 }}</div>
</div>
</div>
</div>

<!-- Month Ratings -->
<div class="col-lg-4 col-md-6">
<div class="card dashboard-card bg-month border-0">
<div class="card-body text-center">
<div class="card-icon"><i class="bi bi-calendar-month"></i></div>
<h6>New Ratings This Month</h6>
<div class="card-number">{{ $monthRatings ?? 0 }}</div>
</div>
</div>
</div>

<!-- Pending -->
<div class="col-lg-4 col-md-6">
<div class="card dashboard-card bg-pending border-0">
<div class="card-body text-center">
<div class="card-icon"><i class="bi bi-hourglass-split"></i></div>
<h6>Pending Complaints</h6>
<div class="card-number">{{ $pending ?? 0 }}</div>
</div>
</div>
</div>

<!-- AO -->
<div class="col-lg-4 col-md-6">
<div class="card dashboard-card bg-ao border-0">
<div class="card-body text-center">
<div class="card-icon"><i class="bi bi-person-badge"></i></div>
<h6>Forwarded to A/O</h6>
<div class="card-number">{{ $ao ?? 0 }}</div>
</div>
</div>
</div>

<!-- Commissioner -->
<div class="col-lg-4 col-md-6">
<div class="card dashboard-card bg-commissioner border-0">
<div class="card-body text-center">
<div class="card-icon"><i class="bi bi-person-workspace"></i></div>
<h6>Forwarded to Commissioner</h6>
<div class="card-number">{{ $commissioner ?? 0 }}</div>
</div>
</div>
</div>




{{-- ================= TABLE SECTION ================= --}}
<div class="row mt-4 g-3">


{{-- Latest Complaints --}}
<div class="col-lg-6">

<div class="card shadow-sm border-0">

<div class="card-header d-flex justify-content-between align-items-center bg-light">

<h6 class="mb-0">Latest Complaints</h6>

<a href="{{ route('admin.complain.index') }}" class="btn btn-sm btn-primary">
View All
</a>

</div>

<div class="card-body p-0">

<table class="table table-striped mb-0">

<thead class="table-dark">
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

<td>{{ $complaint->vehicle_number }}</td>

<td>{{ $complaint->counter->division_name ?? '-' }}</td>

<td>
{{ ['','⭐','⭐⭐','⭐⭐⭐','⭐⭐⭐⭐','⭐⭐⭐⭐⭐'][$complaint->rating] ?? '' }}
</td>

<td>

@if($complaint->status == null || $complaint->status == 'pending')
<span class="badge bg-warning text-dark">Pending</span>

@elseif($complaint->status == 'ao')
<span class="badge bg-info">AO</span>

@elseif($complaint->status == 'commissioner')
<span class="badge bg-primary">Commissioner</span>

@elseif($complaint->status == 'completed')
<span class="badge bg-success">Completed</span>

@elseif($complaint->status == 'rejected')
<span class="badge bg-danger">Rejected</span>
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



{{-- Top Divisions Leaderboard --}}
<div class="col-lg-6">

<div class="card shadow-sm border-0">

<div class="card-header bg-light">
<h6 class="mb-0">Top DS Divisions (Avg Rating)</h6>
</div>

<div class="card-body p-0">

<table class="table table-striped mb-0">

<thead class="table-dark">
<tr>
<th>Rank</th>
<th>Division</th>
<th>Avg Rating</th>
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

<td>
{{ $division->counter->division_name ?? '-' }}
</td>

<td class="fw-bold text-warning">
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

</div>


@endsection


@push('scripts')

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

@endpush