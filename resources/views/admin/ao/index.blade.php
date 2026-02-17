@extends('layouts.app')

@section('title')
<title>Administrative Officer Complaints</title>
@endsection

@section('content')
<div class="container">

<h2 class="mb-4">Administrative Officer Complaints</h2>

{{-- TABS --}}
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pending">
            Pending AO
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#closed">
            Completed / Forwarded
        </button>
    </li>
</ul>

<div class="tab-content">

{{-- ================= PENDING AO ================= --}}
<div class="tab-pane fade show active" id="pending">

<table class="table table-bordered table-hover">
<thead class="table-danger">
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
@forelse($pendingAO as $rating)

<tr data-bs-toggle="collapse"
    data-bs-target="#complaint{{ $rating->id }}"
    style="cursor:pointer">

<td>{{ $loop->iteration }}</td>
<td>{{ $rating->counter->division_name ?? '-' }}</td>
<td>{{ $rating->counter->counter_name ?? '-' }}</td>
<td>{{ $rating->vehicle_number }}</td>
<td>{{ $rating->phone }}</td>
<td>{{ $rating->serviceQuality->name ?? '-' }}</td>
<td>{{ ['','Bad','Poor','Average','Good','Excellent'][$rating->rating] }}</td>
<td>{{ $rating->created_at->format('d M Y') }}</td>

<td>
<span class="badge bg-info">At Administrative Officer</span>
<span class="float-end">▼</span>
</td>

</tr>

<tr class="collapse bg-light" id="complaint{{ $rating->id }}">
<td colspan="9">
<div class="p-3">

<strong>Complaint:</strong><br>
{{ $rating->note }}

<hr>

<strong>Complaint Type:</strong><br>
{{ $rating->complainType->name ?? 'Not specified' }}

<hr>

<strong>Supervisor Remarks:</strong><br>
{{ $rating->user_remarks ?? 'No remarks added' }}

<hr>

<form method="POST" action="{{ route('admin.ao.save',$rating->id) }}">
@csrf

<label><strong>AO Final Remarks</strong></label>
<textarea name="ao_remarks" class="form-control mb-3" rows="3" required></textarea>

<button class="btn btn-success btn-sm">
Forward to Commissioner
</button>

</form>

</div>
</td>
</tr>

@empty
<tr>
<td colspan="9" class="text-center">No complaints at Administrative Officer</td>
</tr>
@endforelse
</tbody>
</table>

{{ $pendingAO->links() }}

</div>

{{-- ================= CLOSED / FORWARDED ================= --}}
<div class="tab-pane fade" id="closed">

<table class="table table-bordered table-hover">
<thead class="table-success">
<tr>
<th>#</th>
<th>DS Division</th>
<th>Counter</th>
<th>Vehicle</th>
<th>Phone</th>
<th>Service Quality</th>
<th>Date</th>
<th>Status</th>
</tr>
</thead>

<tbody>
@forelse($closedAO as $c)

<tr data-bs-toggle="collapse"
    data-bs-target="#closed{{ $c->id }}"
    style="cursor:pointer">

<td>{{ $loop->iteration }}</td>
<td>{{ $c->counter->division_name ?? '-' }}</td>
<td>{{ $c->counter->counter_name ?? '-' }}</td>
<td>{{ $c->vehicle_number }}</td>
<td>{{ $c->phone }}</td>
<td>{{ $c->serviceQuality->name ?? '-' }}</td>

<td>{{ $c->updated_at->format('d M Y') }}</td>

<td>
@if($c->status == 'commissioner')
<span class="badge bg-primary">Sent to Commissioner</span>
@elseif($c->status == 'completed')
<span class="badge bg-success">Completed</span>
@endif
<span class="float-end">▼</span>
</td>


</tr>

<tr class="collapse bg-light" id="closed{{ $c->id }}">
<td colspan="7">
<div class="p-3">

<strong>Complaint:</strong><br>
{{ $c->note }}

<hr>

<strong>Complaint Type:</strong><br>
{{ $c->complainType->name ?? 'Not specified' }}

<hr>

<strong>Supervisor Remarks:</strong><br>
{{ $c->user_remarks ?? '-' }}

<hr>

<strong>Administrative Officer Remarks:</strong><br>
{{ $c->ao_remarks ?? '-' }}

</div>
</td>
</tr>

@empty
<tr>
<td colspan="7" class="text-center">No completed complaints</td>
</tr>
@endforelse
</tbody>
</table>

{{ $closedAO->links() }}

</div>

</div>
</div>
@endsection

<style>
tr[aria-expanded="true"] span {
    transform: rotate(180deg);
}
span { transition: 0.2s; }
</style>
