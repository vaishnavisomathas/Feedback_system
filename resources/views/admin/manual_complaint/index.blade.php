@extends('layouts.app')

@section('title')
Manual Complaints - PDMT
@endsection

@section('content')
<div class="container">
    <input type="hidden" id="manualComplaintHasErrors" value="{{ $errors->any() ? '1' : '0' }}">
    <h2 class="mb-0">Manual Complaints</h2>

    <div class="card shadow border-0 mt-3">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manualComplaintModal" id="addManualComplaintBtn">
                    Add Manual Complaint
                </button>
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterBox">
                    <i class="bi bi-funnel"></i> Filters
                </button>
            </div>

            <div class="collapse {{ request()->hasAny(['source_id','status','from','to','search']) ? 'show' : '' }}" id="filterBox">
                <div class="card card-body mb-3">
                    <form method="GET" class="row g-2">
                        <div class="col-md-2">
                            <label>Source</label>
                            <select class="form-control" name="source_id">
                                <option value="">All</option>
                                @foreach($sources as $source)
                                <option value="{{ $source->id }}" {{ (string) ($filters['source_id'] ?? '') === (string) $source->id ? 'selected' : '' }}>
                                    {{ $source->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">All</option>
                                <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="ao" {{ ($filters['status'] ?? '') === 'ao' ? 'selected' : '' }}>At A/O</option>
                                <option value="commissioner" {{ ($filters['status'] ?? '') === 'commissioner' ? 'selected' : '' }}>At Commissioner</option>
                                <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>From</label>
                            <input type="date" class="form-control" name="from" value="{{ $filters['from'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <label>To</label>
                            <input type="date" class="form-control" name="to" value="{{ $filters['to'] ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label>Search</label>
                            <input type="text" class="form-control" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name, phone, vehicle, email">
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle manual-complaints-table">
                    <thead class="table-dark">
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
                            <th>Entered By</th>
                            <th width="130">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($manualComplaints as $index => $item)
                        <tr class="manual-row" data-complaint-row="complaint-row-{{ $item->id }}" role="button" aria-expanded="false">
                            <td>{{ $manualComplaints->firstItem() + $index }}</td>
                            <td>{{ $item->sourceSetting->name ?? $item->source ?? '-' }}</td>
                            <td>{{ $item->complainant_name ?? '-' }}</td>
                            <td>{{ $item->phone ?? '-' }}</td>
                            <td>{{ $item->complaint_email ?? '-' }}</td>
                            <td>{{ $item->vehicle_number ?? '-' }}</td>
                            <td>{{ $item->complainType->name ?? '-' }}</td>
                            <td>
                                @if($item->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($item->status === 'ao')
                                <span class="badge bg-info">At A/O</span>
                                @elseif($item->status === 'commissioner')
                                <span class="badge bg-primary">At Commissioner</span>
                                @elseif($item->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                                @else
                                <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ optional($item->received_at)->format('d M Y') }}</td>
                            <td>{{ $item->enteredByUser->name ?? '-' }}</td>
                            <td>
                                <button
                                    class="btn btn-sm btn-primary editBtn action-btn"
                                    data-id="{{ $item->id }}"
                                    data-source-id="{{ $item->source_id }}"
                                    data-name="{{ $item->complainant_name }}"
                                    data-phone="{{ $item->phone }}"
                                    data-email="{{ $item->complaint_email }}"
                                    data-vehicle="{{ $item->vehicle_number }}"
                                    data-type="{{ $item->complain_type_id }}"
                                    data-complaint="{{ $item->complaint }}"
                                    data-received="{{ $item->received_at }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                @if($item->status === 'pending')
                                <form method="POST" action="{{ route('admin.manual-complaints.forward-ao', $item->id) }}" class="d-inline manual-forward-form" data-complainant="{{ $item->complainant_name ?? 'this complaint' }}" data-target="{{ in_array(strtolower(trim((string) auth()->user()->role)), ['administrative officer','a/o','ao']) ? 'Commissioner' : 'A/O' }}">
                                    @csrf
                                    <button class="btn btn-sm btn-warning action-btn">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                @endif

                                <form method="POST" action="{{ route('admin.manual-complaints.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Delete this manual complaint?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger action-btn">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr id="complaint-row-{{ $item->id }}" class="complaint-row">
                            <td></td>
                            <td colspan="10" class="bg-light complaint-content-cell">
                                <strong>Complaint:</strong> {{ $item->complaint ?: 'No complaint text available' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">No manual complaints found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                {{ $manualComplaints->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="forwardConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#e7f7fb;color:#0b6b79;">
                        <i class="bi bi-send"></i>
                    </div>
                    <div>
                        <h5 class="mb-0" id="forwardConfirmTitle">Forward Complaint</h5>
                        <small class="text-muted">Manual complaint workflow</small>
                    </div>
                </div>

                <div class="bg-light rounded-3 p-3 mb-3">
                    <div id="forwardConfirmText" class="fw-semibold">Forward this complaint to A/O?</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmForwardBtn" class="btn btn-info text-white px-4">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="manualComplaintModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="manualComplaintForm">
            @csrf
            <input type="hidden" name="_method" id="manualMethod" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manualModalTitle">Add Manual Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-4 mb-3">
                        <label>Source</label>
                        <select class="form-control" name="source_id" id="source_id" required>
                            <option value="" disabled selected>-- Select Source --</option>
                            @foreach($sources as $source)
                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="complainant_name" id="complainant_name">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="20">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="complaint_email" id="complaint_email">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Vehicle Number</label>
                        <input type="text" class="form-control text-uppercase" name="vehicle_number" id="vehicle_number" maxlength="20">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Complaint Type</label>
                        <select class="form-control" name="complain_type_id" id="complain_type_id">
                            <option value="">-- Select Type --</option>
                            @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Received Date</label>
                        <input type="date" class="form-control" name="received_at" id="received_at" value="{{ now()->toDateString() }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Complaint</label>
                        <textarea class="form-control" name="complaint" id="complaint" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .manual-complaints-table .manual-row {
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .manual-complaints-table .manual-row:hover {
        background-color: #f5f8ff;
    }

    .manual-complaints-table .complaint-row {
        display: none;
    }

    .manual-complaints-table .complaint-row.open {
        display: table-row;
    }

    .manual-complaints-table .complaint-content-cell {
        border-left: 4px solid #0d6efd;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('manualComplaintModal');
    const modal = new bootstrap.Modal(modalEl);
    const form = document.getElementById('manualComplaintForm');
    const forwardConfirmModalEl = document.getElementById('forwardConfirmModal');
    const forwardConfirmModal = new bootstrap.Modal(forwardConfirmModalEl);
    const forwardConfirmText = document.getElementById('forwardConfirmText');
    const forwardConfirmTitle = document.getElementById('forwardConfirmTitle');
    const confirmForwardBtn = document.getElementById('confirmForwardBtn');
    const manualRows = document.querySelectorAll('.manual-row');
    let selectedForwardForm = null;

    manualRows.forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.closest('.action-btn') || e.target.closest('form')) {
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

            document.querySelectorAll('.manual-row[aria-expanded="true"]').forEach(function (openedMainRow) {
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

    document.querySelectorAll('.manual-forward-form').forEach(function (forwardForm) {
        forwardForm.addEventListener('submit', function (e) {
            e.preventDefault();
            selectedForwardForm = this;
            const complainant = this.dataset.complainant || 'this complaint';
            const target = this.dataset.target || 'A/O';
            forwardConfirmTitle.innerText = 'Forward To ' + target;
            forwardConfirmText.innerText = 'Forward "' + complainant + '" complaint to ' + target + '?';
            forwardConfirmModal.show();
        });
    });

    confirmForwardBtn.addEventListener('click', function () {
        if (selectedForwardForm) {
            selectedForwardForm.submit();
        }
    });

    document.getElementById('addManualComplaintBtn').addEventListener('click', function () {
        form.action = "{{ route('admin.manual-complaints.store') }}";
        document.getElementById('manualMethod').value = 'POST';
        document.getElementById('manualModalTitle').innerText = 'Add Manual Complaint';
        form.reset();
        document.getElementById('source_id').selectedIndex = 0;
        document.getElementById('received_at').value = "{{ now()->toDateString() }}";
    });

    document.querySelectorAll('.editBtn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            form.action = '/admin/manual-complaints/' + id;
            document.getElementById('manualMethod').value = 'PUT';
            document.getElementById('manualModalTitle').innerText = 'Edit Manual Complaint';

            document.getElementById('source_id').value = this.dataset.sourceId || '';
            document.getElementById('complainant_name').value = this.dataset.name || '';
            document.getElementById('phone').value = this.dataset.phone || '';
            document.getElementById('complaint_email').value = this.dataset.email || '';
            document.getElementById('vehicle_number').value = this.dataset.vehicle || '';
            document.getElementById('complain_type_id').value = this.dataset.type || '';
            document.getElementById('received_at').value = this.dataset.received || '';
            document.getElementById('complaint').value = this.dataset.complaint || '';

            modal.show();
        });
    });

    const hasValidationErrors = document.getElementById('manualComplaintHasErrors')?.value === '1';
    if (hasValidationErrors) {
        modal.show();
    }
});
</script>
@endsection
