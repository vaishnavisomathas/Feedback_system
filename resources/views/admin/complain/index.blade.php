@extends('layouts.app')

@section('title')
<title>Complaints - PDMT</title>
@endsection

@section('content')
<div class="container">

<h2 class="mb-4">Complaint Management</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- TABS --}}
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#all">
            Pending Complaints
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#read">
            All Complaints
        </button>
    </li>
</ul>

<div class="tab-content">

{{-- ================= ALL COMPLAINTS ================= --}}
<div class="tab-pane fade show active" id="all">

<table class="table table-bordered table-hover">
<thead class="table-dark">
<tr>
<th>#</th>
<th>DS Division</th>
<th>Counter</th>
<th>Vehicle</th>
<th>Phone</th>
<th>Service Quality</th>
<th>Rating</th>
<th>Date</th>
<th>Status</th> 
</tr>
</thead>

<tbody>
@forelse($allRatings as $index => $rating)

<tr data-bs-toggle="collapse"
    data-bs-target="#complaint{{ $rating->id }}"
    style="cursor:pointer">

<td>{{ $allRatings->firstItem() + $index }}</td>

<td>
    {{ $rating->counter->division_name ?? '-' }} 
  
</td>
<td>  {{ $rating->counter->counter_name ?? '-' }}</td>
<td>{{ $rating->vehicle_number }}</td>
<td>{{ $rating->phone }}</td>
<td>{{ $rating->serviceQuality->name ?? '-' }}</td>


<td>
{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? 'N/A' }}
</td>
<td>
    {{ $rating->created_at->format('d M Y') }}
</td>
<td>
    @if($rating->status == 'pending' || $rating->status == null)
        <span class="badge bg-warning text-dark">Pending</span>

    @elseif($rating->status == 'ao')
        <span class="badge bg-info">Sent to AO</span>

    @elseif($rating->status == 'commissioner')
        <span class="badge bg-primary">Sent to Commissioner</span>

    @elseif($rating->status == 'completed')
        <span class="badge bg-success">Completed</span>

    @else
        <span class="badge bg-secondary">Unknown</span>
    @endif
        &nbsp;&nbsp;<span class="float-end">▼</span>

</td>


</tr>

{{-- DETAILS --}}
<tr class="collapse bg-light" id="complaint{{ $rating->id }}">
<td colspan="9">

<div class="p-3">

<div class="mb-3">
<strong>Complaint:</strong><br>
{{ $rating->note ?? 'No complaint provided' }}
</div>

<form method="POST" action="{{ route('admin.complain.remarks',$rating->id) }}">
@csrf

<div class="mb-3">
<label><strong>Complaint Type</strong></label>
<select name="complain_type_id" class="form-control">
    <option value="">-- Select Type --</option>
    @foreach($types as $type)
        <option value="{{ $type->id }}"
            {{ $rating->complain_type_id == $type->id ? 'selected' : '' }}>
            {{ $type->name }}
        </option>
    @endforeach
</select>
</div>

<label><strong>Remarks</strong></label>
<textarea name="user_remarks" class="form-control" rows="3">{{ $rating->remarks }}</textarea>

<button type="submit"
        formaction="{{ route('admin.complain.forward',$rating->id) }}"
        class="btn btn-danger btn-sm mt-2">
    Forward to Administrative Officer
</button>


</form>

</div>

</td>
</tr>

@empty
<tr><td colspan="9" class="text-center">No complaints</td></tr>
@endforelse
</tbody>
</table>

{{ $allRatings->links() }}

</div>

{{-- ================= All COMPLAINTS ================= --}}
<div class="tab-pane fade" id="read">

<table class="table table-bordered table-hover">
<thead class="table-success">
<tr>
<th>#</th>
<th>DS Division</th>
<th>Counter</th>
<th>Vehicle</th>
<th>Phone</th>
<th>Service Quality</th>
<th>Rating</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>

<tbody>
@forelse($readRatings as $index => $rating)

<tr data-bs-toggle="collapse"
    data-bs-target="#readComplaint{{ $rating->id }}"
    style="cursor:pointer">

<td>{{ $readRatings->firstItem() + $index }}</td>

<td>
    {{ $rating->counter->division_name ?? '-' }} 
  
</td>
<td>  {{ $rating->counter->counter_name ?? '-' }}</td>
<td>{{ $rating->vehicle_number }}</td>
<td>{{ $rating->phone }}</td>

<td>{{ $rating->serviceQuality->name ?? '-' }}</td>

<td>
{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] ?? 'N/A' }}
</td>

<td>
{{ $rating->created_at->format('d M Y') }}
</td>
<td>
    @switch($rating->status)

        @case(null)
        @case('pending')
            <span class="badge bg-warning text-dark">Pending</span>
        @break

        @case('ao')
            <span class="badge bg-secondary">Fowarded A/O</span>
        @break

        @case('ao')
            <span class="badge bg-info"></span>
        @break

        @case('commissioner')
            <span class="badge bg-primary">At Commissioner</span>
        @break

        @case('completed')
            <span class="badge bg-success">Completed</span>
        @break

        @default
            <span class="badge bg-dark">Unknown</span>

    @endswitch
            &nbsp;&nbsp;<span class="float-end">▼</span>

</td>
</tr>

<tr class="collapse bg-light" id="readComplaint{{ $rating->id }}">
<td colspan="9">

<div class="p-3">

<div class="mb-3">
<strong>Complaint:</strong><br>
{{ $rating->note }}
</div>

<div class="mb-3">
<strong>Complaint Type:</strong><br>
{{ $rating->complainType->name ?? 'Not specified' }}
</div>

<div class="mb-3">
<strong>Remarks:</strong><br>
{{ $rating->user_remarks ?? 'No remarks added' }}
</div>


</div>

</td>
</tr>

@empty
<tr><td colspan="9" class="text-center">No resolved complaints</td></tr>
@endforelse
</tbody>

</table>

{{ $readRatings->links() }}

</div>

</div>
</div>
@endsection

<style>
tr[aria-expanded="true"] span { transform: rotate(180deg); }
span { transition: 0.2s; }
</style>
