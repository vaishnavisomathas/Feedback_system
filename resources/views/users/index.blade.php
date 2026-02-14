@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="userForm">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control">
                            <small class="text-muted">Leave blank when editing</small>
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

    <button class="btn btn-primary mb-3" id="createUserBtn">Add User</button>

    <div class="card">
        <div class="card-body">
            <h5>User List</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>

                            <button class="btn btn-sm btn-primary editBtn"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}">
                                Edit
                            </button>

                            <form action="{{ route('users.destroy',$user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this user?')">
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

    let modal = new bootstrap.Modal(document.getElementById('userModal'));
    let form = document.getElementById('userForm');

    // CREATE
    document.getElementById('createUserBtn').addEventListener('click', function() {
        form.action = "{{ route('users.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('modalTitle').innerText = 'Add User';
        form.reset();
        modal.show();
    });

    // EDIT
    document.querySelectorAll('.editBtn').forEach(function(btn) {
        btn.addEventListener('click', function() {

            let id = btn.dataset.id;

            form.action = '/users/' + id;
            document.getElementById('methodField').value = 'PUT';

            document.getElementById('modalTitle').innerText = 'Edit User';
            document.getElementById('name').value = btn.dataset.name;
            document.getElementById('email').value = btn.dataset.email;
            document.getElementById('password').value = '';

            modal.show();
        });
    });

});
</script>
@endsection
