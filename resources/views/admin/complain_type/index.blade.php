@extends('layouts.app')

@section('title')
Complaint Types - PDMT
@endsection

<style>
    .table td,
    .table th {
        font-size: 14px;
    }

    @media (max-width:768px) {

        h3 {
            font-size: 20px;
        }

        .table td,
        .table th {
            font-size: 12px;
            padding: 6px;
        }

    }
</style>

@section('content')

<div class="container">

    <h3 class="mb-0">Complaint Types Management</h3>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
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


    <!-- Modal -->
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



    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card table-card shadow-sm">

                <div class="card-header table-header d-flex justify-content-between align-items-center">

                    <span>Complaint Types List</span>

                </div>


                <div class="table-responsive">

                    <table class="table dashboard-table mb-0">

                        <thead>

                            <tr>

                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th width="150">Action</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($types as $index => $type)

                            <tr>

                                <td>
                                    {{ ($types->currentPage() - 1) * $types->perPage() + $index + 1 }}
                                </td>

                                <td>
                                    {{ $type->name }}
                                </td>

                                <td>
                                    {{ $type->description }}
                                </td>

                                <td>

                                    <button class="btn btn-sm btn-primary editBtn"
                                        data-id="{{ $type->id }}"
                                        data-name="{{ $type->name }}"
                                        data-description="{{ $type->description }}"
                                        title="Edit"
                                        aria-label="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>


                                    <form method="POST"
                                        action="{{ route('complain.types.destroy',$type->id) }}"
                                        class="d-inline deleteTypeForm"
                                        data-type-name="{{ $type->name }}">

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
                                <td colspan="4" class="text-center">
                                    No complaint types found
                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <div class="d-flex justify-content-end align-items-center">

        <div class="col-md-2 p-0">

            <form method="GET">

                <select name="per_page"
                    class="form-control"
                    onchange="this.form.submit()">

                    @foreach([10,20,50,100] as $size)

                    <option value="{{ $size }}"
                        {{ request('per_page') == $size ? 'selected' : '' }}>

                        Page {{ $size }}

                    </option>

                    @endforeach

                </select>

            </form>

        </div>

    </div>


</div>

<div class="modal fade" id="deleteTypeModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-body p-4">

                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#ffe9ec;color:#c02424;">
                        <i class="bi bi-trash"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Delete Complaint Type</h5>
                    </div>
                </div>

                <div class="bg-light rounded-3 p-3 mb-3">
                    <div id="deleteTypeText" class="fw-semibold">Delete this complaint type?</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteTypeBtn" class="btn btn-danger px-4">Delete</button>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@section('script')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
    document.addEventListener('DOMContentLoaded', function() {

        let modal = new bootstrap.Modal(document.getElementById('typeModal'));

        let form = document.getElementById('typeForm');

        let methodField = document.getElementById('methodField');

        let modalTitle = document.getElementById('modalTitle');

        let nameInput = document.getElementById('name');

        let descInput = document.getElementById('description');

        let deleteTypeModal = new bootstrap.Modal(document.getElementById('deleteTypeModal'));

        let deleteTypeText = document.getElementById('deleteTypeText');

        let confirmDeleteTypeBtn = document.getElementById('confirmDeleteTypeBtn');

        let selectedDeleteForm = null;


        /* ADD BUTTON */

        document.getElementById('addBtn').addEventListener('click', function() {

            form.action = "{{ route('complain.types.store') }}";

            methodField.value = 'POST';

            modalTitle.innerText = 'Add Complaint Type';

            form.reset();

            modal.show();

        });


        /* EDIT BUTTON */

        document.querySelectorAll('.editBtn').forEach(function(btn) {

            btn.addEventListener('click', function() {

                let id = btn.dataset.id;

                form.action = "{{ url('complain-types') }}/" + id;

                methodField.value = 'PUT';

                modalTitle.innerText = 'Edit Complaint Type';

                nameInput.value = btn.dataset.name;

                descInput.value = btn.dataset.description ?? '';

                modal.show();

            });

        });

        document.querySelectorAll('.deleteTypeForm').forEach(function(deleteForm) {

            deleteForm.addEventListener('submit', function(e) {

                e.preventDefault();

                selectedDeleteForm = this;

                const typeName = this.dataset.typeName || 'this complaint type';

                deleteTypeText.innerText = 'Delete "' + typeName + '" complaint type?';

                deleteTypeModal.show();

            });

        });

        confirmDeleteTypeBtn.addEventListener('click', function() {

            if (selectedDeleteForm) {
                selectedDeleteForm.submit();
            }

        });

    });
</script>

@endsection