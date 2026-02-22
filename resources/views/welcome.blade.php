@extends('layouts.app')

@section('content')
<div class="row g-3">

    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="card-title">Total Ratings</h5>
                <p class="text-muted mb-2">All submitted ratings from DS Divisions</p>
                <h2 class="display-6">{{ $totalRatings ?? 0 }}</h2>
                <span class="badge bg-success">Updated</span>
            </div>
        </div>
    </div>

    <!-- New Ratings Today -->
    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="card-title">New Ratings Today</h5>
                <p class="text-muted mb-2">Ratings submitted in the last 24 hours</p>
                <h2 class="display-6">{{ $todayRatings ?? 0 }}</h2>
                <span class="badge bg-info">Ongoing</span>
            </div>
        </div>
    </div>

    <!-- New Ratings This Month -->
    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="card-title">New Ratings This Month</h5>
                <p class="text-muted mb-2">Ratings submitted in the current month</p>
                <h2 class="display-6">{{ $monthRatings ?? 0 }}</h2>
                <span class="badge bg-primary">Ongoing</span>
            </div>
        </div>
    </div>

    <!-- Pending / AO / Commissioner -->
    <div class="col-lg-4 col-md-6 mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="card-title">Pending Complaint</h5>
                <h2 class="display-6">{{ $pending ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="card-title">Forwarded to A/O</h5>
                <h2 class="display-6">{{ $ao ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mt-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h5 class="card-title">Forwarded to Commissioner</h5>
                <h2 class="display-6">{{ $commissioner ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <!-- Highest Feedback -->
 @foreach(['Today' => $highestToday, 'This Month' => $highestMonth, 'This Year' => $highestYear] as $period => $data)
<div class="col-lg-4 col-md-6 mt-3">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center">

            <h5 class="card-title">Highest Feedback {{ $period }}</h5>
            <p class="text-muted mb-2">Division / Counter with most feedbacks</p>

            <h6>
                {{ $data->counter->division_name ?? '-' }} /
                {{ $data->counter->counter_name ?? '-' }}
            </h6>

            <!-- TOTAL -->
            <span class="badge bg-warning mb-2">
                {{ $data->total ?? 0 }} Feedbacks
            </span>

            <!-- ⭐ AVERAGE RATING -->
            <div class="fw-bold text-primary">
                ⭐ {{ number_format($data->avg_rating ?? 0, 1) }} / 5
            </div>

        </div>
    </div>
</div>
@endforeach




</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endpush