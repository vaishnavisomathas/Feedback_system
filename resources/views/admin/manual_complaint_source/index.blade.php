@extends('layouts.app')

@section('title')
Manual Complaint Sources - PDMT
@endsection

@section('content')
<div class="container">
    <h3 class="mb-0">Manual Complaint Sources</h3>

    @if(session('success'))
    <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger mt-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <button class="btn btn-primary mb-3 mt-3" id="addSourceBtn">Add Source</button>

    <div class="modal fade" id="sourceModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="sourceForm">
                @csrf
                <input type="hidden" name="_method" id="sourceMethod" value="POST">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="sourceModalTitle">Add Source</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Source Name</label>
                            <input type="text" name="name" id="sourceName" class="form-control" required>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="sourceActive" value="1" checked>
                            <label class="form-check-label" for="sourceActive">Active</label>
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

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th width="160">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sources as $index => $source)
                        <tr>
                            <td>{{ ($sources->currentPage() - 1) * $sources->perPage() + $index + 1 }}</td>
                            <td>{{ $source->name }}</td>
                            <td>
                                @if($source->is_active)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-primary editSourceBtn"
                                    data-id="{{ $source->id }}"
                                    data-name="{{ $source->name }}"
                                    data-active="{{ $source->is_active ? '1' : '0' }}"
                                    title="Edit"
                                    aria-label="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form method="POST" action="{{ route('manual-complaint-sources.destroy', $source->id) }}" class="d-inline deleteSourceForm" data-source-name="{{ $source->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Delete" aria-label="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No sources found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $sources->links() }}
    </div>
</div>

<div class="modal fade" id="deleteSourceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#ffe9ec;color:#c02424;">
                        <i class="bi bi-trash"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Delete Source</h5>
                    </div>
                </div>

                <div class="bg-light rounded-3 p-3 mb-3">
                    <div id="deleteSourceText" class="fw-semibold">Delete this source?</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteSourceBtn" class="btn btn-danger px-4">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('sourceModal'));
    const form = document.getElementById('sourceForm');
    const deleteSourceModal = new bootstrap.Modal(document.getElementById('deleteSourceModal'));
    const deleteSourceText = document.getElementById('deleteSourceText');
    const confirmDeleteSourceBtn = document.getElementById('confirmDeleteSourceBtn');
    let selectedDeleteForm = null;

    document.getElementById('addSourceBtn').addEventListener('click', function () {
        form.action = "{{ route('manual-complaint-sources.store') }}";
        document.getElementById('sourceMethod').value = 'POST';
        document.getElementById('sourceModalTitle').innerText = 'Add Source';
        document.getElementById('sourceName').value = '';
        document.getElementById('sourceActive').checked = true;
        modal.show();
    });

    document.querySelectorAll('.editSourceBtn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            form.action = '/manual-complaint-sources/' + id;
            document.getElementById('sourceMethod').value = 'PUT';
            document.getElementById('sourceModalTitle').innerText = 'Edit Source';
            document.getElementById('sourceName').value = this.dataset.name || '';
            document.getElementById('sourceActive').checked = this.dataset.active === '1';
            modal.show();
        });
    });

    document.querySelectorAll('.deleteSourceForm').forEach(function (deleteForm) {
        deleteForm.addEventListener('submit', function (e) {
            e.preventDefault();
            selectedDeleteForm = this;
            const sourceName = this.dataset.sourceName || 'this source';
            deleteSourceText.innerText = 'Delete "' + sourceName + '" source?';
            deleteSourceModal.show();
        });
    });

    confirmDeleteSourceBtn.addEventListener('click', function () {
        if (selectedDeleteForm) {
            selectedDeleteForm.submit();
        }
    });
});
</script>
@endsection
