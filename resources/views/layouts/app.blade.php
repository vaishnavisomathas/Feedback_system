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
<img src="assets/images/logos/rural-clms-logo.png" 
                 alt="" 
                height="40" width="10">        </a>

        
      </div>

      <div class="d-lg-flex align-items-center gap-2">
        <h3 class="text-white mb-2 mb-lg-0 fs-5 text-center"></h3>
        <div class="d-flex align-items-center justify-content-center gap-2">
          
          <div class="dropdown d-flex">
    
          </div>
        </div>
      </div>

    </div>
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
<img src="{{ asset('assets/images/logos/Rural_Area_CLMS.png') }}" alt="" width="200" height="60" />
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
            <li class="sidebar-item">
              <a class="sidebar-link"  href="{{ route('dashboard') }}" aria-expanded="false">
                <i class="ti ti-atom"></i>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
            

        

                 <li>
              <span class="sidebar-divider lg"></span>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Ds Divisions</span>
            </li>
                <li class="sidebar-item">
                  <a class="sidebar-link justify-content-between"  
     href="{{ route('counters.index') }}">
                         <div class="d-flex align-items-center gap-3">
                      <div class="round-16 d-flex align-items-center justify-content-center">
                        <i class="ti ti-circle"></i>
                      </div>
                      <span class="hide-menu">Division List</span>
                    </div>
                    
                  </a>
                </li> 
           
              
  <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Ds Divisions Qr</span>
            </li>
           
 <li class="sidebar-item">
    <a class="sidebar-link justify-content-between"  
     href="{{ route('ds-divisions.index') }}" aria-expanded="false">
        <div class="d-flex align-items-center gap-3">
            <span class="d-flex">
                <i class="ti ti-aperture"></i>
            </span>
            <span class="hide-menu">Division QR</span>
        </div>
    </a>
</li>
 
 <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Feedback</span>
            </li>
          
 <li class="sidebar-item">
    <a class="sidebar-link justify-content-between"  
    href="{{ route('admin.feedback.index') }}" aria-expanded="false">
        <div class="d-flex align-items-center gap-3">
            <span class="d-flex">
                <i class="ti ti-aperture"></i>
            </span>
            <span class="hide-menu">Feedback</span>
        </div>
    </a>
 <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Complaint</span>
            </li>
          
 <li class="sidebar-item">
    <a class="sidebar-link justify-content-between"  
    href="{{ route('admin.complain.index') }}" aria-expanded="false">
        <div class="d-flex align-items-center gap-3">
            <span class="d-flex">
                <i class="ti ti-aperture"></i>
            </span>
            <span class="hide-menu">Complain</span>
        </div>
    </a>
</li>
 <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">A/O</span>
            </li>
          
<li class="sidebar-item {{ request()->routeIs('complain.types.*') ? 'active' : '' }}">
    <a href="{{ route('admin.ao.index') }}" class="sidebar-link">
        <span class="d-flex">
        <i class="ti ti-user-shield"></i>
        </span>
        <span class="hide-menu">Complaiant</span>
    </a>
</li>
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

<li class="nav-small-cap">
    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
    <span class="hide-menu">User Management</span>
</li>

<li class="sidebar-item">
    <a class="sidebar-link justify-content-between"  
        href="{{ route('users.index') }}" aria-expanded="false">
        <div class="d-flex align-items-center gap-3">
            <span class="d-flex">
                <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Users</span>
        </div>
    </a>
</li>
    
<li class="nav-small-cap">
    <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
    <span class="hide-menu">Settings</span>
</li>

{{-- RBAC DROPDOWN --}}
<li class="sidebar-item">



        {{-- Roles --}}
        <li class="sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <a href="{{ route('roles.index') }}" class="sidebar-link">
                <span class="d-flex">
                    <i class="ti ti-category"></i>
                </span>
                <span class="hide-menu">Roles</span>
            </a>
        </li>

        {{-- Permission Groups --}}
        <li class="sidebar-item {{ request()->routeIs('permission-groups.*') ? 'active' : '' }}">
            <a href="{{ route('permission-groups.index') }}" class="sidebar-link">
                <span class="d-flex">
                    <i class="ti ti-category"></i>
                </span>
                <span class="hide-menu">Permission Groups</span>
            </a>
        </li>

        {{-- Permissions --}}
        <li class="sidebar-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
            <a href="{{ route('permissions.index') }}" class="sidebar-link">
                <span class="d-flex">
                    <i class="ti ti-key"></i>
                </span>
                <span class="hide-menu">Permissions</span>
            </a>
        </li>
 
</li>
<li class="sidebar-item {{ request()->routeIs('complain.types.*') ? 'active' : '' }}">
    <a href="{{ route('complain.types.index') }}" class="sidebar-link">
        <span class="d-flex">
            <i class="ti ti-list"></i>
        </span>
        <span class="hide-menu">Complain Type</span>
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


        </ul>
    </div>
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
         <ul class="navbar-nav align-items-center">

    <!-- Mobile Sidebar Toggle -->
    <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler" id="headerCollapse" href="#">
            <i class="ti ti-menu-2"></i>
        </a>
    </li>

    <!-- Notification -->
    <li class="nav-item dropdown">

        <a class="nav-link position-relative" href="#" id="notificationDropdown"
           role="button" data-bs-toggle="dropdown" aria-expanded="false">

            <i class="ti ti-bell fs-5"></i>

            <!-- badge -->
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                2
            </span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="notificationDropdown" style="min-width:260px">

            <li class="dropdown-header fw-bold">Notifications</li>
            <li><hr class="dropdown-divider"></li>

            <li>
                <a class="dropdown-item" href="#">
                    New Complaint Received
                </a>
            </li>

            <li>
                <a class="dropdown-item" href="#">
                    Feedback Submitted
                </a>
            </li>

            <li><hr class="dropdown-divider"></li>

            <li class="text-center">
                <a class="dropdown-item text-primary" href="#">View All</a>
            </li>

        </ul>
    </li>

</ul>

<nav class="navbar navbar-expand-lg navbar-light w-100">

    <div class="container-fluid">

        <!-- LEFT: sidebar toggle (optional) -->
        <div class="d-flex align-items-center">
            <a class="nav-link sidebartoggler d-xl-none" id="headerCollapse" href="#">
                <i class="ti ti-menu-2"></i>
            </a>
        </div>

        <!-- RIGHT: notification + user -->
        <div class="ms-auto d-flex align-items-center gap-3">

            <!-- 🔔 Notification -->
            <div class="dropdown">
                <a class="nav-link position-relative" href="#" id="notificationDropdown" data-bs-toggle="dropdown">
                    <i class="ti ti-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        2
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li class="dropdown-header">Notifications</li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item">New Complaint Received</a></li>
                    <li><a class="dropdown-item">Feedback Submitted</a></li>
                </ul>
            </div>

            <!-- 👤 User -->
            <div class="dropdown">
                <a class="nav-link p-0" href="#" id="userDropdown" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                         class="rounded-circle border" width="35" height="35">
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li class="px-3 py-2">
                        <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li class="px-3 py-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger btn-sm w-100">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>

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
