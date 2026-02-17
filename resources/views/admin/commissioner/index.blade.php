@extends('layouts.app')

@section('title')
<title>Commissioner Complaints</title>
@endsection

@section('content')
<div class="container">

<h2 class="mb-4">Commissioner Complaints</h2>

{{-- TABS --}}
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pending">
            Pending at Commissioner
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#closed">
            Completed Complaints
        </button>
    </li>
</ul>

<div class="tab-content">

{{-- ================= PENDING ================= --}}
<div class="tab-pane fade show active" id="pending">

<table class="table table-bordered table-hover">
<thead class="table-primary">
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
@forelse($pendingCommissioner as $c)

<tr data-bs-toggle="collapse"
    data-bs-target="#commissioner{{ $c->id }}"
    style="cursor:pointer">

<td>{{ $loop->iteration }}</td>
<td>{{ $c->counter->division_name ?? '-' }}</td>
<td>{{ $c->counter->counter_name ?? '-' }}</td>
<td>{{ $c->vehicle_number }}</td>
<td>{{ $c->phone }}</td>
<td>{{ $c->serviceQuality->name ?? '-' }}</td>
<td>{{ $c->created_at->format('d M Y') }}</td>

<td>
<span class="badge bg-primary">Waiting Commissioner Decision</span>
<span class="float-end">▼</span>
</td>

</tr>

<tr class="collapse bg-light" id="commissioner{{ $c->id }}">
<td colspan="7">
<div class="p-3">

<strong>Complaint:</strong><br>
{{ $c->note }}

<hr>

<strong>Complaint Type:</strong><br>
{{ $c->complainType->name ?? '-' }}

<hr>

<strong>Supervisor Remarks:</strong><br>
{{ $c->user_remarks ?? '-' }}

<hr>

<strong>AO Remarks:</strong><br>
{{ $c->ao_remarks ?? '-' }}

<hr>

<form method="POST" action="{{ route('admin.commissioner.close',$c->id) }}">
@csrf

<label><strong>Final Decision / Action</strong></label>
<textarea name="final_remarks" class="form-control mb-3" rows="4"></textarea>

<button class="btn btn-success">
Completed
</button>

</form>

</div>
</td>
</tr>

@empty
<tr>
<td colspan="7" class="text-center">No complaints pending for Commissioner</td>
</tr>
@endforelse
</tbody>
</table>

{{ $pendingCommissioner->links() }}

</div>


{{-- ================= COMPLETED ================= --}}
<div class="tab-pane fade" id="closed">

<table class="table table-bordered table-hover">
<thead class="table-success">
<tr>
<th>#</th>
<th>DS Division</th>
<th>Counter</th>
<th>Vehicle</th>
<th>Date Closed</th>
<th>Status</th>
</tr>
</thead>

<tbody>
@forelse($closedCommissioner as $c)

<tr data-bs-toggle="collapse"
    data-bs-target="#completed{{ $c->id }}"
    style="cursor:pointer">

<td>{{ $loop->iteration }}</td>
<td>{{ $c->counter->division_name ?? '-' }}</td>
<td>{{ $c->counter->counter_name ?? '-' }}</td>
<td>{{ $c->vehicle_number }}</td>
<td>{{ $c->updated_at->format('d M Y') }}</td>

<td>
<span class="badge bg-success">Completed</span>
<span class="float-end">▼</span>
</td>

</tr>

<tr class="collapse bg-light" id="completed{{ $c->id }}">
<td colspan="6">
<div class="p-3">

<strong>Complaint:</strong><br>
{{ $c->note }}

<hr>

<strong>Final Commissioner Decision:</strong><br>
{{ $c->commissioner_remarks }}

</div>
</td>
</tr>

@empty
<tr>
<td colspan="6" class="text-center">No completed complaints</td>
</tr>
@endforelse
</tbody>
</table>

{{ $closedCommissioner->links() }}

</div>

</div>
</div>
@endsection
