@extends('layouts.app')

@section('title')
Informed Complaints - PDMT
@endsection

<style>
    .commissioner-table {
        border: 1px solid #dbe3ee;
        border-collapse: separate;
        border-spacing: 0;
    }

    .commissioner-table .commissioner-table-head th {
        background-color: #f3f6fa;
        color: #243b53;
        border-bottom: 1px solid #d2dceb;
        white-space: nowrap;
        padding: 12px 14px;
    }

    .commissioner-table th {
        font-weight: 600;
        font-size: 14px;
    }

    .commissioner-table td {
        font-size: 14px;
        border-top: 1px solid #edf1f5;
        color: #5f6c7b;
        padding: 12px 14px;
    }

    .commissioner-table tbody tr {
        cursor: pointer;
    }

    .commissioner-table tbody tr:hover td {
        background-color: #f8fafc;
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

    <h3>Informed Complaints</h3>

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
            <div class="collapse {{ request()->hasAny(['counter','from','to','complain_type','search']) ? 'show' : '' }}" id="filterBox">
                <div class="card card-body mb-3 bg-light">

                    <form method="GET">
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

                                <a href="{{ url()->current() }}" class="btn btn-danger w-100">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

            <table class="table table-hover align-middle commissioner-table">
                <thead class="commissioner-table-head">
                    <tr>
                        <th>#</th>
                        <th>Division</th>
                        <th>Counter</th>
                        <th>Vehicle</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Service Quality</th>
                        <th>Rating</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($informedComplaints as $c)
                        <tr style="cursor:pointer"
                            data-bs-toggle="modal"
                            data-bs-target="#informedModal{{ $c->id }}">

                            <td>{{ $informedComplaints->firstItem() + $loop->index }}</td>
                            <td>{{ $c->counter->division_name ?? '-' }}</td>
                            <td>{{ $c->counter->counter_name ?? '-' }}</td>
                            <td>{{ $c->vehicle_number ?? '-' }}</td>
                            <td>{{ $c->phone ?? '-' }}</td>
                            <td>{{ $c->complaint_email ?? '-' }}</td>
                            <td>{{ $c->serviceQuality->name ?? '-' }}</td>
                            <td>{{ ['','Bad','Poor','Average','Good','Excellent'][$c->rating] ?? '' }}</td>
                            <td>{{ $c->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-danger">Informed by Commissioner</span>
                            </td>
                        </tr>

                        {{-- MODAL --}}
                        <div class="modal fade" id="informedModal{{ $c->id }}">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-0">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Complaint Details</h5>
                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="alert alert-danger py-2 mb-3">
                                            <strong>Informed by Commissioner</strong>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6 mb-2">
                                                <strong>Vehicle:-</strong>
                                                {{ $c->vehicle_number ?? '-' }}
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <strong>Phone:-</strong>
                                                {{ $c->phone ?? '-' }}
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <strong>Email:-</strong>
                                                {{ $c->complaint_email ?? '-' }}
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <strong>Complaint Type:-</strong>
                                                <span class="badge bg-warning text-dark">
                                                    {{ $c->complainType->name ?? 'N/A' }}
                                                </span>
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <strong>Division:-</strong>
                                                {{ $c->counter->division_name ?? '-' }}
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <strong>Counter:-</strong>
                                                {{ $c->counter->counter_name ?? '-' }}
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <strong>Service Quality:-</strong>
                                                {{ $c->serviceQuality->name ?? '-' }}
                                            </div>

                                            <div class="col-md-6 mb-2">
                                                <strong>Rating:-</strong>
                                                {{ ['','Bad','Poor','Average','Good','Excellent'][$c->rating] ?? '-' }}
                                            </div>

                                            <div class="col-md-12 mb-2">
                                                <strong>Complaint:-</strong>
                                                <div class="p-2 bg-light rounded border mt-1">
                                                    {{ $c->note ?? '-' }}
                                                </div>
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
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No informed complaints found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
                <form method="GET" class="d-flex align-items-center mb-2">
                    @foreach(request()->except('per_page','page') as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach

                    <select name="per_page" class="form-control" onchange="this.form.submit()">
                        @foreach([10,20,50,100] as $size)
                            <option value="{{ $size }}" {{ request('per_page',10) == $size ? 'selected' : '' }}>
                                Show {{ $size }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <div class="mb-2">
                    {{ $informedComplaints->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('script')
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection