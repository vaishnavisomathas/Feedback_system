@extends('layouts.app')

@section('title')
Manual Complaints - A/O
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

    .manual-table .manual-main-row {
        cursor: pointer;
    }

    .manual-table .complaint-row {
        display: none;
    }

    .manual-table .complaint-row.open {
        display: table-row;
    }

    .manual-table .complaint-content {
        border-left: 4px solid #0d6efd;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .detail-item {
        font-size: 14px;
    }

    .detail-item strong {
        color: #0f172a;
    }

    .detail-item.full {
        grid-column: 1 / -1;
    }

    @media (max-width: 992px) {
        .manual-action-form {
            grid-template-columns: 1fr;
        }

        .manual-action-form .btn {
            width: 100%;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-item.full {
            grid-column: auto;
        }
    }
</style>

@section('content')
<div class="container">
    <h2 class="mb-0">Manual Complaints - A/O</h2>

    @if(session('success'))
    <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
    <div class="alert alert-warning mt-2">{{ session('warning') }}</div>
    @endif

    <div class="card shadow border-0 mt-3 manual-panel">
        <div class="card-body">
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <button class="nav-link {{ request('active_tab', 'pending') === 'pending' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#pendingAO">Pending at A/O</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link {{ request('active_tab') === 'closed' ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#closedAO">Forwarded / Closed</button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade {{ request('active_tab', 'pending') === 'pending' ? 'show active' : '' }}" id="pendingAO">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle manual-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Source</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Vehicle</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th width="260">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingAO as $index => $item)
                                <tr class="manual-main-row" data-complaint-row="pending-complaint-row-{{ $item->id }}" role="button" aria-expanded="false">
                                    <td>{{ $pendingAO->firstItem() + $index }}</td>
                                    <td>{{ $item->sourceSetting->name ?? $item->source ?? '-' }}</td>
                                    <td>{{ $item->complainant_name ?? '-' }}</td>
                                    <td>{{ $item->phone ?? '-' }}</td>
                                    <td>{{ $item->complaint_email ?? '-' }}</td>
                                    <td>{{ $item->vehicle_number ?? '-' }}</td>
                                    <td>{{ $item->complainType->name ?? '-' }}</td>
                                    <td>{{ optional($item->received_at)->format('d M Y') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.manual-complaints.ao.save', $item->id) }}" class="manual-action-form">
                                            @csrf
                                            <input type="text" name="ao_remarks" class="form-control form-control-sm" placeholder="Enter AO remarks" required>
                                            <button class="btn btn-sm btn-danger manual-action-btn" name="action" value="reject">Reject</button>
                                            <button class="btn btn-sm btn-success manual-action-btn" name="action" value="forward">Forward</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr id="pending-complaint-row-{{ $item->id }}" class="complaint-row">
                                    <td></td>
                                    <td colspan="8" class="bg-light complaint-content"><strong>Complaint:</strong> {{ $item->complaint ?: 'No complaint text available' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No manual complaints at A/O</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $pendingAO->appends(['active_tab' => 'pending'])->links() }}
                    </div>
                </div>

                <div class="tab-pane fade {{ request('active_tab') === 'closed' ? 'show active' : '' }}" id="closedAO">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle manual-table">
                            <thead class="table-secondary">
                                <tr>
                                    <th>#</th>
                                    <th>Source</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Vehicle</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($closedAO as $index => $item)
                                <tr class="manual-main-row" data-complaint-row="closed-complaint-row-{{ $item->id }}" role="button" aria-expanded="false">
                                    <td>{{ $closedAO->firstItem() + $index }}</td>
                                    <td>{{ $item->sourceSetting->name ?? $item->source ?? '-' }}</td>
                                    <td>{{ $item->complainant_name ?? '-' }}</td>
                                    <td>{{ $item->phone ?? '-' }}</td>
                                    <td>{{ $item->complaint_email ?? '-' }}</td>
                                    <td>{{ $item->vehicle_number ?? '-' }}</td>
                                    <td>{{ $item->complainType->name ?? '-' }}</td>
                                    <td>
                                        @if($item->status === 'commissioner')
                                        <span class="badge bg-primary">At Commissioner</span>
                                        @elseif($item->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                        @else
                                        <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($item->received_at)->format('d M Y') }}</td>
                                </tr>
                                <tr id="closed-complaint-row-{{ $item->id }}" class="complaint-row">
                                    <td></td>
                                    <td colspan="8" class="bg-light complaint-content">
                                        <div class="detail-grid">
                                            <div class="detail-item full"><strong>Complaint:</strong> {{ $item->complaint ?: 'No complaint text available' }}</div>
                                            <div class="detail-item full"><strong>AO Remarks:</strong> {{ $item->ao_remarks ?: '-' }}</div>
                                            <div class="detail-item full"><strong>Commissioner Remarks:</strong> {{ $item->commissioner_remarks ?: '-' }}</div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $closedAO->appends(['active_tab' => 'closed'])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.manual-main-row').forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.closest('.manual-action-form') || e.target.closest('.manual-action-btn') || e.target.closest('input') || e.target.closest('button') || e.target.closest('select') || e.target.closest('textarea') || e.target.closest('a')) {
                return;
            }

            const detailRowId = this.dataset.complaintRow;
            const detailRow = document.getElementById(detailRowId);

            if (!detailRow) {
                return;
            }

            const isOpening = !detailRow.classList.contains('open');

            document.querySelectorAll('.complaint-row.open').forEach(function (openedRow) {
                openedRow.classList.remove('open');
            });

            document.querySelectorAll('.manual-main-row[aria-expanded="true"]').forEach(function (openedMainRow) {
                openedMainRow.setAttribute('aria-expanded', 'false');
            });

            if (isOpening) {
                detailRow.classList.add('open');
                this.setAttribute('aria-expanded', 'true');
            } else {
                this.setAttribute('aria-expanded', 'false');
            }
        });
    });
});
</script>
@endsection
