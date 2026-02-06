@extends('layouts.app')

@section('content')
<div class="container">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="modal fade" id="permissionModal">
    <div class="modal-dialog">
        <form method="POST" id="permissionForm">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitle">Add Permission</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Permission Name</label>
                    <input name="name" id="name" class="form-control mb-2" required>

                    <label>Group</label>
                    <select name="group_id" id="group_id" class="form-control">
                        @foreach($groups as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<button class="btn btn-primary mb-3" id="createBtn">Add Permission</button>

<div class="card">
<div class="card-body">
<table class="table table-bordered">
<tr>
    <th>Permission</th>
      <th>Permission Group</th>
    <th>Action</th>
</tr>
@foreach($permissions as $p)
<tr>
    <td>{{ $p->name }}</td>
    <td>{{ $p->group ? $p->group->name : '-' }}</td>
    <td>
        <button class="btn btn-sm btn-primary editBtn"
            data-id="{{ $p->id }}"
            data-name="{{ $p->name }}"
            data-group="{{ $p->group_id ?? '' }}">
            Edit
        </button>
        <form method="POST" action="{{ route('permissions.delete',$p->id) }}" class="d-inline">
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
    let modal = new bootstrap.Modal(document.getElementById('permissionModal'));
    let form = document.getElementById('permissionForm');

    document.getElementById('createBtn').onclick = function() {
        form.action = "{{ route('permissions.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('modalTitle').innerText = 'Add Permission';
        form.reset();
        modal.show();
    };

    document.querySelectorAll('.editBtn').forEach(function(btn){
        btn.addEventListener('click', function() {
            let id = btn.dataset.id;
            form.action = '/admin/permissions/' + id;
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('modalTitle').innerText = 'Edit Permission';
            document.getElementById('name').value = btn.dataset.name;
            document.getElementById('group_id').value = btn.dataset.group;
            modal.show();
        });
    });
});
</script>
@endsection
