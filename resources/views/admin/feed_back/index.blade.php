@extends('layouts.app')

@section('title')
    Counters Feedbacks - PDMT
@endsection

@section('content')
<div class="container">

    <h2 class="mb-4">Counters Feedbacks</h2>

    {{-- FILTER FORM --}}
    <form method="GET" class="row mb-3 g-2">
      

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
    <button class="btn btn-primary"> <i class="bi bi-search"></i></button>
    
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
              
                <th>Rating</th>
                <th>Service Quality</th>
               
                <th>Submitted</th>

            </tr>
        </thead>
        <tbody>
            @forelse($ratings as $index => $rating)
                <tr>
                    <td>{{ $ratings->firstItem() + $index }}</td>
                    <td>{{ $rating->counter->division_name ?? '-' }}</td>
                    <td>{{ $rating->counter->counter_name ?? '-' }}</td>
                   
                    <td>{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? '-' }}</td>
<td>{{ $rating->serviceQuality->name ?? '-' }}</td>
                    <td>{{ $rating->created_at->format('d M Y, H:i') }}</td>
                 
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No feedbacks found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
<div class="d-flex justify-content-end align-items-center">
    <div class="col-md-2 p-0">
        <form method="GET">
         
            <select name="per_page" class="form-control" onchange="this.form.submit()">
                @foreach([10, 20, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected' : '' }}>
                        Page {{ $size }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>




</div>
@endsection
@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection