@extends('layouts.app')

@section('content')
<div class="container">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Modal -->
<div class="modal fade" id="groupModal">
    <div class="modal-dialog">
        <form method="POST" id="groupForm">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalTitle">Add Permission Group</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Group Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

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
<thead>
<tr>
<th>Group Name</th>
<th width="180">Action</th>
</tr>
</thead>

<tbody>
@foreach($groups as $group)
<tr>
<td>{{ $group->name }}</td>
<td>

<button class="btn btn-sm btn-primary editBtn"
data-id="{{ $group->id }}"
data-name="{{ $group->name }}">
Edit
</button>

<form action="{{ route('permission-groups.destroy',$group->id) }}" method="POST" class="d-inline">
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
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let modalEl = document.getElementById('groupModal');
    let modal = new bootstrap.Modal(modalEl);
    let form = document.getElementById('groupForm');
    let methodField = document.getElementById('methodField');
    let modalTitle = document.getElementById('modalTitle');
    let nameInput = document.getElementById('name');

    // CREATE
    document.getElementById('createBtn').addEventListener('click', function() {
        form.action = "{{ route('permission-groups.store') }}";
        methodField.value = 'POST';
        modalTitle.innerText = 'Add Permission Group';
        form.reset();
        modal.show();
    });

    // EDIT
    document.querySelectorAll('.editBtn').forEach(function(btn){
        btn.addEventListener('click', function(){

            form.action = '/permission-groups/' + btn.dataset.id;
            methodField.value = 'PUT';
            modalTitle.innerText = 'Edit Permission Group';
            nameInput.value = btn.dataset.name;

            modal.show();
        });
    });

});
</script>
@endsection
