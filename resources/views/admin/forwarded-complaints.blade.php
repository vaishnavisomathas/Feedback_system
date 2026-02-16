@extends('layouts.app')

@section('title')
    <title>Forwarded Complaints - PDMT</title>
@endsection
<style>
.arrow {
    display: inline-block;
    transition: transform 0.3s ease;
}

.rotate {
    transform: rotate(180deg);
}
</style>

@section('content')
<div class="container">
  @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h4 class="mb-4">Forwarded Complaints</h4>
<form method="GET" class="row g-2 mb-4">

    {{-- Division / Counter --}}
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

    {{-- Service Quality --}}
    <div class="col-md-3">
        <select name="service_quality" class="form-control">
            <option value="">-- Service Quality --</option>
            <option value="good" {{ request('service_quality')=='good'?'selected':'' }}>Good</option>
            <option value="average" {{ request('service_quality')=='average'?'selected':'' }}>Average</option>
            <option value="poor" {{ request('service_quality')=='poor'?'selected':'' }}>Poor</option>
        </select>
    </div>

    {{-- Start Date --}}
    <div class="col-md-2">
        <input type="date" name="start_date"
               value="{{ request('start_date') }}"
               class="form-control">
    </div>

    {{-- End Date --}}
    <div class="col-md-2">
        <input type="date" name="end_date"
               value="{{ request('end_date') }}"
               class="form-control">
    </div>

    <div class="col-md-2 d-grid">
        <button class="btn btn-primary">Filter</button>
    </div>
@if(request()->hasAny(['counter','service_quality','start_date','end_date']))
    <div class="col-md-1 d-grid">
        <a href="{{ route('admin.forwarded-complaints') }}" 
           class="btn btn-secondary">
            Clear
        </a>
    </div>
@endif

</form>

    <table class="table table-bordered table-striped">
    <thead>
<tr>
    <th>#</th>
    <th>Division – Counter</th>
    <th>Vehicle</th>
    <th>Phone</th>
    <th>Date</th>
</tr>
</thead>


       <tbody>
@forelse($ratings as $index => $rating)

    {{-- Main Row --}}
    <tr data-bs-toggle="collapse"
        data-bs-target="#complaint{{ $rating->id }}"
        style="cursor: pointer;">
    <td>
            {{ $index + 1 }}
        </td>        <td>
            {{ $rating->counter->division_name ?? '-' }} –
            {{ $rating->counter->counter_name ?? '-' }}
        </td>
        <td>{{ $rating->vehicle_number }}</td>
        <td>{{ $rating->phone }}</td>
        <td>           
{{ $rating->created_at->format('d M Y') }} &nbsp; &nbsp; &nbsp; &nbsp;<span class="arrow me-2">▼</span>
</td> 
    </tr>
<tr class="collapse bg-light" id="complaint{{ $rating->id }}">
    <td colspan="5">
        <table class="table mb-0">
            <tr>
                <th style="width:150px;">Complaint</th>
                <th style="width:150px;">Service Quality</th>
                 <tbody>
                <td>{{ $rating->note ?? 'No complaint provided' }}</td>
                <td>{{ ucfirst(str_replace('_',' ', $rating->service_quality)) ?? 'N/A' }}</td>
                 </tbody>
            </tr>
        </table>
    </td>
</tr>


@empty
    <tr>
        <td colspan="5" class="text-center">No forwarded complaints</td>
    </tr>
@endforelse
</tbody>

    </table>

</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.accordion-toggle').forEach(function (row) {
        row.addEventListener('click', function () {
            const arrow = this.querySelector('.arrow');
            arrow.classList.toggle('rotate');
        });
    });
});
</script>
