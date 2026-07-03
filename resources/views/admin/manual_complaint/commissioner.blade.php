@extends('layouts.app')

@section('title')
Manual Complaints - Commissioner
@endsection

<style>
    .manual-panel .nav-tabs .nav-link {
        color: #334155;
        font-weight: 600;
    }

    .manual-panel .nav-tabs .nav-link.active {
        color: #0f172a;
        background: #eef4ff;
        border-color: #dbe7ff #dbe7ff #ffffff;
    }

    .manual-table th {
        white-space: nowrap;
        font-size: 13px;
    }

    .manual-table td {
        vertical-align: middle;
    }

    .manual-action-form {
        display: grid;
        grid-template-columns: minmax(180px, 1fr) auto auto;
        gap: 6px;
        align-items: center;
    }

    .manual-action-form .btn {
        white-space: nowrap;
    }

    .complaint-row td {
        background: #f8fafc;
    }

    @media (max-width: 992px) {
        .manual-action-form {
            grid-template-columns: 1fr;
        }

        .manual-action-form .btn {
            width: 100%;
        }
    }
</style>

@section('content')
<div class="container">
    <h2 class="mb-0">Manual Complaints - Commissioner</h2>

    @if(session('success'))
    <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <div class="card shadow border-0 mt-3 manual-panel">
        <div class="card-body">
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <button class="nav-link {{ request('active_tab', 'pending') === 'pending' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#pendingCommissioner">Pending at Commissioner</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link {{ request('active_tab') === 'closed' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#closedCommissioner">Completed / Rejected</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade {{ request('active_tab', 'pending') === 'pending' ? 'show active' : '' }}" id="pendingCommissioner">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle manual-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Source</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>AO Remarks</th>
                                    <th width="320">Final Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingCommissioner as $index => $item)
                                <tr>
                                    <td>{{ $pendingCommissioner->firstItem() + $index }}</td>
                                    <td>{{ $item->sourceSetting->name ?? $item->source ?? '-' }}</td>
                                    <td>{{ $item->complainant_name ?? '-' }}</td>
                                    <td>{{ $item->phone ?? '-' }}</td>
                                    <td>{{ $item->complaint_email ?? '-' }}</td>
                                    <td>{{ $item->complainType->name ?? '-' }}</td>
                                    <td>{{ $item->ao_remarks ?? '-' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.manual-complaints.commissioner.close', $item->id) }}" class="manual-action-form">
                                            @csrf
                                            <input type="text" name="final_remarks" class="form-control form-control-sm" placeholder="Enter final remarks" required>
                                            <button class="btn btn-sm btn-success" name="action" value="complete">Complete</button>
                                            <button class="btn btn-sm btn-danger" name="action" value="reject">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr class="complaint-row">
                                    <td></td>
                                    <td colspan="7" class="bg-light"><strong>Complaint:</strong> {{ $item->complaint }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No pending complaints</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $pendingCommissioner->appends(['active_tab' => 'pending'])->links() }}
                    </div>
                </div>

                <div class="tab-pane fade {{ request('active_tab') === 'closed' ? 'show active' : '' }}" id="closedCommissioner">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle manual-table">
                            <thead class="table-secondary">
                                <tr>
                                    <th>#</th>
                                    <th>Source</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>AO Remarks</th>
                                    <th>Commissioner Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($closedCommissioner as $index => $item)
                                <tr>
                                    <td>{{ $closedCommissioner->firstItem() + $index }}</td>
                                    <td>{{ $item->sourceSetting->name ?? $item->source ?? '-' }}</td>
                                    <td>{{ $item->complainant_name ?? '-' }}</td>
                                    <td>
                                        @if($item->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                        @else
                                        <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->ao_remarks ?? '-' }}</td>
                                    <td>{{ $item->commissioner_remarks ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $closedCommissioner->appends(['active_tab' => 'closed'])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
