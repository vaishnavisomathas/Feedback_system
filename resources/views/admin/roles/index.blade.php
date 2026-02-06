@extends('layouts.app')

@section('content')
<div class="container">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="modal fade" id="roleModal">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="roleForm">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitle">Add Role</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <label>Role Name</label>
                    <input name="name" id="name" class="form-control mb-3" required>
@foreach($groups as $group)
    <h6 class="mt-3">{{ $group->name }}</h6>
    @foreach($group->permissions as $p)
        <div class="form-check mb-2">
            <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $p->name }}" id="perm_{{ $p->id }}">
            <label class="form-check-label" for="perm_{{ $p->id }}">
                {{ $p->name }}
            </label>
        </div>
    @endforeach
@endforeach



                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<button class="btn btn-primary mb-3" id="createBtn">Add Role</button>

<div class="card">
<div class="card-body">
<table class="table table-bordered">
<tr>
    <th>Role</th>
       <th>Permissions</th>
    <th>Action</th>
</tr>
@foreach($roles as $r)
<tr>
    <td>{{ $r->name }}</td>
         <td>
                        @foreach($r->permissions as $p)
                            <span class="badge bg-info">{{ $p->name }}</span>
                        @endforeach
                    </td>
    <td>
        <button class="btn btn-sm btn-primary editBtn"
            data-id="{{ $r->id }}"
            data-name="{{ $r->name }}"
            data-permissions="{{ implode(',', $r->permissions->pluck('name')->toArray()) }}">
            Edit
        </button>
        <form method="POST" action="{{ route('roles.delete',$r->id) }}" class="d-inline">
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
    let modal = new bootstrap.Modal(document.getElementById('roleModal'));
    let form = document.getElementById('roleForm');

    document.getElementById('createBtn').onclick = function() {
        form.action = "{{ route('roles.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('modalTitle').innerText = 'Add Role';
        form.reset();
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        modal.show();
    };

    document.querySelectorAll('.editBtn').forEach(function(btn){
        btn.addEventListener('click', function() {
            let id = btn.dataset.id;
            form.action = '/admin/roles/' + id;
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('modalTitle').innerText = 'Edit Role';
            document.getElementById('name').value = btn.dataset.name;

            let perms = btn.dataset.permissions.split(',');
            document.querySelectorAll('.permission-checkbox').forEach(cb => {
                cb.checked = perms.includes(cb.value);
            });

            modal.show();
        });
    });
});
</script>
@endsection
