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
                                    data-active="{{ $source->is_active ? '1' : '0' }}">
                                    Edit
                                </button>

                                <form method="POST" action="{{ route('manual-complaint-sources.destroy', $source->id) }}" class="d-inline" onsubmit="return confirm('Delete this source?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
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
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('sourceModal'));
    const form = document.getElementById('sourceForm');

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
});
</script>
@endsection
