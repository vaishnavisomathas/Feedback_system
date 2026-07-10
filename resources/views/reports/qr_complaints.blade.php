@extends('layouts.app')

@section('title', 'QR Complaint Report - PDMT')

@section('content')
@include('reports.partials.report_table_styles')
<div class="container">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h2 class="mb-0">QR Complaint Report</h2>
        <a href="{{ route('reports.qr-complaints.pdf', request()->except('page', 'per_page')) }}" class="btn btn-danger btn-sm">
            <i class="ti ti-file-pdf"></i> Export PDF
        </a>
    </div>

    

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3"><label class="form-label">Division - Counter</label>
                    <select name="counter" class="form-select">
                        <option value="">All Counters</option>
                        @foreach($counters as $counter)<option value="{{ $counter->id }}" @selected((string) request('counter')===(string) $counter->id)>{{ $counter->division_name }} - {{ $counter->counter_name }}</option>@endforeach
                    </select>
                </div>
            
                <div class="col-md-2"><label class="form-label">Complaint Type</label>
                    <select name="complain_type" class="form-select">
                        <option value="">All Types</option>
                        @foreach($types as $type)<option value="{{ $type->id }}" @selected((string) request('complain_type')===(string) $type->id)>{{ $type->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-2"><label class="form-label">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
                <div class="col-md-2"><label class="form-label">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Search</label><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Phone, email, vehicle, complaint"></div>
<div class="col-md-12 d-flex justify-content-end gap-2 mt-2">

    <button type="submit" class="btn btn-primary">
        Go
    </button>

    <a href="{{ route('reports.qr-complaints') }}"
       class="btn btn-outline-secondary">
        Reset
    </a>

</div>        
  </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table report-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Division / Counter</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Vehicle</th>
                        <th>Type</th>
                        <th>Rating</th>
                        <th>Complaint</th>
                    </tr>
                </thead>
                <tbody>@forelse($complaints as $index => $item)<tr>
                        <td>{{ $complaints->firstItem() + $index }}</td>
                        <td>{{ $item->created_at?->format('d M Y') }}</td>
                        <td>{{ $item->counter->division_name ?? '-' }}<br>{{ $item->counter->counter_name ?? '-' }}</td>
                        <td>{{ $item->phone ?? '-' }}</td>
                        <td>{{ $item->complaint_email ?? '-' }}</td>
                        <td>{{ $item->vehicle_number ?? '-' }}</td>
                        <td>{{ $item->complainType->name ?? '-' }}</td>
                        <td>{{ ['','Bad','Poor','Average','Good','Excellent'][$item->rating] ?? '-' }}</td>
                        <td style="min-width:240px">{{ $item->note }}</td>
                    </tr>@empty<tr>
                        <td colspan="10" class="text-center py-4">No QR complaints found</td>
                    </tr>@endforelse</tbody>
            </table>
        </div>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
        <form method="GET">@foreach(request()->except('per_page', 'page') as $key => $value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach
            <select name="per_page" class="form-select" onchange="this.form.submit()">@foreach([10,20,50,100] as $size)<option value="{{ $size }}" @selected($perPage===$size)>Show {{ $size }}</option>@endforeach</select>
        </form>
        {{ $complaints->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
