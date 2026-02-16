@extends('layouts.app')

@section('title')
    <title>Counters Feedbacks - PDMT</title>
@endsection

@section('content')
<div class="container">

    <h2 class="mb-4">Counters Feedbacks</h2>

    {{-- FILTER FORM --}}
    <form method="GET" class="row mb-3 g-2">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Search by name, phone, vehicle number or note">
        </div>

        <div class="col-md-3">
            <select name="counter" class="form-control">
                <option value="">-- All Counters --</option>
                @foreach($counters as $counter)
                    <option value="{{ $counter->id }}"
                        {{ request('counter') == $counter->id ? 'selected' : '' }}>
                        {{ $counter->division_name }} – {{ $counter->counter_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <input type="date" name="start_date"
                   value="{{ request('start_date') }}"
                   class="form-control">
        </div>

        <div class="col-md-2">
            <input type="date" name="end_date"
                   value="{{ request('end_date') }}"
                   class="form-control">
        </div>
<div class="col-md-1 d-grid">
    <button class="btn btn-primary"> <i class="bi bi-funnel-fill me-1"></i></button>
</div>

@if(request()->hasAny(['search','counter','start_date','end_date']))
<div class="col-md-1 d-grid">
    <a href="{{ route('admin.feedback.index') }}" 
       class="btn btn-danger">
           <i class="bi bi-arrow-clockwise me-1"></i>
    </a>
</div>
@endif

    </form>

    {{-- ACTIONS --}}
    <div class="d-flex justify-content-end mb-3">
        <button onclick="window.print()" class="btn btn-primary me-2">Print</button>

        <a href="{{ route('admin.feedback.downloadPdf', request()->query()) }}"
           class="btn btn-danger">
            Download PDF
        </a>
    </div>

    {{-- TABLE --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>DS Division</th>
                <th>Counter</th>
                <th>Vehicle</th>
                <th>Phone</th>
                <th>Rating</th>
                <th>Service Quality</th>
                <th>Complaint</th>
                <th>Submitted</th>
                                <th>Action</th> {{-- New column for Forward --}}

            </tr>
        </thead>
        <tbody>
            @forelse($ratings as $index => $rating)
                <tr>
                    <td>{{ $ratings->firstItem() + $index }}</td>
                    <td>{{ $rating->counter->division_name ?? '-' }}</td>
                    <td>{{ $rating->counter->counter_name ?? '-' }}</td>
                    <td>{{ $rating->vehicle_number }}</td>
                    <td>{{ $rating->phone }}</td>
                    <td>{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? '-' }}</td>
                    <td>{{ ucfirst(str_replace('_',' ', $rating->service_quality)) }}</td>
                    <td>{{ $rating->note }}</td>
                    <td>{{ $rating->created_at->format('d M Y, H:i') }}</td>
                       <td>
                        @if($rating->note && $rating->status == 'pending')
                            <form method="POST" action="{{ route('admin.feedback.forward', $rating->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-info">📤 Forward</button>
                            </form>
                      @elseif($rating->status == 'forwarded')
        <span class="badge bg-success">Forwarded</span>
    @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No feedbacks found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $ratings->links() }}

</div>
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
