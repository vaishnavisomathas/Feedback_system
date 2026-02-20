@extends('layouts.app')
@section('title')
Service Quality-PDMT

@endsection

@section('content')
<div class="container">

<h3 class="mb-3">Service Quality Management</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<button class="btn btn-primary mb-3" id="addBtn">Add Quality</button>

<!-- MODAL -->
<div class="modal fade" id="qualityModal">
<div class="modal-dialog">
<form method="POST" id="qualityForm">
@csrf
<input type="hidden" id="methodField" name="_method">

<div class="modal-content">
<div class="modal-header">
<h5 id="modalTitle">Add</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" id="name" class="form-control" required>
</div>



</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
<button class="btn btn-primary">Save</button>
</div>

</div>
</form>
</div>
</div>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>#</th>
<th>Name</th>
<th>Action</th>
</tr>
</thead>

<tbody>
@foreach($qualities as $q)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $q->name }}</td>

<td>

<button class="btn btn-warning btn-sm editBtn"
data-id="{{ $q->id }}"
data-name="{{ $q->name }}"
>
Edit
</button>

<form method="POST" action="{{ route('service.quality.destroy',$q->id) }}" class="d-inline">
@csrf
@method('DELETE')
<button class="btn btn-danger btn-sm">Delete</button>
</form>

</td>
</tr>
@endforeach
</tbody>
</table>

{{ $qualities->links() }}

</div>
@endsection

@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {

    let modalElement = document.getElementById('qualityModal');
    let modal = new bootstrap.Modal(modalElement);

    let form = document.getElementById('qualityForm');
    let methodField = document.getElementById('methodField');
    let modalTitle = document.getElementById('modalTitle');
    let nameInput = document.getElementById('name');

    // ADD BUTTON
    document.getElementById('addBtn').addEventListener('click', function () {
        form.action = "{{ route('service.quality.store') }}";
        methodField.value = '';
        modalTitle.innerText = 'Add Service Quality';
        form.reset();
        modal.show();
    });

    // EDIT BUTTON
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', function () {

form.action = "{{ url('/service-quality') }}/" + btn.dataset.id;
            methodField.value = 'PUT';
            modalTitle.innerText = 'Edit Service Quality';

            nameInput.value = btn.dataset.name;

            modal.show();
        });
    });

});
</script>
@endsection

