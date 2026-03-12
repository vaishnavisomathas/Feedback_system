@extends('layouts.app')

@section('title')
Service Quality - PDMT
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

        .table th,
        .table td {
            font-size: 12px;
            padding: 6px;
        }

    }
</style>


@section('content')

<div class="container">

    <h3 class="mb-1">Service Quality Management</h3>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    <button class="btn btn-primary mb-3" id="addBtn">
        Add Quality
    </button>


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



    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card table-card shadow-sm">

                <div class="card-header table-header d-flex justify-content-between align-items-center">

                    <span>Service Quality List</span>

                </div>


                <div class="table-responsive">

                    <table class="table dashboard-table mb-0">

                        <thead>

                            <tr>

                                <th>#</th>
                                <th>Name</th>
                                <th width="150">Action</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($qualities as $index => $q)

                            <tr>

                                <td>
                                    {{ ($qualities->currentPage() - 1) * $qualities->perPage() + $index + 1 }}
                                </td>

                                <td>
                                    {{ $q->name }}
                                </td>

                                <td>

                                    <button class="btn btn-primary btn-sm editBtn"
                                        data-id="{{ $q->id }}"
                                        data-name="{{ $q->name }}">
                                        Edit
                                    </button>


                                    <form method="POST"
                                        action="{{ route('service.quality.destroy',$q->id) }}"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this service quality?')">
                                            Delete
                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="3" class="text-center">
                                    No service quality records found
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

@endsection



@section('script')

<script>
    document.addEventListener("DOMContentLoaded", function() {

        let modalElement = document.getElementById('qualityModal');

        let modal = new bootstrap.Modal(modalElement);

        let form = document.getElementById('qualityForm');

        let methodField = document.getElementById('methodField');

        let modalTitle = document.getElementById('modalTitle');

        let nameInput = document.getElementById('name');


        /* ADD */

        document.getElementById('addBtn').addEventListener('click', function() {

            form.action = "{{ route('service.quality.store') }}";

            methodField.value = '';

            modalTitle.innerText = 'Add Service Quality';

            form.reset();

            modal.show();

        });


        /* EDIT */

        document.querySelectorAll('.editBtn').forEach(btn => {

            btn.addEventListener('click', function() {

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