<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard')</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/pdmt_logo.png') }}">
  <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">

 <style>
body {
  margin:0;
  background:#f6f8fb;
  font-family: 'Segoe UI', sans-serif;
}

/* =========================
   SIDEBAR (CLEAN WHITE)
========================= */
.left-sidebar {
  width:270px;
  position:fixed;
  top:0;
  left:0;
  height:100vh;
  background:#ffffff;
  border-right:1px solid #e5e7eb;
  z-index:1000;
}

/* LOGO */
.brand-logos {
    top: 40px;;
}

/* SCROLL */
.scroll-sidebars {
  height:calc(100vh - 80px);
  overflow-y:auto;
  padding:5px;
}

/* SECTION TITLE */
.nav-small-cap {
  font-size:11px;
  color:#6b7280;
  padding:12px 15px 5px;
  text-transform:uppercase;
  font-weight:700;
  letter-spacing:0.5px;
}

/* MENU ITEM */
.sidebar-item {
  margin:4px 0;
}

/* LINK STYLE */
.sidebar-link {
  display:flex;
  align-items:center;
  gap:12px;
  padding:10px 15px;
  color:#111827 !important;
  text-decoration:none;
  border-radius:10px;
  font-size:14px;
  transition:all 0.2s ease;
}

/* ICON */
.sidebar-link i {
  font-size:18px;
  color:#374151;
}

/* HOVER */
.sidebar-link:hover {
  background:#f3f4f6;
  transform:translateX(3px);
}

/* ACTIVE */
.sidebar-item.active .sidebar-link {
  background:#0d6efd;
  color:#fff !important;
  box-shadow:0 4px 10px rgba(13,110,253,0.2);
}

.sidebar-item.active .sidebar-link i {
  color:#fff;
}

/* =========================
   HEADER
========================= */
.app-headers {
  position:fixed;
  top:0;
  left:270px;
  width:calc(100% - 270px);
  height:60px;
  background:#ffffff;
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:0 20px;
  z-index:999;
}

/* =========================
   BODY
========================= */
.body-wrapper {
  margin-left:270px;
  padding-top:60px;
}

.container-fluids {
  padding: 50px 15px;
}
/* Badge */
.notif-badge {
    position: absolute;
    top: 1px;
    right: 0px;
    font-size: 10px;
    padding: 4px 6px;
}

/* Dropdown */
.notif-dropdown {
    width: 320px;
    border-radius: 12px;
    overflow: hidden;
    border: none;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* Header */
.notif-header {
    padding: 12px;
    font-weight: 600;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
}

/* Body */
.notif-body {
    max-height: 350px;
    overflow-y: auto;
}

/* Item */
.notif-item {
    display: flex;
    gap: 10px;
    padding: 12px;
    border-bottom: 1px solid #eee;
    transition: 0.2s;
}

.notif-item:hover {
    background: #f5f5f5;
}

/* Icon */
.notif-icon {
    background: #0d6efd;
    color: #fff;
    padding: 8px;
    border-radius: 50%;
    font-size: 14px;
}

/* Content */
.notif-text {
    font-size: 13px;
    font-weight: 500;
}

/* Footer */
.notif-footer {
    text-align: center;
    padding: 10px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
}
@media (max-width: 576px) {
  .container-fluid {
    padding: 5px;
  }
}

/* =========================
   MOBILE
========================= */
@media (max-width:1199px) {

  .left-sidebar {
    left:-270px;
  }

  #main-wrapper.show-sidebar .left-sidebar {
    left:0;
  }

  .app-headers {
    left:0;
    width:100%;
  }

  .body-wrapper {
    margin-left:0;
  }
}
</style>
</head>

<body>

<div id="main-wrapper">

  <!-- SIDEBAR -->
  <aside class="left-sidebar">

  <!-- LOGO -->
  <div class="brand-logos">
    <img src="{{ asset('assets/images/npc_logo.png') }}" width="60">
  </div>

  <nav class="scroll-sidebars">
    <ul>

      <!-- HOME -->
      <li class="nav-small-cap">
        <span>Home</span>
      </li>

      <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('dashboard') }}">
          <i class="ti ti-home"></i>
          <span>Dashboard</span>
        </a>
      </li>
 @auth
        @php $role = auth()->user()->role; @endphp

      <!-- DS DIVISIONS -->
                     @if($role != 'Administrative Officer' && $role != 'User')

      <li class="nav-small-cap">
        <span>DS Divisions</span>
      </li>

      <li class="sidebar-item {{ request()->routeIs('counters.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('counters.index') }}">
          <i class="ti ti-list"></i>
          <span>Division List</span>
        </a>
      </li>
@endif
      <!-- QR -->
      <li class="nav-small-cap">
        <span>DS Division QR</span>
      </li>

      <li class="sidebar-item {{ request()->routeIs('ds-divisions.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('ds-divisions.index') }}">
          <i class="ti ti-qrcode"></i>
          <span>Division QR</span>
        </a>
      </li>

      <!-- FEEDBACK -->
      <li class="nav-small-cap">
        <span>Feedback</span>
      </li>

      <li class="sidebar-item {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('admin.feedback.index') }}">
          <i class="ti ti-message-dots"></i>
          <span>Feedback</span>
        </a>
      </li>

     
        <!-- COMPLAINT -->
        @if($role != 'Commissioner' && $role != 'Administrative Officer')
          <li class="nav-small-cap">
            <span>Complaint</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('admin.complain.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.complain.index') }}">
              <i class="ti ti-alert-circle"></i>
              <span>Complaint List</span>
            </a>
          </li>
        @endif

        <!-- AO -->
              @if($role != 'Commissioner' && $role != 'User')
          <li class="nav-small-cap">
            <span>A/O</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('admin.ao.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.ao.index') }}">
              <i class="ti ti-shield"></i>
              <span>A/O Management</span>
            </a>
          </li>
        @endif

        <!-- COMMISSIONER -->
              @if($role != 'Administrative Officer' && $role != 'User')
          <li class="nav-small-cap">
            <span>Commissioner</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('admin.commissioner.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.commissioner.index') }}">
              <i class="ti ti-crown"></i>
              <span>Commissioner</span>
            </a>
          </li>
        @endif

        <!-- USER MANAGEMENT -->
              @if($role != 'Administrative Officer' && $role != 'User')
          <li class="nav-small-cap">
            <span>User Management</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('users.index') }}">
              <i class="ti ti-users"></i>
              <span>Users</span>
            </a>
          </li>

             

   <!-- SETTINGS -->
          <li class="nav-small-cap">
            <span>Settings</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('complain.types.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('complain.types.index') }}">
              <i class="ti ti-list"></i>
              <span>Complaint Type</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('service.quality.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('service.quality.index') }}">
              <i class="ti ti-stars"></i>
              <span>Service Quality</span>
            </a>
          </li>
          @endif
 @if($role != 'Administrative Officer' && $role != 'User' && $role != 'Commissioner')
          <li class="sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('roles.index') }}">
              <i class="ti ti-category"></i>
              <span>Roles</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('permission-groups.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('permission-groups.index') }}">
              <i class="ti ti-category"></i>
              <span>Permission Groups</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('permissions.index') }}">
              <i class="ti ti-key"></i>
              <span>Permissions</span>
            </a>
          </li>
        @endif

      @endauth

    </ul>
  </nav>

</aside>
  <!-- HEADER -->
  <header class="app-headers">

    <!-- MOBILE MENU -->
    <button id="menuBtn" class="btn btn-light d-xl-none">
      ☰
    </button>

    <!-- TITLE -->
    <div class="fw-semibold">
                <span>Welcome to {{ auth()->user()->name }} Dashboard!</span>                      
    </div>

    <!-- RIGHT -->
   <!-- RIGHT -->
<div class="d-flex align-items-center gap-3">

  <!-- 🔔 NOTIFICATION -->
  <div class="dropdown">
    <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown">
      <i class="ti ti-bell fs-8"></i>

      @if($notificationCount > 0)
        <span class="badge bg-danger rounded-pill notif-badge">
          {{ $notificationCount }}
        </span>
      @endif
    </a>

    <div class="dropdown-menu dropdown-menu-end notif-dropdown">

      <!-- HEADER -->
      <div class="notif-header">
        🔔 Notifications
      </div>

      <!-- LIST -->
      <div class="notif-body">
        @forelse($notificationList as $item)
          <div class="notif-item">
            <div class="notif-icon">
              <i class="ti ti-message"></i>
            </div>

            <div class="notif-content">
              <div class="notif-text">
                {{ \Illuminate\Support\Str::limit($item->note, 60) }}
              </div>
              <small class="text-muted">
                {{ $item->created_at->diffForHumans() }}
              </small>
            </div>
          </div>
        @empty
          <div class="text-center p-4 text-muted">
            <i class="ti ti-bell-off fs-3 d-block mb-2"></i>
            No Notifications
          </div>
        @endforelse
      </div>

      <!-- FOOTER -->
      <div class="notif-footer">
        <a href="#" class="text-primary">View All</a>
      </div>

    </div>
  </div>

  <!-- 👤 PROFILE / LOGOUT -->
  <div class="dropdown">
    <a href="#" data-bs-toggle="dropdown">
      <img src="{{ asset('assets/images/pdmt_logo.png') }}" width="35" class="rounded-circle">
    </a>

    <div class="dropdown-menu dropdown-menu-end">
      <a class="dropdown-item fw-semibold">
        {{ auth()->user()->name }}
      </a>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="dropdown-item text-danger">Logout</button>
      </form>
    </div>
  </div>

</div>


  </header>

  <!-- CONTENT -->
  <div class="body-wrapper">
    <div class="container-fluids">

      @yield('content')

      <div class="text-center mt-4">
        © {{ date('Y') }} Northern Provincial Department of Motor Traffic
      </div>

    </div>
  </div>

</div>

<!-- JS -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

<script>
document.getElementById('menuBtn').addEventListener('click', function () {
  document.getElementById('main-wrapper').classList.toggle('show-sidebar');
});
</script>

@yield('script')

</body>
</html>