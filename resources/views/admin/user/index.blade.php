@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create / Edit Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="userForm">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row">

                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>NIC Number</label>
                            <input type="text" name="nic_number" id="nic_number" class="form-control" required>
                        </div>

<div class="col-md-6 mb-3">
    <label>Role</label>
    <select name="role" id="role" class="form-control" required>
        <option value="" disabled selected>Select a role</option>
        @foreach($roles as $r)
            <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
        @endforeach
    </select>
</div>


                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
<div class="col-md-6 mb-3">
    <label>Password</label>
    <input type="password" name="password" id="password" class="form-control" 
           placeholder="Enter password">
</div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Button -->
    <button class="btn btn-primary mb-3" id="createUserBtn">Add User</button>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <h5>User List</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>DOB</th>
                        <th>NIC</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->dob }}</td>
                            <td>{{ $user->nic_number }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary editBtn"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-dob="{{ $user->dob }}"
                                    data-nic="{{ $user->nic_number }}"
                                    data-role="{{ $user->role }}"
                                    data-email="{{ $user->email }}"
                                    data-phone="{{ $user->phone }}">
                                    Edit
                                </button>

                                <form action="{{ route('users.destroy', $user->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
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

    // Create
    document.getElementById('createUserBtn').addEventListener('click', function () {
        form.action = "{{ route('users.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('modalTitle').innerText = 'Add User';
        form.reset();
        modal.show();
    });

    // Edit
    document.querySelectorAll('.editBtn').forEach(function (btn) {
        btn.addEventListener('click', function () {

            let id = btn.dataset.id;
form.action = '/users/' + id;
            document.getElementById('methodField').value = 'PUT';

            document.getElementById('modalTitle').innerText = 'Edit User';

            document.getElementById('name').value = btn.dataset.name;
            document.getElementById('dob').value = btn.dataset.dob;
            document.getElementById('nic_number').value = btn.dataset.nic;
            document.getElementById('role').value = btn.dataset.role;
            document.getElementById('email').value = btn.dataset.email;
            document.getElementById('phone').value = btn.dataset.phone;

            modal.show();
        });
    });

});
</script>
@endsection
