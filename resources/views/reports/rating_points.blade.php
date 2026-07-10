@extends('layouts.app')

@section('title')
Rating Points Report - PDMT
@endsection

@section('content')
<style>
    .table-card {
        border: 1px solid #dbe3ee;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-header {
        background-color: #f8fafc;
        color: #243b53;
        border-bottom: 1px solid #dbe3ee;
        font-weight: 600;
    }

    .report-card {
        border-radius: 12px;
    }

    .report-card h6 {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .report-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 8px;
        background: #facc15;
        color: #111827;
        font-weight: 600;
    }

    .report-table th {
        white-space: nowrap;
        font-size: 13px;
        background-color: #f3f6fa;
        color: #243b53;
        border-bottom: 1px solid #d2dceb;
        padding: 12px 14px;
    }

    .report-table td {
        vertical-align: middle;
        border-top: 1px solid #edf1f5;
        color: #5f6c7b;
        padding: 12px 14px;
    }

    .filter-card {
        border-radius: 12px;
    }

    .period-chip {
        text-transform: capitalize;
    }

    .report-table tbody tr:hover td {
        background-color: #f8fafc;
    }

    .table th,
    .table td {
        font-size: 14px;
    }

    @media print {
        .filter-card,
        .d-flex.flex-wrap.justify-content-between,
        .d-flex.flex-wrap.justify-content-end,
        .btn,
        form {
            display: none !important;
        }

        body {
            background: white;
            margin: 0;
            padding: 10px;
        }

        .container {
            max-width: 100%;
            margin: 0;
        }

        .table-card {
            page-break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ccc;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    }
</style>

<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h2 class="mb-0">Rating Points Report</h2>
        <div class="d-flex gap-2">
           
            <a href="{{ route('reports.rating-points.pdf') }}?period={{ $period }}&month={{ $selectedMonth }}&year={{ $selectedYear }}&division={{ $selectedDivision }}&from={{ $selectedFrom }}&to={{ $selectedTo }}" class="btn btn-danger btn-sm">
                <i class="ti ti-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <div class="card filter-card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">


                <div class="col-md-3">
                    <label class="form-label">Division</label>
                    <select name="division" class="form-control">
                        <option value="">All Divisions</option>
                        @foreach($divisions as $division)
                        <option value="{{ $division }}" {{ $selectedDivision === $division ? 'selected' : '' }}>{{ $division }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">From</label>
                    <input type="date" name="from" class="form-control" value="{{ $selectedFrom ?? '' }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">To</label>
                    <input type="date" name="to" class="form-control" value="{{ $selectedTo ?? '' }}">
                </div>



                <div class="col-md-1 d-grid">
                    <button class="btn btn-primary" type="submit">Go</button>
                </div>

                <div class="col-md-1 d-grid">
                    <a href="{{ route('reports.rating-points') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>



    <div class="card table-card shadow-sm mb-3">
        <div class="card-header table-header d-flex justify-content-between align-items-center">Rating Ranking</div>
        <div class="table-responsive">
            <table class="table report-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Division</th>
                        <th>Counter</th>
                        <th>Feedback Count</th>
                        <th>Average Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ranking as $index => $item)
                    <tr>
                        <td>{{ $ranking->firstItem() + $index }}</td>
                        <td>{{ $item->counter->division_name ?? '-' }}</td>
                        <td>{{ $item->counter->counter_name ?? '-' }}</td>
                        <td>{{ $item->total }}</td>
                        <td>{{ number_format($item->avg_rating, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No data found for selected filters</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

  <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">

    <form method="GET" class="d-flex align-items-center mb-2">

        @foreach(request()->except('per_page','page') as $key => $value)
            @if(is_array($value))
                @foreach($value as $v)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        <select name="per_page"
                class="form-control"
                onchange="this.form.submit()">

            @foreach([10,20,50,100] as $size)
                <option value="{{ $size }}"
                    {{ request('per_page',10) == $size ? 'selected' : '' }}>
                    Show {{ $size }}
                </option>
            @endforeach

        </select>

    </form>

    <div>
        {{ $ranking->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const periodSelect = document.getElementById('periodSelect');
        const monthField = document.getElementById('monthField');
        const yearField = document.getElementById('yearField');

        if (!periodSelect || !monthField || !yearField) {
            return;
        }

        function syncPeriodFields() {
            const value = periodSelect.value;
            monthField.style.display = value === 'month' ? 'block' : 'none';
            yearField.style.display = value === 'year' ? 'block' : 'none';
        }

        periodSelect.addEventListener('change', syncPeriodFields);
        syncPeriodFields();
    });
</script>
@endsection
