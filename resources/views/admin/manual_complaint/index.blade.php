@extends('layouts.app')

@section('title')
Manual Complaints - PDMT
@endsection

@section('content')
<div class="container">
    @php
        $roleLower = strtolower(trim((string) auth()->user()->role));
        $isAdministrativeOfficer = in_array($roleLower, ['administrative officer', 'a/o', 'ao'], true);
        $isCommissioner = $roleLower === 'commissioner';
        $showActionButtons = $roleLower === 'super admin';
        $canAddManualComplaint = in_array($roleLower, ['super admin', 'admin', 'user'], true);
    @endphp
    <input type="hidden" id="manualComplaintHasErrors" value="{{ $errors->any() ? '1' : '0' }}">
    <h2 class="mb-0">Manual Complaints</h2>

    <div class="card shadow border-0 mt-3">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-3">
                @if($canAddManualComplaint)
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manualComplaintModal" id="addManualComplaintBtn">
                    Add Manual Complaint
                </button>
                @else
                <div></div>
                @endif
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#filterBox">
                    <i class="bi bi-funnel"></i> Filters
                </button>
            </div>

            <div class="collapse" id="filterBox">
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
                                <option value="verified" {{ ($filters['status'] ?? '') === 'verified' ? 'selected' : '' }}>Verified</option>
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
                        <div class="col-md-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.manual-complaints.index') }}" class="btn btn-outline-secondary btn-sm">
                               <i class="bi bi-arrow-clockwise me-1"></i>
                            </a>

                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle manual-complaints-table">
                    <thead class="manual-table-head">
                        <tr>
                            <th>#</th>
                            <th>Source</th>
                            <th>Phone</th>
                            <th>Vehicle</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            @if($showActionButtons)
                            <th width="170">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($manualComplaints as $index => $item)
                        <tr
                            class="manual-row"
                            role="button"
                            data-id="{{ $item->id }}"
                            data-note-route="{{ route('admin.manual-complaints.save-action-note', $item->id) }}"
                            data-ao-save-route="{{ route('admin.manual-complaints.ao.save', $item->id) }}"
                            data-source="{{ $item->sourceSetting->name ?? $item->source ?? '-' }}"
                            data-phone="{{ $item->phone ?? '-' }}"
                            data-vehicle-number="{{ $item->vehicle_number ?? '-' }}"
                            data-complainant-name="{{ $item->complainant_name ?? '-' }}"
                            data-complaint-email="{{ $item->complaint_email ?? '-' }}"
                            data-complaint-type="{{ $item->complainType->name ?? '-' }}"
                            data-entered-by="{{ $item->enteredByUser->name ?? '-' }}"
                            data-received-date="{{ optional($item->received_at)->format('d M Y') ?: '-' }}"
                            data-action-note="{{ $item->action_note ?? '' }}"
                            data-commissioner-remarks="{{ $item->commissioner_remarks ?? '' }}"
                            data-status="{{ $item->status ?? 'pending' }}"
                            data-commissioner-action-route="{{ route('admin.manual-complaints.commissioner-action', $item->id) }}"
                            data-complaint-text="{{ $item->complaint ?: 'No complaint text available' }}">
                            <td>{{ $manualComplaints->firstItem() + $index }}</td>
                            <td>{{ $item->sourceSetting->name ?? $item->source ?? '-' }}</td>
                            <td>{{ $item->phone ?? '-' }}</td>
                            <td>{{ $item->vehicle_number ?? '-' }}</td>
                            <td>{{ optional($item->created_at)->format('d M Y, h:i A') }}</td>
                            <td>
                                @if($item->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($item->status === 'ao')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($item->status === 'verified')
                                <span class="badge bg-secondary">Verified</span>
                                @elseif($item->status === 'commissioner')
                                <span class="badge bg-primary">At Commissioner</span>
                                @elseif($item->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                                @else
                                <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            @if($showActionButtons)
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

                                <form method="POST" action="{{ route('admin.manual-complaints.destroy', $item->id) }}" class="d-inline manual-delete-form" data-complainant="{{ $item->complainant_name ?? 'this complaint' }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger action-btn">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $showActionButtons ? 7 : 6 }}" class="text-center">No manual complaints found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end align-items-center mt-3">
                <div>
                    {{ $manualComplaints->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#ffe9ec;color:#c02424;">
                        <i class="bi bi-trash"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Delete Complaint</h5>
                    </div>
                </div>

                <div class="bg-light rounded-3 p-3 mb-3">
                    <div id="deleteConfirmText" class="fw-semibold">Delete this manual complaint?</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger px-4">Delete</button>
                </div>
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

<div class="modal fade" id="manualComplaintDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manual Complaint Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Name</label>
                        <div id="detailsComplainantName" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Source</label>
                        <div id="detailsSource" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Phone</label>
                        <div id="detailsPhone" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Email</label>
                        <div id="detailsComplaintEmail" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Vehicle Number</label>
                        <div id="detailsVehicleNumber" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Complaint Type</label>
                        <div id="detailsComplaintType" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Entered By</label>
                        <div id="detailsEnteredBy" class="fw-semibold">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted mb-1">Date</label>
                        <div id="detailsReceivedDate" class="fw-semibold">-</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-muted mb-1">Complaint</label>
                        <div id="detailsComplaintText" class="p-3 bg-light rounded border">-</div>
                    </div>
                       <div class="col-md-12">
                        <label class="form-label text-muted mb-1">Action Note</label>
                        <div id="detailsActionNoteView" class="p-3 bg-light rounded border">-</div>
                    </div>
                    @if($isAdministrativeOfficer)
                    <div class="col-12">
                        <form method="POST" id="aoVerifyForwardForm">
                            @csrf
                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" name="action" value="verify" class="btn btn-outline-secondary btn-sm">Verified</button>
                            </div>
                        </form>
                    </div>
                    @endif
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
                        <input type="text" class="form-control" name="complainant_name" id="complainant_name" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" maxlength="20" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="complaint_email" id="complaint_email">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Vehicle Number</label>
                        <input type="text" class="form-control text-uppercase" name="vehicle_number" id="vehicle_number" maxlength="20" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Complaint Type</label>
                        <select class="form-control" name="complain_type_id" id="complain_type_id" required>
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
                  <div class="col-md-12 mb-3">
                            <label class="form-label text-muted mb-1">Action Note</label>
                            <textarea class="form-control" name="action_note" rows="3" placeholder="Enter action note" required></textarea>


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
    .manual-complaints-table {
        border: 1px solid #dbe3ee;
        border-collapse: separate;
        border-spacing: 0;
    }

    .manual-complaints-table .manual-table-head th {
        background-color: #f3f6fa;
        color: #243b53;
        border-bottom: 1px solid #d2dceb;
        font-weight: 600;
        white-space: nowrap;
        padding: 12px 14px;
    }

    .manual-complaints-table .manual-row {
        cursor: pointer;
        transition: background-color .2s ease;
    }

    .manual-complaints-table .manual-row td {
        background-color: #ffffff;
        border-top: 1px solid #edf1f5;
        color: #5f6c7b;
        padding: 12px 14px;
    }

    .manual-complaints-table .manual-row:hover {
        background-color: #f8fafc;
    }

    .manual-complaints-table .manual-row:hover td {
        background-color: #f8fafc;
    }

    .manual-complaints-table .badge {
        font-weight: 600;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 6px;
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
    const deleteConfirmModalEl = document.getElementById('deleteConfirmModal');
    const deleteConfirmModal = new bootstrap.Modal(deleteConfirmModalEl);
    const deleteConfirmText = document.getElementById('deleteConfirmText');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const detailsModalEl = document.getElementById('manualComplaintDetailsModal');
    const detailsModal = new bootstrap.Modal(detailsModalEl);
    const detailsActionNoteForm = document.getElementById('detailsActionNoteForm');
    const detailsActionNote = document.getElementById('detailsActionNote');
    const aoVerifyForwardForm = document.getElementById('aoVerifyForwardForm');
    const manualRows = document.querySelectorAll('.manual-row');
    let selectedForwardForm = null;
    let selectedDeleteForm = null;

    function openDetailsModal(rowElement) {
        document.getElementById('detailsComplainantName').innerText = rowElement.dataset.complainantName || '-';
        document.getElementById('detailsSource').innerText = rowElement.dataset.source || '-';
        document.getElementById('detailsPhone').innerText = rowElement.dataset.phone || '-';
        document.getElementById('detailsComplaintEmail').innerText = rowElement.dataset.complaintEmail || '-';
        document.getElementById('detailsVehicleNumber').innerText = rowElement.dataset.vehicleNumber || '-';
        document.getElementById('detailsComplaintType').innerText = rowElement.dataset.complaintType || '-';
        document.getElementById('detailsEnteredBy').innerText = rowElement.dataset.enteredBy || '-';
        document.getElementById('detailsReceivedDate').innerText = rowElement.dataset.receivedDate || '-';
        document.getElementById('detailsActionNoteView').innerText = rowElement.dataset.actionNote || '-';
        document.getElementById('detailsComplaintText').innerText = rowElement.dataset.complaintText || '-';
        if (detailsActionNote && detailsActionNoteForm) {
            detailsActionNote.value = rowElement.dataset.actionNote || '';
            detailsActionNoteForm.action = rowElement.dataset.noteRoute || '';
        }
        if (aoVerifyForwardForm) {
            aoVerifyForwardForm.action = rowElement.dataset.aoSaveRoute || '';
        }
        detailsModal.show();
    }

    manualRows.forEach(function (row) {
        row.addEventListener('click', function (e) {
            if (e.target.closest('.action-btn') || e.target.closest('form')) {
                return;
            }

            openDetailsModal(this);
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

    document.querySelectorAll('.manual-delete-form').forEach(function (deleteForm) {
        deleteForm.addEventListener('submit', function (e) {
            e.preventDefault();
            selectedDeleteForm = this;
            const complainant = this.dataset.complainant || 'this complaint';
            deleteConfirmText.innerText = 'Delete "' + complainant + '" complaint?';
            deleteConfirmModal.show();
        });
    });

    confirmDeleteBtn.addEventListener('click', function () {
        if (selectedDeleteForm) {
            selectedDeleteForm.submit();
        }
    });

    const addManualComplaintBtn = document.getElementById('addManualComplaintBtn');
    if (addManualComplaintBtn) {
        addManualComplaintBtn.addEventListener('click', function () {
            form.action = "{{ route('admin.manual-complaints.store') }}";
            document.getElementById('manualMethod').value = 'POST';
            document.getElementById('manualModalTitle').innerText = 'Add Manual Complaint';
            form.reset();
            document.getElementById('source_id').selectedIndex = 0;
            document.getElementById('received_at').value = "{{ now()->toDateString() }}";
        });
    }

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
