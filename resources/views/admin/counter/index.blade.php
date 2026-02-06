@extends('layouts.app')

@section('content')
<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Create / Edit Modal -->
    <div class="modal fade" id="counterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="counterForm">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Counter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label>District</label>
                            <input type="text" name="district" id="district" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>DS Division</label>
                            <input type="text" name="division_name" id="division_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Counter Name</label>
                            <input type="text" name="counter_name" id="counter_name" class="form-control" required>
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

    <!-- Button trigger modal -->
    <button class="btn btn-primary mb-3" id="createCounterBtn">Add Counter</button>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <h5>Counter List</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>District</th>
                        <th>DS Division</th>
                        <th>Counter</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($counters as $counter)
                        <tr>
                            <td>{{ $counter->district }}</td>
                            <td>{{ $counter->division_name }}</td>
                            <td>{{ $counter->counter_name }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary editBtn" data-id="{{ $counter->id }}"
                                    data-district="{{ $counter->district }}"
                                    data-division="{{ $counter->division_name }}"
                                    data-counter="{{ $counter->counter_name }}">
                                    Edit
                                </button>

                                <form action="{{ route('counters.destroy', $counter->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
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
    let modal = new bootstrap.Modal(document.getElementById('counterModal'));
    let form = document.getElementById('counterForm');

    document.getElementById('createCounterBtn').addEventListener('click', function() {
        form.action = "{{ route('counters.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('modalTitle').innerText = 'Add Counter';
        form.reset();
        modal.show();
    });

    document.querySelectorAll('.editBtn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            let id = btn.dataset.id;
            form.action = '/counters/' + id;
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('modalTitle').innerText = 'Edit Counter';
            document.getElementById('district').value = btn.dataset.district;
            document.getElementById('division_name').value = btn.dataset.division;
            document.getElementById('counter_name').value = btn.dataset.counter;
            modal.show();
        });
    });
});
</script>
@endsection
