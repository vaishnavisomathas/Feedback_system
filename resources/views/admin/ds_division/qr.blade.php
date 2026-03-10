@extends('layouts.app')

@section('title')
<title>{{ $counter->division_name }} - QR</title>
@endsection
<style>

.qr-box svg{
max-width:200px;
height:auto;
}

@media (max-width:768px){

h3{
font-size:20px;
}

.qr-box svg{
max-width:150px;
}

}

</style>
@section('content')
<div class="container text-center mt-4">

    <h3>{{ $counter->division_name }}</h3>
    <p>Counter: {{ $counter->counter_name }}</p>

    <div class="mb-3">
        {{-- QR Image --}}
        {!! $generatedQr !!}
    </div>

    <div class="mb-2">
        <strong>QR URL:</strong>
        <input type="text" class="form-control text-center" readonly value="{{ $url }}" onclick="this.select()">
    </div>

    <a href="{{ route('ds-divisions.downloadQr', $counter->id) }}" class="btn btn-primary mt-2">
        Download QR as PDF
    </a>
</div>
@endsection
