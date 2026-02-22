@extends('layouts.app')

@section('title')
Administrative Officer Complaints- PDMT
@endsection

@section('content')
<div class="container">

<h2 class="mb-4">Administrative Officer Complaints</h2>
<div class="d-flex justify-content-end mb-2">
    <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterBox">
        <i class="bi bi-funnel"></i> Filters <span id="arrow">▼</span>
    </button>
</div>

<div class="collapse {{ request()->hasAny(['division','counter','from','to','service_quality','rating']) ? 'show' : '' }}" id="filterBox">
    <div class="card card-body mb-3">
        <form method="GET" class="row">
            <input type="hidden" name="active_tab" id="active_tab" value="{{ request('active_tab','pending') }}">

            <div class="col-md-2">
               <label>Division-Counter</label>
               <select name="counter" class="form-control">
                   <option value="">-- All Counters --</option>
                   @foreach($counters as $counterOption)
                       <option value="{{ $counterOption->id }}"
                           {{ ($filters['counter'] ?? '') == $counterOption->id ? 'selected' : '' }}>
                           {{ $counterOption->division_name }} – {{ $counterOption->counter_name }}
                       </option>
                   @endforeach
               </select>
           </div>
  <div class="col-md-2">
               <label>Status</label>
               <select name="status" class="form-control">
                   <option value="">All</option>
                   <option value="pending" {{ ($filters['status'] ?? '')=='pending'?'selected':'' }}>Pending</option>
                   <option value="ao" {{ ($filters['status'] ?? '')=='ao'?'selected':'' }}>Forwarded A/O</option>
                   <option value="commissioner" {{ ($filters['status'] ?? '')=='commissioner'?'selected':'' }}>Sent to Commissioner</option>
                   <option value="completed" {{ ($filters['status'] ?? '')=='completed'?'selected':'' }}>Completed</option>
                   <option value="rejected" {{ ($filters['status'] ?? '')=='rejected'?'selected':'' }}>Rejected</option>
               </select>
           </div>
       
 
     <div class="col-md-2">
                <label>From Date</label>
                <input type="date" name="from" value="{{ $filters['from'] ?? '' }}" class="form-control">
            </div>

            <div class="col-md-2">
                <label>To Date</label>
                <input type="date" name="to" value="{{ $filters['to'] ?? '' }}" class="form-control">
            </div>

            <div class="col-md-4 mt-4">
                <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                <a href="{{ url()->current() }}" class="btn btn-danger"><i class="bi bi-arrow-clockwise me-1"></i></a>
            </div>
        </form>
    </div>
</div>
{{-- TABS --}}
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <button class="nav-link {{ request('active_tab','pending') == 'pending' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#pending">
            Pending at A/O
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link {{ request('active_tab') == 'closed' ? 'active' : '' }}"
                data-bs-toggle="tab" data-bs-target="#closed">
            Completed / Forwarded
        </button>
    </li>
</ul>

<div class="tab-content">

{{-- ================= PENDING AO ================= --}}
<div class="tab-pane fade {{ request('active_tab','pending') == 'pending' ? 'show active' : '' }}" id="pending">

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

<tbody id="pendingaoAccordion">
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
<tr class="collapse bg-light"
    id="complaint{{ $rating->id }}"
    data-bs-parent="#pendingaoAccordion">
    <td colspan="9">
        <div class="card shadow-sm border-secondary mb-2">
            <div class="card-body p-2">
              <div class="row">
                    <div class="col-md-6 mb-2">
                    <strong>Complaint:</strong>
                    <p class="mb-0">{{ $rating->note }}</p>
                </div>

                    <div class="col-md-6 mb-2">
                    <strong>Complaint Type:</strong>
                    <p class="mb-0">{{ $rating->complainType->name ?? 'Not specified' }}</p>
                </div>

                    <div class="col-md-6 mb-2">
                    <strong>User Remarks:</strong>
                    <p class="mb-0">{{ $rating->user_remarks ?? 'No remarks added' }}</p>
                </div>
 <div class="col-md-12 mb-2">
            
                <form method="POST" action="{{ route('admin.ao.save', $rating->id) }}">
                    @csrf
                        <label><strong>AO Final Remarks</strong></label>
                        <textarea name="ao_remarks" class="form-control" rows="3" required></textarea>
                    

               
                        <button class="btn btn-danger btn-sm" type="submit" name="action" value="reject">
                            Reject
                        </button>
                        <button class="btn btn-success btn-sm" type="submit" name="action" value="forward">
                            Forward to Commissioner
                        </button>
                 
                </form>
            </div> 
            </div> 
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
</div>

{{-- ================= CLOSED / FORWARDED ================= --}}
<div class="tab-pane fade {{ request('active_tab') == 'closed' ? 'show active' : '' }}" id="closed">

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

<tbody id="closedaoAccordion">
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
    @elseif($c->status == 'rejected')
        <span class="badge bg-danger">Rejected</span>
    @endif
    <span class="float-end">▼</span>
</td>



</tr>
<tr class="collapse bg-light"
id="closed{{ $c->id }}"
    data-bs-parent="#closedaoAccordion">
    <td colspan="8">
        <div class="card shadow-sm border-secondary mb-2">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Complaint:</strong>
                        <p class="mb-0">{{ $c->note }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Complaint Type:</strong>
                        <p class="mb-0">{{ $c->complainType->name ?? 'Not specified' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Supervisor Remarks:</strong>
                        <p class="mb-0">{{ $c->user_remarks ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Administrative Officer Remarks:</strong>
                        <p class="mb-0">{{ $c->ao_remarks ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Final Commissioner Decision:</strong>
                        <p class="mb-0">{{ $c->commissioner_remarks ?? '-' }}</p>
                    </div>
                </div>
            </div> 
        </div>
    </td>
</tr>

@empty
<tr>
<td colspan="8" class="text-center">No completed complaints</td>
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
</div>

</div>
</div>
@endsection
@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
tr[aria-expanded="true"] span {
    transform: rotate(180deg);
}
span { transition: 0.2s; }

/style>
<script>
    document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(link => {
        link.addEventListener('shown.bs.tab', function (e) {
            document.getElementById('active_tab').value = e.target.dataset.bsTarget.substring(1);
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const filterBox = document.getElementById('filterBox');
        const arrow = document.getElementById('arrow');

        filterBox.addEventListener('show.bs.collapse', () => arrow.innerHTML = '▲');
        filterBox.addEventListener('hide.bs.collapse', () => arrow.innerHTML = '▼');
    });
</script>
@endsection