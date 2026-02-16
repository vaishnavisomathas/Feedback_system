@extends('layouts.app')

@section('content')
<div class="row">

    <!-- Total Ratings -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Ratings</h5>
                <p class="card-subtitle mb-2">All submitted ratings from DS Divisions</p>
                <h2>{{ $totalRatings ?? 0 }}</h2>
                <span class="badge bg-success">Updated</span>
            </div>
        </div>
    </div>

    <!-- New Ratings Today -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">New Ratings Today</h5>
                <p class="card-subtitle mb-2">Ratings submitted in the last 24 hours</p>
                <h2>{{ $todayRatings ?? 0 }}</h2>
                <span class="badge bg-info">Ongoing</span>
            </div>
        </div>
    </div>
<div class="col-lg-4 col-md-6">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">New Ratings This Month</h5>
            <p class="card-subtitle mb-2">Ratings submitted in the current month</p>
            <h2>{{ $monthRatings ?? 0 }}</h2>
            <span class="badge bg-primary">Ongoing</span>
        </div>
    </div>
</div>
    <!-- Highest Feedback Today -->
    <div class="col-lg-4 col-md-6 mt-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Highest Feedback Today</h5>
                <p class="card-subtitle mb-2">Division / Counter with most feedbacks today</p>
                <h2>{{ $highestToday->counter->division_name ?? '-' }} / {{ $highestToday->counter->counter_name ?? '-' }}</h2>
                <span class="badge bg-warning">{{ $highestToday->total ?? 0 }} Feedbacks</span>
            </div>
        </div>
    </div>

    <!-- Highest Feedback This Month -->
    <div class="col-lg-4 col-md-6 mt-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Highest Feedback This Month</h5>
                <p class="card-subtitle mb-2">Division / Counter with most feedbacks this month</p>
                <h2>{{ $highestMonth->counter->division_name ?? '-' }} / {{ $highestMonth->counter->counter_name ?? '-' }}</h2>
                <span class="badge bg-warning">{{ $highestMonth->total ?? 0 }} Feedbacks</span>
            </div>
        </div>
    </div>

    <!-- Highest Feedback This Year -->
    <div class="col-lg-4 col-md-6 mt-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Highest Feedback This Year</h5>
                <p class="card-subtitle mb-2">Division / Counter with most feedbacks this year</p>
                <h2>{{ $highestYear->counter->division_name ?? '-' }} / {{ $highestYear->counter->counter_name ?? '-' }}</h2>
                <span class="badge bg-warning">{{ $highestYear->total ?? 0 }} Feedbacks</span>
            </div>
        </div>
    </div>

    <!-- Feedback Chart -->
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Feedback Counts by Division</h5>
                <p class="card-subtitle mb-3">Feedback counts for Today, This Month, and This Year</p>
                <canvas id="ratingsChart" height="100"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection
<canvas id="ratingsChart" height="100"></canvas>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('ratingsChart').getContext('2d');

const divisionLabels = {!! json_encode($divisionLabels) !!};
const todayChart = {!! json_encode($todayChart) !!};
const monthChart = {!! json_encode($monthChart) !!};
const yearChart = {!! json_encode($yearChart) !!};

if(divisionLabels.length > 0) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: divisionLabels,
            datasets: [
                { label: 'Today', data: todayChart, backgroundColor: '#0d6efd' },
                { label: 'This Month', data: monthChart, backgroundColor: '#198754' },
                { label: 'This Year', data: yearChart, backgroundColor: '#ffc107' }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
} else {
    ctx.font = "16px Arial";
    ctx.fillText("No data available", 50, 50);
}
</script>
@endpush
