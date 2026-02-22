@extends('layouts.app')

@section('title')
    DS Divisions QR- PDMT
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">DS Divisions</h2>

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
      
        <a href="{{ url()->current() }}" class="btn btn-danger btn-sm">
            <i class="bi bi-arrow-clockwise me-1"></i>
        </a>
    </div>
    </form>

    <!-- Counters Table -->
    <div class="py-4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>District</th>
                    <th>DS Division</th>
                    <th>Counter</th>
                    <th>QR</th>
                </tr>
            </thead>
            <tbody>
                @forelse($counters as $index => $counter)
                <tr>
                    <td>{{ ($counters->currentPage() - 1) * $counters->perPage() + $index + 1 }}</td>
                    <td>{{ $counter->district }}</td>
                    <td>{{ $counter->division_name }}</td>
                    <td>{{ $counter->counter_name }}</td>
                   <td>
    <!-- Generate QR Form -->
   
<form method="POST" action="{{ route('generateQr') }}">
    @csrf
    <input type="hidden" name="counter_id" value="{{ $counter->id }}">
    <button type="submit" class="btn btn-sm btn-outline-primary mb-2">
Generate QR
    </button>
</form>
   @if(session('selectedCounter') && session('selectedCounter')->id === $counter->id)
    <img src="{{ session('generatedQr') }}" style="max-width:150px">
    <input class="form-control mt-2" readonly value="{{ session('generatedQrUrl') }}">

            {{-- DOWNLOAD --}}
           <a href="{{ route('ds-divisions.downloadQrPdf', $counter->id) }}" 
   class="btn btn-sm btn-primary mb-1">
   Download QR PDF
</a>


    @endif
</td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No counters found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

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
