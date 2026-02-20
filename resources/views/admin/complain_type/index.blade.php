@extends('layouts.app')

@section('title')
Complaint Types- PDMT
@endsection

@section('content')
<div class="container">
<h3 class="mb-3">Complaint Types Management</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<button class="btn btn-primary mb-3" id="addBtn">
    Add Complaint Type
</button>

<div class="modal fade" id="typeModal" tabindex="-1">
<div class="modal-dialog">
<form method="POST" id="typeForm">
@csrf
<input type="hidden" name="_method" id="methodField" value="POST">

<div class="modal-content">

<div class="modal-header">
<h5 id="modalTitle">Add Complaint Type</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label class="form-label">Name</label>
<input type="text" name="name" id="name" class="form-control" required>
</div>

<div class="mb-3">
<label class="form-label">Description</label>
<textarea name="description" id="description" class="form-control" rows="3"></textarea>
</div>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
<button type="submit" class="btn btn-primary">Save</button>
</div>

</div>
</form>
</div>
</div>

{{-- TABLE --}}
<table class="table table-bordered table-striped">
<thead class="table-dark">
<tr>
<th>#</th>
<th>Name</th>
<th>Description</th>
<th width="150">Action</th>
</tr>
</thead>

<tbody>
@forelse($types as $type)
<tr>
<td>{{ $types->firstItem() + $loop->index }}</td>
<td>{{ $type->name }}</td>
<td>{{ $type->description }}</td>
<td>

<button class="btn btn-sm btn-warning editBtn"
data-id="{{ $type->id }}"
data-name="{{ $type->name }}"
data-description="{{ $type->description }}">
Edit
</button>

<form method="POST"
      action="{{ route('complain.types.destroy',$type->id) }}"
      class="d-inline"
      onsubmit="return confirm('Delete this complaint type?')">
@csrf
@method('DELETE')
<button class="btn btn-sm btn-danger">Delete</button>
</form>

</td>
</tr>
@empty
<tr>
<td colspan="4" class="text-center">No complaint types found</td>
</tr>
@endforelse
</tbody>
</table>

{{ $types->links() }}

</div>
@endsection


@section('script')
<script>
document.addEventListener('DOMContentLoaded', function(){

let modal = new bootstrap.Modal(document.getElementById('typeModal'));
let form = document.getElementById('typeForm');
let methodField = document.getElementById('methodField');
let modalTitle = document.getElementById('modalTitle');
let nameInput = document.getElementById('name');
let descInput = document.getElementById('description');

/* ADD BUTTON */
document.getElementById('addBtn').addEventListener('click', function(){
    form.action = "{{ route('complain.types.store') }}";
    methodField.value = 'POST';
    modalTitle.innerText = 'Add Complaint Type';
    form.reset();
    modal.show();
});

/* EDIT BUTTON */
document.querySelectorAll('.editBtn').forEach(function(btn){
    btn.addEventListener('click', function(){

        let id = btn.dataset.id;

form.action = "{{ url('complain-types') }}/" + id;
        methodField.value = 'PUT';

        modalTitle.innerText = 'Edit Complaint Type';
        nameInput.value = btn.dataset.name;
        descInput.value = btn.dataset.description ?? '';

        modal.show();
    });
});

});
</script>
@endsection
