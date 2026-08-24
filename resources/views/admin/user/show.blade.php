@extends('layouts.app')

@section('content')
<style>

@media (max-width:768px){

h4{
font-size:20px;
}

.user-label{
font-size:13px;
font-weight:600;
}

.user-value{
font-size:14px;
}

}

</style>
<div class="container">

    <div class="card">
        <div class="card-header">
            <h4>User Details</h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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

            @php
                $currentUser = auth()->user();
                $isSuperAdmin = $currentUser && (strtolower(trim((string) ($currentUser->role ?? ''))) === 'super admin' || (method_exists($currentUser, 'isSuperAdmin') && $currentUser->isSuperAdmin()));
                $isOwnProfile = (int) auth()->id() === (int) $user->id;
                $canChangePassword = $isOwnProfile || $isSuperAdmin;
            @endphp

            @if($canChangePassword)
                <hr>
                <h5 class="mb-3">{{ $isOwnProfile ? 'Change Password' : 'Reset User Password' }}</h5>

                <form method="POST" action="{{ route('users.change-password', $user->id) }}" class="row g-3 mb-3">
                    @csrf
                    @if($isOwnProfile)
                        <div class="col-md-6">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input
                                type="password"
                                id="current_password"
                                name="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                required
                            >
                        </div>
                    @endif

                    <div class="col-md-6">
                        <label for="password" class="form-label">New Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            value="{{ $isOwnProfile ? '' : ($nextPassword ?? 'pdmt@001') }}"
                            {{ $isOwnProfile ? 'required' : '' }}
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            value="{{ $isOwnProfile ? '' : ($nextPassword ?? 'pdmt@001') }}"
                            {{ $isOwnProfile ? 'required' : '' }}
                        >
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">{{ $isOwnProfile ? 'Update Password' : 'Reset Password' }}</button>
                    </div>
                </form>
            @endif

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Back
            </a>

        </div>
    </div>

</div>
@endsection
