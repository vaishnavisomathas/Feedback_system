@extends('layouts.app')
@section('title')
Division- PDMT
@endsection
@section('content')
<div class="container">
<h2 class="mb-4">Division List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                            
                            <button class="btn btn-sm btn-primary editBtn"
                                data-id="{{ $counter->id }}"
                                data-district="{{ $counter->district }}"
                                data-division="{{ $counter->division_name }}"
                                data-counter="{{ $counter->counter_name }}">
                                Edit
                            </button>

                            <form action="{{ route('counters.destroy',$counter->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
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

    let modal = new bootstrap.Modal(document.getElementById('counterModal'));
    let form = document.getElementById('counterForm');
    const districtSelect = document.getElementById('district');
    const divisionSelect = document.getElementById('division_name');

    /* ================= DS DIVISION DATA ================= */
    const dsDivisions = {

        Jaffna: ["PDMT",
            "Jaffna","Nallur","Thenmaradchi","Vadamaradchi North","Vadamaradchi East",
            "Vadamaradchi South-West","Valikamam East","Valikamam West","Karainagar","Delft",
            "Valikamam South","Valikamam North","Valikamam South-West","Island North","Island South"
        ],

        Kilinochchi: ["Karachchi","Poonakary","Kandavalai","Pachchilaipalli"],

        Mullaitivu: ["Maritimepattu","Oddusuddan","Manthai-East","Thunukkai","Puthukudiyiruppu","Welioya"],

        Mannar: ["Mannar Town","Madhu","Manthai-West","Nanaddan","Musali"],

        Vavuniya: ["Vavuniya Town","Vavuniya-North","Vavuniya-South","Vengalacheddikulam"]
    };

    /* ========= DISTRICT CHANGE ========= */
    districtSelect.addEventListener('change', function () {

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

    /* ========= CREATE ========= */
    document.getElementById('createCounterBtn').addEventListener('click', function() {
        form.action = "{{ route('counters.store') }}";
        document.getElementById('methodField').value = 'POST';
        document.getElementById('modalTitle').innerText = 'Add Counter';
        form.reset();
        divisionSelect.innerHTML = '<option value="">-- Select DS Division --</option>';
        modal.show();
    });

    /* ========= EDIT ========= */
    document.querySelectorAll('.editBtn').forEach(function(btn) {

        btn.addEventListener('click', function() {

            let id = btn.dataset.id;
      form.action = '/counters/update/' + id;
document.getElementById('methodField').value = 'PUT';

            document.getElementById('modalTitle').innerText = 'Edit Counter';

            districtSelect.value = btn.dataset.district;

            // Load DS divisions
            districtSelect.dispatchEvent(new Event('change'));

            setTimeout(() => {
                divisionSelect.value = btn.dataset.division;
            }, 100);

            document.getElementById('counter_name').value = btn.dataset.counter;

            modal.show();
        });
    });

});
</script>
@endsection
