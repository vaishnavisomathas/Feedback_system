@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header">
            <h4>User Details</h4>
        </div>

        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Name:</strong>
                    <p>{{ $user->name }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Date of Birth:</strong>
                    <p>{{ $user->dob }}</p>
                </div>

                <div class="col-md-6">
                    <strong>NIC Number:</strong>
                    <p>{{ $user->nic_number }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Role:</strong>
                    <p>{{ ucfirst($user->role) }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Email:</strong>
                    <p>{{ $user->email }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Phone:</strong>
                    <p>{{ $user->phone }}</p>
                </div>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Back
            </a>

        </div>
    </div>

</div>
@endsection
