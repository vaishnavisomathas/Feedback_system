@extends('layouts.app')

@section('content')
<div class="container">

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Modal -->
<div class="modal fade" id="groupModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="groupForm">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitle">Add Permission Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Group Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<button class="btn btn-primary mb-3" id="createBtn">Add Group</button>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Group</th>
                <th>Action</th>
            </tr>
            @foreach($groups as $g)
            <tr>
                <td>{{ $g->name }}</td>
                <td>
                    <button class="btn btn-sm btn-primary editBtn"
                        data-id="{{ $g->id }}"
                        data-name="{{ $g->name }}">
                        Edit
                    </button>
                    <form method="POST" action="{{ route('permission.groups.delete',$g->id) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let modal = new bootstrap.Modal(document.getElementById('groupModal'));
    let form = document.getElementById('groupForm');

    // Create
    document.getElementById('createBtn').onclick = function() {
        form.action = "{{ route('permission.groups.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('modalTitle').innerText = 'Add Permission Group';
        form.reset();
        modal.show();
    };

    // Edit
    document.querySelectorAll('.editBtn').forEach(function(btn){
        btn.addEventListener('click', function() {
            let id = btn.dataset.id;
            form.action = '/admin/permission-groups/' + id; // update route
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('modalTitle').innerText = 'Edit Permission Group';
            document.getElementById('name').value = btn.dataset.name;
            modal.show();
        });
    });
});
</script>
@endsection
