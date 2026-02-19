<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
   @yield('title')
  <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
<link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    <div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
        <a class="d-flex justify-content-center" href="#">
          <img src="assets/images/npc_logo.png" alt="" width="60" height="40">
        </a>

        
      </div>



    </div>
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
            <img src="assets/images/pdmt_logo.png" alt=""  width="60" height="60">
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Home</span>
            </li>
               <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('dashboard') }}">
            <span class="d-flex">
                <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
        </a>
    </li>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
            <li class="nav-small-cap">
        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
        <span class="hide-menu">DS Divisions</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('counters.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('counters.index') }}">
            <span class="d-flex">
                <i class="ti ti-list"></i>
            </span>
            <span class="hide-menu">Division List</span>
        </a>
    </li>

             <li class="nav-small-cap">
        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
        <span class="hide-menu">DS Division QR</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('ds-divisions.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('ds-divisions.index') }}">
            <span class="d-flex">
                <i class="ti ti-qrcode"></i>
            </span>
            <span class="hide-menu">Division QR</span>
        </a>
    </li>
              <li class="nav-small-cap">
        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
        <span class="hide-menu">Feedback</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('admin.feedback.index') }}">
            <span class="d-flex">
                <i class="ti ti-message-dots"></i>
            </span>
            <span class="hide-menu">Feedback</span>
        </a>
    </li>
    @auth
    @php
    $role = auth()->user()->role; // single role string
@endphp
@if($role != 'Commissioner' && $role != 'Administrative Officer')
           <li class="nav-small-cap">
        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
        <span class="hide-menu">Complaint</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('admin.complain.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('admin.complain.index') }}">
            <span class="d-flex">
                <i class="ti ti-alert-circle"></i>
            </span>
            <span class="hide-menu">Complaint List</span>
        </a>
    </li>

@endif
            @if($role != 'Commissioner' && $role != 'User1')
        <li class="nav-small-cap">
        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
        <span class="hide-menu">A/O</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('admin.ao.*') ? 'active' : '' }}">
        <a href="{{ route('admin.ao.index') }}" class="sidebar-link">
            <span class="d-flex">
                <i class="ti ti-shield"></i>
            </span>
            <span class="hide-menu">A/O Management</span>
        </a>
    </li>
@endif
<!-- Commissioner -->
@if($role != 'Administrative Officer' && $role != 'User1')
           <li class="nav-small-cap">
        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
        <span class="hide-menu">Commissioner</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('admin.commissioner.*') ? 'active' : '' }}">
        <a href="{{ route('admin.commissioner.index') }}" class="sidebar-link">
            <span class="d-flex">
                <i class="ti ti-crown"></i>
            </span>
            <span class="hide-menu">Commissioner</span>
        </a>
    </li>
    @endif
    @if($role != 'Administrative Officer' && $role != 'User1')
           <li class="nav-small-cap">
        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
        <span class="hide-menu">User Management</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('users.index') }}">
            <span class="d-flex">
                <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Users</span>
        </a>
    </li>


    {{-- ================= SETTINGS ================= --}}
    <li class="nav-small-cap">
        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
        <span class="hide-menu">Settings</span>
    </li>

    <li class="sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
        <a href="{{ route('roles.index') }}" class="sidebar-link">
            <span class="d-flex">
                <i class="ti ti-category"></i>
            </span>
            <span class="hide-menu">Roles</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->routeIs('permission-groups.*') ? 'active' : '' }}">
        <a href="{{ route('permission-groups.index') }}" class="sidebar-link">
            <span class="d-flex">
                <i class="ti ti-category"></i>
            </span>
            <span class="hide-menu">Permission Groups</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
        <a href="{{ route('permissions.index') }}" class="sidebar-link">
            <span class="d-flex">
                <i class="ti ti-key"></i>
            </span>
            <span class="hide-menu">Permissions</span>
        </a>
    </li>

    <li class="sidebar-item {{ request()->routeIs('service.quality.*') ? 'active' : '' }}">
        <a href="{{ route('service.quality.index') }}" class="sidebar-link">
            <span class="d-flex">
                <i class="ti ti-stars"></i>
            </span>
            <span class="hide-menu">Service Quality</span>
        </a>
    </li>
    <li class="sidebar-item {{ request()->routeIs('complain.types.*') ? 'active' : '' }}">
        <a href="{{ route('complain.types.index') }}" class="sidebar-link">
            <span class="d-flex">
                <i class="ti ti-list"></i>
            </span>
            <span class="hide-menu">Complaint Type</span>
        </a>
    </li>
    @endif
    @endauth
</ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">

        <i class="ti ti-bell"></i>

        @if($notificationCount > 0)
            <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $notificationCount }}
            </span>
        @endif

    </a>

              <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">

        <div class="message-body">

            @if(auth()->user()->role == 'Commissioner')
                <a href="{{ route('admin.commissioner.index') }}" class="dropdown-item">
                    Commissioner Complaints ({{ $notificationCount }})
                </a>

            @elseif(auth()->user()->role == 'Administrative Officer')
                <a href="{{ route('admin.ao.index') }}" class="dropdown-item">
                    AO Complaints ({{ $notificationCount }})
                </a>

            @else
                <a href="{{ route('admin.complain.index') }}" class="dropdown-item">
                    Pending Complaints ({{ $notificationCount }})
                </a>
            @endif

        </div>

    </div>
</li>

          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
               
              <li class="nav-item dropdown">
                <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="./assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <a href="{{ route('users.show', auth()->user()->id) }}"    class="d-flex align-items-center gap-2 dropdown-item text-decoration-none text-dark">

  <p class="mb-0 fs-3">{{ auth()->user()->name }}</p>                    </a>
                 

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn btn-danger btn-sm w-100">
        Logout
    </button>                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <!--  Row 1 -->
     @yield('content')
      <div class="py-6 px-6 text-center">
    <p class="mb-0 fs-4">
        &copy; {{ date('Y') }} Northern Provincial Department of Motor Traffic.
    </p>
</div>

        </div>
      </div>
    </div>
  </div>
  @yield('script')
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>