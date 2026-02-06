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
                <span class="badge bg-success">Updated Today</span>
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

    <!-- Top Rated Division -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Top Rated Division</h5>
                <p class="card-subtitle mb-2">Division with highest average rating</p>
                <h2>{{ $topRatedDivision->ds_division ?? '-' }}</h2>
                <span class="badge bg-primary">{{ $topRatedDivision->avg_rating ?? '-' }}/5</span>
            </div>
        </div>
    </div>

    <!-- Recent Ratings Table -->
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Ratings</h5>
                <p class="card-subtitle mb-3">Latest ratings submitted by users</p>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>DS Division</th>
                                <th>User Name</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                       
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Ratings Chart -->
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Average Ratings by Division</h5>
                <p class="card-subtitle mb-3">Visual representation of DS Division ratings</p>
                <canvas id="ratingsChart" height="100"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ratingsChart').getContext('2d');
    const ratingsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($divisionLabels ?? []) !!},
            datasets: [{
                label: 'Average Rating',
                data: {!! json_encode($divisionData ?? []) !!},
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush
