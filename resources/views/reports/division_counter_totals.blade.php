@extends('layouts.app')

@section('title', 'Division Counter Total Report - PDMT')

@section('content')
@include('reports.partials.report_table_styles')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h2 class="mb-0">Division Counter Total Report</h2>
        <a href="{{ route('reports.division-counter-totals.pdf', request()->except('page', 'per_page')) }}" class="btn btn-danger btn-sm">
            <i class="ti ti-file-pdf"></i> Export PDF
        </a>
    </div>

    

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3"><label class="form-label">Division</label><select name="division" class="form-select">
                        <option value="">All Divisions</option>
                        @foreach($divisions as $division)<option value="{{ $division }}" @selected(request('division')===$division)>{{ $division }}</option>@endforeach
                    </select></div>
                <div class="col-md-3"><label class="form-label">Counter</label><select name="counter" class="form-select">
                        <option value="">All Counters</option>
                        @foreach($counters as $counter)<option value="{{ $counter->id }}" @selected((string) request('counter')===(string) $counter->id)>{{ $counter->division_name }} - {{ $counter->counter_name }}</option>@endforeach
                    </select></div>
                <div class="col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
                <div class="col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
                <div class="col-md-1 d-grid"><button class="btn btn-primary">Go</button></div>
                <div class="col-md-1 d-grid"><a href="{{ route('reports.division-counter-totals') }}" class="btn btn-outline-secondary">Reset</a></div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table report-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Division</th>
                        <th>Counter</th>
                        <th class="text-center">Total Submissions</th>
                        <th class="text-center">Feedback Only</th>
                        <th class="text-center">QR Complaints</th>
                    </tr>
                </thead>
                <tbody>@forelse($rows as $index => $row)<tr>
                        <td>{{ $rows->firstItem() + $index }}</td>
                        <td>{{ $row->division_name }}</td>
                        <td>{{ $row->counter_name }}</td>
                        <td class="text-center fw-bold">{{ $row->total_count }}</td>
                        <td class="text-center">{{ $row->feedback_only_count }}</td>
                        <td class="text-center">{{ $row->complaint_count }}</td>
                    </tr>
                    @empty<tr>
                        <td colspan="6" class="text-center py-4">No records found</td>
                    </tr>@endforelse</tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td colspan="3">Grand Total</td>
                        <td class="text-center">{{ $grandTotals->total_count }}</td>
                        <td class="text-center">{{ $grandTotals->feedback_only_count }}</td>
                        <td class="text-center">{{ $grandTotals->complaint_count }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
        <form method="GET">
            @foreach(request()->except('per_page', 'page') as $key => $value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach
            <select name="per_page" class="form-select" onchange="this.form.submit()">@foreach([10,20,50,100] as $size)<option value="{{ $size }}" @selected($perPage===$size)>Show {{ $size }}</option>@endforeach</select>
        </form>
        {{ $rows->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
