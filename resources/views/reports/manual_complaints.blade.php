@extends('layouts.app')

@section('title', 'Manual Complaint Report - PDMT')

@section('content')
@include('reports.partials.report_table_styles')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h2 class="mb-0">Manual Complaint Report</h2>
        <a href="{{ route('reports.manual-complaints.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
            <i class="ti ti-file-pdf"></i> Export PDF
        </a>
    </div>

  

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-2"><label class="form-label">Source</label><select name="source_id" class="form-control">
                        <option value="">All Sources</option>
                        @foreach($sources as $source)<option value="{{ $source->id }}" @selected((string) request('source_id')===(string) $source->id)>{{ $source->name }}</option>@endforeach
                    </select></div>
                <div class="col-md-2"><label class="form-label">Status</label><select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        @foreach(['pending' => 'Pending', 'verified' => 'Verified', 'commissioner' => 'At Commissioner', 'completed' => 'Completed', 'rejected' => 'Rejected'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('status')===$value)>{{ $label }}</option>@endforeach
                    </select></div>
                <div class="col-md-2"><label class="form-label">From</label><input type="date" name="from" class="form-control" value="{{ request('from') }}"></div>
                <div class="col-md-2"><label class="form-label">To</label><input type="date" name="to" class="form-control" value="{{ request('to') }}"></div>
                <div class="col-md-2"><label class="form-label">Search</label><input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Name, phone, vehicle"></div>
                <div class="col-md-1 d-grid"><button class="btn btn-primary">Go</button></div>
                <div class="col-md-1 d-grid"><a href="{{ route('reports.manual-complaints') }}" class="btn btn-outline-secondary">Reset</a></div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table report-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Source</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Complaint</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $index => $item)
                    <tr>
                        <td>{{ $complaints->firstItem() + $index }}</td>
                        <td>{{ optional($item->received_at)->format('d M Y') ?? '-' }}</td>
                        <td>{{ $item->sourceSetting->name ?? $item->source ?? '-' }}</td>
                        <td>{{ $item->complainant_name ?? '-' }}</td>
                        <td>{{ $item->phone ?? '-' }}</td>
                        <td>{{ $item->vehicle_number ?? '-' }}</td>
                        <td>{{ $item->complainType->name ?? '-' }}</td>
                        <td style="min-width:220px">{{ $item->complaint }}</td>
                    </tr>
                    @empty<tr>
                        <td colspan="9" class="text-center py-4">No manual complaints found</td>
                    </tr>@endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <form method="GET">@foreach(request()->except('per_page', 'page') as $key => $value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach
            <select name="per_page" class="form-control" onchange="this.form.submit()">@foreach([10,20,50,100] as $size)<option value="{{ $size }}" @selected($perPage===$size)>Show {{ $size }}</option>@endforeach</select>
        </form>
        {{ $complaints->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
