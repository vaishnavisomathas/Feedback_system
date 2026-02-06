@extends('layouts.app')

@section('title')
    <title>DS Divisions - PDMT</title>
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">DS Divisions</h2>

    <!-- Search Form -->
    <form method="GET" action="" class="mb-3 row g-2">
        <div class="col-md-4">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search DS Divisions..."
                value="{{ $search ?? '' }}" />
        </div>
        <div class="col-auto">
            <button class="btn btn-primary btn-sm">Search</button>
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



    <!-- Show Generated QR Inline -->
   

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

        {{-- Pagination Links --}}
        <div>
            {{ $counters->links() }}
        </div>
    </div>
</div>
@endsection
