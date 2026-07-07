@extends('layouts.app')

@section('title')
Division- PDMT
@endsection

<style>
    .table td,
    .table th {
        font-size: 14px;
    }

    @media (max-width:768px) {

        h2 {
            font-size: 20px;
        }

        .table td,
        .table th {
            font-size: 12px;
            padding: 6px;
        }

        .card-body {
            padding: 10px;
        }

    }
</style>

@section('content')

<div class="container">

    <h2 class="mb-1">Division List</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="counterModal" tabindex="-1">
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

                        {{-- District --}}
                        <div class="mb-3">
                            <label>District</label>
                            <select name="district" id="district" class="form-control" required>
                                <option value="">-- Select District --</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Kilinochchi">Kilinochchi</option>
                                <option value="Mullaitivu">Mullaitivu</option>
                                <option value="Mannar">Mannar</option>
                                <option value="Vavuniya">Vavuniya</option>
                            </select>
                        </div>

                        {{-- DS Division --}}
                        <div class="mb-3">
                            <label>DS Division</label>
                            <select name="division_name" id="division_name" class="form-control" required>
                                <option value="">-- Select DS Division --</option>
                            </select>
                        </div>

                        {{-- Counter --}}
                        <div class="mb-3">
                            <label>Counter Name</label>
                            <input type="text" name="counter_name" id="counter_name" class="form-control" required>
                        </div>

                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </div>
            </form>

        </div>
    </div>


    <button class="btn btn-primary mb-3" id="createCounterBtn">
        Add Counter
    </button>


    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card table-card shadow-sm">

                <div class="card-header table-header d-flex justify-content-between align-items-center">

                    <span>Counter List</span>

                </div>

                <div class="table-responsive">

                    <table class="table dashboard-table mb-0">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>District</th>
                                <th>DS Division</th>
                                <th>Counter</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($counters as $index => $counter)

                            <tr>

                                <td>
                                    {{ ($counters->currentPage() - 1) * $counters->perPage() + $index + 1 }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $counter->district }}
                                </td>

                                <td>
                                    {{ $counter->division_name }}
                                </td>

                                <td>
                                    {{ $counter->counter_name }}
                                </td>

                                <td>

                                    <button class="btn btn-sm btn-primary editBtn"
                                        data-id="{{ $counter->id }}"
                                        data-district="{{ $counter->district }}"
                                        data-division="{{ $counter->division_name }}"
                                        data-counter="{{ $counter->counter_name }}"
                                        title="Edit"
                                        aria-label="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form action="{{ route('counters.destroy',$counter->id) }}" method="POST" class="d-inline deleteCounterForm" data-counter-name="{{ $counter->counter_name }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger"
                                            title="Delete"
                                            aria-label="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    No counters found
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

                <select name="per_page" class="form-control" onchange="this.form.submit()">

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

<div class="modal fade" id="deleteCounterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:44px;height:44px;background:#ffe9ec;color:#c02424;">
                        <i class="bi bi-trash"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Delete Counter</h5>
                    </div>
                </div>

                <div class="bg-light rounded-3 p-3 mb-3">
                    <div id="deleteCounterText" class="fw-semibold">Delete this counter?</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteCounterBtn" class="btn btn-danger px-4">Delete</button>
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

        let modal = new bootstrap.Modal(document.getElementById('counterModal'));

        let form = document.getElementById('counterForm');

        const districtSelect = document.getElementById('district');

        const divisionSelect = document.getElementById('division_name');

        const deleteCounterModal = new bootstrap.Modal(document.getElementById('deleteCounterModal'));

        const deleteCounterText = document.getElementById('deleteCounterText');

        const confirmDeleteCounterBtn = document.getElementById('confirmDeleteCounterBtn');

        let selectedDeleteForm = null;


        /* DS DIVISION DATA */

        const dsDivisions = {

            Jaffna: ["PDMT", "Jaffna", "Nallur", "Thenmaradchi", "Vadamaradchi North", "Vadamaradchi East",
                "Vadamaradchi South-West", "Valikamam East", "Valikamam West", "Karainagar", "Delft",
                "Valikamam South", "Valikamam North", "Valikamam South-West", "Island North", "Island South"
            ],

            Kilinochchi: ["Karachchi", "Poonakary", "Kandavalai", "Pachchilaipalli"],

            Mullaitivu: ["Maritimepattu", "Oddusuddan", "Manthai-East", "Thunukkai", "Puthukudiyiruppu", "Welioya"],

            Mannar: ["Mannar Town", "Madhu", "Manthai-West", "Nanaddan", "Musali"],

            Vavuniya: ["Vavuniya Town", "Vavuniya-North", "Vavuniya-South", "Vengalacheddikulam"]

        };


        /* District change */

        districtSelect.addEventListener('change', function() {

            let district = this.value;

            divisionSelect.innerHTML = '<option value="">-- Select DS Division --</option>';

            if (dsDivisions[district]) {

                dsDivisions[district].forEach(function(division) {

                    let option = document.createElement('option');

                    option.value = division;

                    option.textContent = division;

                    divisionSelect.appendChild(option);

                });

            }

        });


        /* Create */

        document.getElementById('createCounterBtn').addEventListener('click', function() {

            form.action = "{{ route('counters.store') }}";

            document.getElementById('methodField').value = 'POST';

            document.getElementById('modalTitle').innerText = 'Add Counter';

            form.reset();

            divisionSelect.innerHTML = '<option value="">-- Select DS Division --</option>';

            modal.show();

        });


        /* Edit */

        document.querySelectorAll('.editBtn').forEach(function(btn) {

            btn.addEventListener('click', function() {

                let id = btn.dataset.id;

                form.action = '/counters/update/' + id;

                document.getElementById('methodField').value = 'PUT';

                document.getElementById('modalTitle').innerText = 'Edit Counter';

                districtSelect.value = btn.dataset.district;

                districtSelect.dispatchEvent(new Event('change'));

                setTimeout(() => {

                    divisionSelect.value = btn.dataset.division;

                }, 100);

                document.getElementById('counter_name').value = btn.dataset.counter;

                modal.show();

            });

        });

        document.querySelectorAll('.deleteCounterForm').forEach(function(deleteForm) {

            deleteForm.addEventListener('submit', function(e) {

                e.preventDefault();

                selectedDeleteForm = this;

                const counterName = this.dataset.counterName || 'this counter';

                deleteCounterText.innerText = 'Delete "' + counterName + '" counter?';

                deleteCounterModal.show();

            });

        });

        confirmDeleteCounterBtn.addEventListener('click', function() {

            if (selectedDeleteForm) {
                selectedDeleteForm.submit();
            }

        });

    });
</script>

@endsection