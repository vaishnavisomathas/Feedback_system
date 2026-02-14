@extends('layouts.app')

@section('content')
<div class="container">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- ROLE MODAL -->
<div class="modal fade" id="roleModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<form method="POST" id="roleForm">
@csrf
<input type="hidden" name="_method" id="methodField" value="POST">

<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title" id="modalTitle">Add Role</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Role Name</label>
<input type="text" name="name" id="nameInput" class="form-control" required>
</div>

<hr>
<h5 class="mb-3">Assign Permissions</h5>

<div class="row">

@foreach($permissionGroups as $group)
<div class="col-md-4 mb-3">

<h6 class="fw-bold text-primary">{{ $group->name }}</h6>

@foreach($group->permissions as $permission)
<div class="form-check">
<input type="checkbox"
class="form-check-input permission-checkbox"
name="permissions[]"
value="{{ $permission->id }}"
id="perm_{{ $permission->id }}">

<label class="form-check-label" for="perm_{{ $permission->id }}">
{{ $permission->name }}
</label>
</div>
@endforeach

</div>
@endforeach

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

<button class="btn btn-primary mb-3" id="createRoleBtn">Add Role</button>

<div class="card">
<div class="card-body">

<h5>Role List</h5>

<table class="table table-bordered">
<thead>
<tr>
<th>Role</th>
<th>Permissions</th>
<th width="180">Action</th>
</tr>
</thead>

<tbody>
@foreach($roles as $role)
<tr>

<td>{{ $role->name }}</td>

<td>
@forelse ($role->permissions as $permission)
<span class="badge bg-info text-dark mb-1">{{ $permission->name }}</span>
@empty
<span class="text-muted">No permissions</span>
@endforelse
</td>

<td>

<button class="btn btn-sm btn-primary editBtn"
data-id="{{ $role->id }}"
data-name="{{ $role->name }}"
data-permissions='@json($role->permissions->pluck("id"))'>
Edit
</button>

<form action="{{ route('roles.destroy',$role->id) }}" method="POST" class="d-inline">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger"
onclick="return confirm('Delete this role?')">
Delete
</button>
</form>

</td>

</tr>
@endforeach
</tbody>
</table>

</div>
</div>

</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- ROLE MODAL -->
<div class="modal fade" id="roleModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<form method="POST" id="roleForm">
@csrf
<input type="hidden" name="_method" id="methodField" value="POST">

<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title" id="modalTitle">Add Role</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Role Name</label>
<input type="text" name="name" id="nameInput" class="form-control" required>
</div>

<hr>
<h5 class="mb-3">Assign Permissions</h5>

<div class="row">

@foreach($permissionGroups as $group)
<div class="col-md-4 mb-3">

<h6 class="fw-bold text-primary">{{ $group->name }}</h6>

@foreach($group->permissions as $permission)
<div class="form-check">
<input type="checkbox"
class="form-check-input permission-checkbox"
name="permissions[]"
value="{{ $permission->id }}"
id="perm_{{ $permission->id }}">

<label class="form-check-label" for="perm_{{ $permission->id }}">
{{ $permission->name }}
</label>
</div>
@endforeach

</div>
@endforeach

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

<button class="btn btn-primary mb-3" id="createRoleBtn">Add Role</button>

<div class="card">
<div class="card-body">

<h5>Role List</h5>

<table class="table table-bordered">
<thead>
<tr>
<th>Role</th>
<th>Permissions</th>
<th width="180">Action</th>
</tr>
</thead>

<tbody>
@foreach($roles as $role)
<tr>

<td>{{ $role->name }}</td>

<td>
@forelse ($role->permissions as $permission)
<span class="badge bg-info text-dark mb-1">{{ $permission->name }}</span>
@empty
<span class="text-muted">No permissions</span>
@endforelse
</td>

<td>

<button class="btn btn-sm btn-primary editBtn"
data-id="{{ $role->id }}"
data-name="{{ $role->name }}"
data-permissions='@json($role->permissions->pluck("id"))'>
Edit
</button>

<form action="{{ route('roles.destroy',$role->id) }}" method="POST" class="d-inline">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger"
onclick="return confirm('Delete this role?')">
Delete
</button>
</form>

</td>

</tr>
@endforeach
</tbody>
</table>

</div>
</div>

</div>
@endsection
@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

let modal = new bootstrap.Modal(document.getElementById('roleModal'));
let form = document.getElementById('roleForm');
let methodField = document.getElementById('methodField');
let modalTitle = document.getElementById('modalTitle');
let nameInput = document.getElementById('nameInput');


// CREATE ROLE
document.getElementById('createRoleBtn').addEventListener('click', function() {

form.action = "{{ route('roles.store') }}";
methodField.value = 'POST';
modalTitle.innerText = 'Add Role';
form.reset();

document.querySelectorAll('.permission-checkbox').forEach(c=>c.checked=false);

modal.show();
});


// EDIT ROLE
document.querySelectorAll('.editBtn').forEach(function(btn) {

btn.addEventListener('click', function() {

let id = btn.dataset.id;
let permissions = JSON.parse(btn.dataset.permissions);

form.action = '/roles/' + id;
methodField.value = 'PUT';
modalTitle.innerText = 'Edit Role';

// SET OLD NAME
nameInput.value = btn.dataset.name;

// UNCHECK ALL
document.querySelectorAll('.permission-checkbox').forEach(c=>c.checked=false);

// CHECK ASSIGNED
permissions.forEach(function(pid){
let checkbox = document.getElementById('perm_'+pid);
if(checkbox) checkbox.checked = true;
});

modal.show();
});
});

});
</script>
@endsection
