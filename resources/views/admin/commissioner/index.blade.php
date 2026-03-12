@extends('layouts.app')

@section('title')
Commissioner Complaints - PDMT
@endsection
<style>
    .commissioner-table th {
        font-weight: 600;
        font-size: 14px;
    }

    .commissioner-table td {
        font-size: 14px;
    }

    .commissioner-table tbody tr {
        cursor: pointer;
    }

    .commissioner-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .modal-content {
        border-radius: 8px;
    }

    @media (max-width:768px) {

        .commissioner-table th,
        .commissioner-table td {
            font-size: 12px;
            padding: 6px;
        }

        h3 {
            font-size: 20px;
        }

        .modal-body {
            font-size: 14px;
        }

    }
</style>
@section('content')

<div class="container mt-4">

    <h3>Commissioner Complaints</h3>

    <div class="card shadow border-0">

        <div class="card-body">


            {{-- FILTER BUTTON --}}

            <div class="d-flex justify-content-end mb-3">

                <button class="btn btn-outline-primary"
                    data-bs-toggle="collapse"
                    data-bs-target="#filterBox">

                    <i class="bi bi-funnel"></i> Filters

                </button>

            </div>


            {{-- FILTER BOX --}}

            <div class="collapse {{ request()->hasAny(['counter','status','from','to']) ? 'show' : '' }}" id="filterBox">

                <div class="card card-body mb-3 bg-light">

                    <form method="GET">

                        <input type="hidden"
                            name="active_tab"
                            id="active_tab"
                            value="{{ request('active_tab','pending') }}">

                        <div class="row g-3">

                            <div class="col-md-3">

                                <label>Division - Counter</label>

                                <select name="counter" class="form-control">

                                    <option value="">All Counters</option>

                                    @foreach($counters as $counterOption)

                                    <option value="{{ $counterOption->id }}"
                                        {{ ($filters['counter'] ?? '') == $counterOption->id ? 'selected' : '' }}>

                                        {{ $counterOption->division_name }} - {{ $counterOption->counter_name }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-2">

                                <label>Status</label>

                                <select name="status" class="form-control">

                                    <option value="">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="ao">Forwarded AO</option>
                                    <option value="commissioner">Commissioner</option>
                                    <option value="completed">Completed</option>

                                </select>

                            </div>


                            <div class="col-md-2">

                                <label>From</label>

                                <input type="date"
                                    name="from"
                                    value="{{ $filters['from'] ?? '' }}"
                                    class="form-control">

                            </div>


                            <div class="col-md-2">

                                <label>To</label>

                                <input type="date"
                                    name="to"
                                    value="{{ $filters['to'] ?? '' }}"
                                    class="form-control">

                            </div>


                            <div class="col-md-2">
                                <label>Complaint Type</label>
                                <select name="complain_type" class="form-control">
                                    <option value="">All</option>

                                    @foreach($complainTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('complain_type') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Vehicle / Phone</label>
                                <input type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Vehicle or Phone">
                            </div>
                            <div class="col-md-2 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i>
                                </button>

                                <a href="{{ url()->current() }}"
                                    class="btn btn-danger w-100">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>

                        </div>

                    </form>

                </div>

            </div>


            {{-- TABS --}}

            <ul class="nav nav-tabs mb-3">

                <li class="nav-item">

                    <button class="nav-link {{ request('active_tab','pending')=='pending'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#pending">

                        Pending at Commissioner

                    </button>

                </li>

                <li class="nav-item">

                    <button class="nav-link {{ request('active_tab')=='closed'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#closed">

                        Completed Complaints

                    </button>

                </li>

            </ul>


            <div class="tab-content">


                {{-- ================= PENDING ================= --}}

                <div class="tab-pane fade {{ request('active_tab','pending')=='pending'?'show active':'' }}" id="pending">

                    <table class="table table-striped table-hover align-middle commissioner-table">

                        <thead class="table-dark">

                            <tr>

                                <th>#</th>
                                <th>Division</th>
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

                            @forelse($pendingCommissioner as $c)

                            <tr style="cursor:pointer"
                                data-bs-toggle="modal"
                                data-bs-target="#pendingModal{{ $c->id }}">

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $c->counter->division_name ?? '-' }}</td>

                                <td>{{ $c->counter->counter_name ?? '-' }}</td>

                                <td>{{ $c->vehicle_number }}</td>

                                <td>{{ $c->phone }}</td>

                                <td>{{ $c->serviceQuality->name ?? '-' }}</td>

                                <td>


                                    {{ ['','Bad','Poor','Average','Good','Excellent'][$c->rating] ?? '' }}



                                </td>

                                <td>{{ $c->created_at->format('d M Y') }}</td>


                                <td>

                                    <span class="badge bg-primary">

                                        Waiting Commissioner Decision

                                    </span>

                                </td>

                            </tr>


                            {{-- PENDING MODAL --}}

                            <div class="modal fade" id="pendingModal{{ $c->id }}">

                                <div class="modal-dialog modal-lg modal-dialog-centered">

                                    <div class="modal-content rounded-0">
                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Complaint Details
                                            </h5>

                                            <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"></button>

                                        </div>
                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-md-6 mb-2">

                                                    <strong>Vehicle:-</strong>

                                                    {{ $c->vehicle_number }}

                                                </div>

                                                <div class="col-md-6 mb-2">

                                                    <strong>Phone:-</strong>
                                                    {{ $c->phone }}

                                                </div>
                                                <div class="col-md-6 mb-2">

                                                    <strong>Complaint:</strong> {{ $c->note }}


                                                </div>
                                                <div class="col-md-6 mb-2">

                                                    <strong>Complaint Type</strong>

                                                    <span class="badge bg-warning text-dark">
                                                        {{ $c->complainType->name ?? 'N/A' }}
                                                    </span>
                                                </div>



                                                <div class="col-md-6 mb-2">

                                                    <strong>User Remarks:-</strong>
                                                    {{ $c->user_remarks ?? '-' }}

                                                </div>

                                                <div class="col-md-6 mb-2">

                                                    <strong>AO Remarks:-</strong>
                                                    {{ $c->ao_remarks ?? '-' }}

                                                </div>

                                            </div>

                                            <hr>

                                            <form method="POST"
                                                action="{{ route('admin.commissioner.close',$c->id) }}">

                                                @csrf

                                                <label><strong>Final Decision / Action</strong></label>

                                                <textarea name="final_remarks"
                                                    class="form-control mb-3"
                                                    rows="3"></textarea>

                                                <button class="btn btn-success">

                                                    Completed

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            @empty

                            <tr>

                                <td colspan="9"
                                    class="text-center">

                                    No complaints pending

                                </td>

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


                {{-- ================= COMPLETED ================= --}}

                <div class="tab-pane fade {{ request('active_tab')=='closed'?'show active':'' }}" id="closed">

                    <table class="table table-striped table-hover align-middle commissioner-table">

                        <thead class="table-secondary">

                            <tr>

                                <th>#</th>
                                <th>Division</th>
                                <th>Counter</th>
                                <th>Vehicle</th>
                                <th>Phone</th>
                                <th>Rating</th>
                                <th>Date Closed</th>
                                <th>Status</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($closedCommissioner as $c)

                            <tr style="cursor:pointer"
                                data-bs-toggle="modal"
                                data-bs-target="#completedModal{{ $c->id }}">

                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $c->counter->division_name ?? '-' }}</td>

                                <td>{{ $c->counter->counter_name ?? '-' }}</td>

                                <td>{{ $c->vehicle_number }}</td>

                                <td>{{ $c->phone }}</td>

                                <td>


                                    {{ ['','Bad','Poor','Average','Good','Excellent'][$c->rating] }}



                                </td>

                                <td>{{ $c->updated_at->format('d M Y') }}</td>


                                <td>

                                    <span class="badge bg-success">

                                        Completed

                                    </span>

                                </td>

                            </tr>


                            {{-- COMPLETED MODAL --}}

                            <div class="modal fade" id="completedModal{{ $c->id }}">

                                <div class="modal-dialog modal-lg modal-dialog-centered">

                                    <div class="modal-content rounded-0">
                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Completed Complaint Details</h5>

                                            <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"></button>

                                        </div>


                                        <div class="modal-body">

                                            <div class="row">

                                                <div class="col-md-6 mb-2">

                                                    <strong>Vehicle:-</strong>

                                                    {{ $c->vehicle_number }}

                                                </div>

                                                <div class="col-md-6 mb-2">

                                                    <strong>Phone:-</strong>
                                                    {{ $c->phone }}

                                                </div>
                                                <div class="col-md-6 mb-2">

                                                    <strong>Complaint:</strong> {{ $c->note }}


                                                </div>
                                                <div class="col-md-6 mb-2">

                                                    <strong>Complaint Type</strong>

                                                    <span class="badge bg-warning text-dark">
                                                        {{ $c->complainType->name ?? 'N/A' }}
                                                    </span>
                                                </div>



                                                <div class="col-md-6 mb-2">

                                                    <strong>User Remarks:-</strong>
                                                    {{ $c->user_remarks ?? '-' }}

                                                </div>

                                                <div class="col-md-6 mb-2">

                                                    <strong>AO Remarks:-</strong>
                                                    {{ $c->ao_remarks ?? '-' }}

                                                </div>
                                                <div class="col-md-6 mb-2">

                                                    <strong>Final Commissioner Decision:-</strong>
                                                    {{ $c->commissioner_remarks ?? '-' }}
                                                </div>
                                            </div>




                                        </div>

                                    </div>

                                </div>

                            </div>


                            @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center">

                                    No completed complaints

                                </td>

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

    </div>

</div>

@endsection


@section('script')

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    document.querySelectorAll('.nav-link[data-bs-toggle="tab"]').forEach(link => {

        link.addEventListener('shown.bs.tab', function(e) {

            document.getElementById('active_tab').value =
                e.target.dataset.bsTarget.substring(1);

        });

    });
</script>

@endsection