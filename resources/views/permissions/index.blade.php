@extends('layouts.app')

@section('content')
<div class="container">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Modal -->
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

                    <div class="mb-3">
                        <label>Permission Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Group</label>
                        <select name="group_id" id="group_id" class="form-control" required>
                            <option value="">Select Group</option>
                            @foreach($groups as $id=>$group)
                                <option value="{{ $id }}">{{ $group }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
<thead>
<tr>
<th>Name</th>
<th>Group</th>
<th width="180">Action</th>
</tr>
</thead>

<tbody>
@foreach($permissions as $permission)
<tr>
<td>{{ $permission->name }}</td>
<td>{{ $permission->group->name ?? '-' }}</td>
<td>

<button class="btn btn-sm btn-primary editBtn"
data-id="{{ $permission->id }}"
data-name="{{ $permission->name }}"
data-group="{{ $permission->group_id }}">
Edit
</button>

<form action="{{ route('permissions.destroy',$permission->id) }}" method="POST" class="d-inline">
@csrf @method('DELETE')
<button class="btn btn-danger btn-sm">Delete</button>
</form>

</td>
</tr>
@endforeach
</tbody>
</table>
  
</div>
</div>
 <div class="d-flex justify-content-end align-items-center">
    <div class="col-md-2 p-0">
        <form method="GET">
         
            <select name="per_page" class="form-control" onchange="this.form.submit()">
                @foreach([10, 20, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected' : '' }}>
                        Page {{ $size }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let modalEl = document.getElementById('permissionModal');
    let modal = new bootstrap.Modal(modalEl);

    let form = document.getElementById('permissionForm');
    let methodField = document.getElementById('methodField');
    let modalTitle = document.getElementById('modalTitle');
    let nameInput = document.getElementById('name');
    let groupSelect = document.getElementById('group_id');

    // CREATE
    document.getElementById('createBtn').addEventListener('click', function(){
        form.action = "{{ route('permissions.store') }}";
        methodField.value = 'POST';
        modalTitle.innerText = 'Add Permission';
        form.reset();
        modal.show();
    });

    // EDIT
    document.querySelectorAll('.editBtn').forEach(function(btn){
        btn.addEventListener('click', function(){

            form.action = '/permissions/' + btn.dataset.id;
            methodField.value = 'PUT';
            modalTitle.innerText = 'Edit Permission';

            nameInput.value = btn.dataset.name;
            groupSelect.value = btn.dataset.group;

            modal.show();
        });
    });

});
</script>
@endsection
