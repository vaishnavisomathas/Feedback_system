@extends('layouts.app')

@section('title')
DS Divisions QR- PDMT
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

        img {
            max-width: 120px;
        }

    }
</style>
@section('content')
<div class="container">
    <h2 class="mb-1">DS Divisions</h2>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-3 row g-2">
        <div class="col-md-3">
            <select name="district" class="form-control select2" onchange="this.form.submit()">
                <option value="">-- All Districts --</option>
                @foreach($districts as $district)
                <option value="{{ $district }}"
                    {{ request('district') == $district ? 'selected' : '' }}>
                    {{ $district }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="counter" class="form-control select2" onchange="this.form.submit()">
                <option value="">-- All Counters --</option>
                @foreach($counterOptions as $counterOption)
                <option value="{{ $counterOption->id }}"
                    {{ ($selectedCounter ?? '') == $counterOption->id ? 'selected' : '' }}>
                    {{ $counterOption->division_name }} – {{ $counterOption->counter_name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto d-flex gap-2">

<a href="{{ url()->current() }}" class="btn btn-sm btn-danger d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-clockwise"></i>
</a>
        </div>
    </form>


    <div class="row mt-4">

        <div class="col-lg-12">

            <div class="card table-card shadow-sm">

                <div class="card-header table-header d-flex justify-content-between align-items-center">

                    <span>DS Divisions Counters</span>

                    <div class="d-flex gap-2">




                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table dashboard-table mb-0">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>District</th>
                                <th>DS Division</th>
                                <th>Counter</th>
                                <th>QR Code</th>
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

                                    <form method="POST" action="{{ route('generateQr') }}">
                                        @csrf
                                        <input type="hidden" name="counter_id" value="{{ $counter->id }}">

                                        <button type="submit" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="bi bi-qr-code"></i> Generate QR
                                        </button>

                                    </form>

                                    @if(session('selectedCounter') && session('selectedCounter')->id === $counter->id)

                                    <img src="{{ session('generatedQr') }}" style="max-width:120px">

                                    <input class="form-control mt-2" readonly value="{{ session('generatedQrUrl') }}">

                                    <a href="{{ route('ds-divisions.downloadQrPdf', $counter->id) }}"
                                        class="btn btn-sm btn-primary mt-2">
                                        <i class="bi bi-download"></i> Download QR PDF
                                    </a>

                                    @endif

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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Search...",
            allowClear: true,
            width: '100%'
        });

        // Reset counter when district changes
        $('select[name="district"]').on('change', function() {
            $('select[name="counter"]').val('').trigger('change');
        });
    });
</script>
@endsection