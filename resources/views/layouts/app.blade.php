<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard')</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/pdmt_logo.png') }}">
  <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <script>
    (function() {
      const savedTheme = localStorage.getItem('app_theme') || 'light';
      document.documentElement.setAttribute('data-bs-theme', savedTheme);
    })();
  </script>

  <style>
    body {
      margin: 0;
      background: #f6f8fb;
      font-family: 'Segoe UI', sans-serif;
      transition: background-color 0.25s ease, color 0.25s ease;
    }

    /* =========================
       DARK THEME STYLES
    ========================= */
    [data-bs-theme="dark"] body {
      background: #0f172a !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .left-sidebar {
      background: #1e293b !important;
      border-right: 1px solid #334155 !important;
    }

    [data-bs-theme="dark"] .sidebar-title {
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .nav-small-cap {
      color: #94a3b8 !important;
    }

    [data-bs-theme="dark"] .sidebar-link {
      color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .sidebar-link i {
      color: #94a3b8 !important;
    }

    [data-bs-theme="dark"] .sidebar-link:hover {
      background: #334155 !important;
      color: #ffffff !important;
    }

    [data-bs-theme="dark"] .sidebar-item.active .sidebar-link {
      background: #2563eb !important;
      color: #ffffff !important;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35) !important;
    }

    [data-bs-theme="dark"] .app-headers {
      background: #1e293b !important;
      border-bottom: 1px solid #334155 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .card,
    [data-bs-theme="dark"] .table-card {
      background-color: #1e293b !important;
      border: 1px solid #334155 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .card-header,
    [data-bs-theme="dark"] .table-header {
      background-color: #1e293b !important;
      border-bottom: 1px solid #334155 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .table {
      color: #e2e8f0 !important;
      border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .table th,
    [data-bs-theme="dark"] .table td {
      border-color: #334155 !important;
      color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .table-hover tbody tr:hover {
      background-color: #27354a !important;
    }

    [data-bs-theme="dark"] .dashboard-table {
      background-color: #1e293b !important;
    }

    [data-bs-theme="dark"] .dashboard-table tbody tr {
      border-bottom: 1px solid #334155 !important;
    }

    [data-bs-theme="dark"] .dashboard-table tbody tr:hover {
      background: #27354a !important;
    }

    [data-bs-theme="dark"] .dashboard-table thead {
      background: #1e3a8a !important;
      color: #ffffff !important;
    }

    [data-bs-theme="dark"] .form-control,
    [data-bs-theme="dark"] .form-select {
      background-color: #1e293b !important;
      border-color: #475569 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .form-control:focus,
    [data-bs-theme="dark"] .form-select:focus {
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
    }

    [data-bs-theme="dark"] .dropdown-menu {
      background-color: #1e293b !important;
      border: 1px solid #334155 !important;
      color: #f1f5f9 !important;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
    }

    [data-bs-theme="dark"] .dropdown-item {
      color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .dropdown-item:hover {
      background-color: #334155 !important;
      color: #ffffff !important;
    }

    [data-bs-theme="dark"] .notif-header {
      background: #243044 !important;
      border-bottom: 1px solid #334155 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .notif-item {
      border-bottom: 1px solid #334155 !important;
    }

    [data-bs-theme="dark"] .notif-item:hover {
      background: #27354a !important;
    }

    [data-bs-theme="dark"] .notif-footer {
      background: #243044 !important;
      border-top: 1px solid #334155 !important;
    }

    [data-bs-theme="dark"] .modal-content {
      background-color: #1e293b !important;
      border: 1px solid #334155 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .modal-header,
    [data-bs-theme="dark"] .modal-footer {
      border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .select2-container .select2-selection--single {
      background-color: #1e293b !important;
      border-color: #475569 !important;
    }

    [data-bs-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .select2-dropdown {
      background-color: #1e293b !important;
      border-color: #475569 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .select2-search--dropdown .select2-search__field {
      background-color: #0f172a !important;
      border-color: #475569 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .select2-results__option {
      color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected] {
      background-color: #2563eb !important;
      color: #ffffff !important;
    }

    [data-bs-theme="dark"] .text-dark {
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .text-muted {
      color: #94a3b8 !important;
    }

    [data-bs-theme="dark"] .bg-white {
      background-color: #1e293b !important;
    }

    [data-bs-theme="dark"] .bg-light {
      background-color: #243044 !important;
    }

    [data-bs-theme="dark"] .border {
      border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .common-qr-row {
      background: #1e3050 !important;
      border-left-color: #3b82f6 !important;
    }

    [data-bs-theme="dark"] .common-qr-row:hover {
      background: #253d66 !important;
    }

    .theme-toggle-btn {
      width: 40px;
      height: 40px;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .theme-toggle-btn:hover {
      transform: scale(1.08);
    }

    /* =========================
   SIDEBAR (CLEAN WHITE)
========================= */
    .left-sidebar {
      width: 270px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      background: #ffffff;
      border-right: 1px solid #e5e7eb;
      z-index: 1000;
    }

    .brand-logos {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 15px 12px;
    }

    .sidebar-logo {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      object-fit: cover;
    }

    .sidebar-title {
      font-size: 14px;
      font-weight: 600;
      color: #111827;
    }

    /* SCROLL */
    .scroll-sidebars {
      height: calc(100vh - 80px);
      overflow-y: auto;
      padding: 5px;
    }

    /* SECTION TITLE */
    .nav-small-cap {
      font-size: 11px;
      color: #6b7280;
      padding: 12px 15px 5px;
      text-transform: uppercase;
      font-weight: 700;
      letter-spacing: 0.5px;
    }

    /* MENU ITEM */
    .sidebar-item {
      margin: 4px 0;
    }

    /* LINK STYLE */
    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 15px;
      color: #111827 !important;
      text-decoration: none;
      border-radius: 10px;
      font-size: 14px;
      transition: all 0.2s ease;
    }

    /* ICON */
    .sidebar-link i {
      font-size: 18px;
      color: #374151;
    }

    /* HOVER */
    .sidebar-link:hover {
      background: #f3f4f6;
      transform: translateX(3px);
    }

    /* ACTIVE */
    .sidebar-item.active .sidebar-link {
      background: #0d6efd;
      color: #fff !important;
      box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }

    .sidebar-item.active .sidebar-link i {
      color: #fff;
    }

    /* =========================
   HEADER
========================= */
    .app-headers {
      position: fixed;
      top: 0;
      left: 270px;
      width: calc(100% - 270px);
      height: 60px;
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      z-index: 999;
    }

    /* =========================
   BODY
========================= */
    .body-wrapper {
      margin-left: 270px;
      padding-top: 60px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .container-fluids {
      padding: 18px 24px 35px 24px !important;
      width: 100%;
    }

    @media (max-width: 768px) {
      .container-fluids {
        padding: 14px 12px 25px 12px !important;
      }
    }

    /* Expand all containers inside body-wrapper to full width and remove template's 180px padding-top */
    .body-wrapper .container,
    .body-wrapper .container-fluid {
      max-width: 100% !important;
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      margin: 0 !important;
    }

    /* Clean, compact per_page selector matching screenshot */
    select[name="per_page"] {
      width: auto !important;
      display: inline-block !important;
      min-width: 110px;
      font-size: 13px !important;
      padding: 6px 12px !important;
      border-radius: 6px !important;
      cursor: pointer;
    }

    /* Modern pagination links styling */
    .pagination {
      margin-bottom: 0 !important;
      gap: 3px;
    }

    .page-item .page-link {
      border-radius: 6px !important;
      font-size: 13px;
      padding: 6px 12px;
      color: #334155;
      border-color: #e2e8f0;
    }

    [data-bs-theme="dark"] .page-item .page-link {
      background-color: #1e293b;
      border-color: #334155;
      color: #cbd5e1;
    }

    .page-item.active .page-link {
      background-color: #2563eb !important;
      border-color: #2563eb !important;
      color: #ffffff !important;
      font-weight: 600;
    }

    [data-bs-theme="dark"] .page-item.active .page-link {
      background-color: #2563eb !important;
      border-color: #2563eb !important;
      color: #ffffff !important;
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
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
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
        left: -270px;
      }

      #main-wrapper.show-sidebar .left-sidebar {
        left: 0;
      }

      .app-headers {
        left: 0;
        width: 100%;
      }

      .body-wrapper {
        margin-left: 0;
      }
    }

    /* =========================
MOBILE
========================= */

    @media (max-width:768px) {

      .app-headers {
        height: 55px;
        padding: 0 10px;
      }

      .app-headers .fw-semibold {
        font-size: 14px;
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .container-fluids {
        padding: 15px 10px;
      }

      .notif-dropdown {
        width: 95vw;
        right: -10px;
      }

    }

    /* EXTRA SMALL */

    @media (max-width:576px) {

      .container-fluids {
        padding: 10px;
      }

      .brand-logos img {
        width: 38px;
      }

      .brand-logos h5 {
        font-size: 14px;
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
        <img src="{{ asset('assets/images/npc_logo.png') }}" class="sidebar-logo">
        <h6 class="sidebar-title">Department of Motor Traffic Northern Province</h6>
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
          @php
          $role = trim((string) auth()->user()->role);
          $roleLower = strtolower($role);

          $isSuperAdmin = $roleLower === 'super admin';
          $isAdmin = $roleLower === 'admin';
          $isCommissioner = $roleLower === 'commissioner';
          $isAdministrativeOfficer = in_array($roleLower, ['administrative officer', 'a/o', 'ao'], true);
          $isUser = $roleLower === 'user';

          // Requested sidebar mapping by role.
          $showDivisionList = $isSuperAdmin || $isAdmin || $isCommissioner;
          $showDivisionQr = true;
          $showFeedback = true;
          $showComplaintList = $isSuperAdmin ||  $isUser;
          $showManualComplaintEntry = $isSuperAdmin ||  $isUser || $isAdministrativeOfficer || $isCommissioner;
          $showAoManagement = $isSuperAdmin ||  $isAdministrativeOfficer;
          $showCommissioner = $isSuperAdmin ||  $isCommissioner;
          $showRatingReport = $isSuperAdmin || $isAdmin || $isUser || $isAdministrativeOfficer || $isCommissioner;
          $showUsers = $isSuperAdmin || $isAdmin;
          @endphp

          <!-- DS DIVISIONS -->
          @if($showDivisionList)

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
    @if($showDivisionQr)
          <li class="nav-small-cap">
            <span>DS Division QR</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('ds-divisions.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('ds-divisions.index') }}">
              <i class="ti ti-qrcode"></i>
              <span>Division QR</span>
            </a>
          </li>
          @endif
          <!-- FEEDBACK -->
          @if($showFeedback)
          <li class="nav-small-cap">
            <span>Feedback</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.feedback.index') }}">
              <i class="ti ti-message-dots"></i>
              <span>Feedback</span>
            </a>
          </li>
          @endif

          <!-- COMPLAINT -->
          @if($showComplaintList || $showManualComplaintEntry)
          <li class="nav-small-cap">
            <span>Complaint</span>
          </li>

          @if($showComplaintList)
          <li class="sidebar-item {{ request()->routeIs('admin.complain.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.complain.index') }}">
              <i class="ti ti-alert-circle"></i>
              <span>Complaint List</span>
            </a>
          </li>
          @endif

          @if($showManualComplaintEntry)
          <li class="sidebar-item {{ request()->routeIs('admin.manual-complaints.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.manual-complaints.index') }}">
              <i class="ti ti-file-description"></i>
              <span>Manual Complaints</span>
            </a>
          </li>
          @endif
          @endif

          <!-- QR -->
      

          <!-- AO -->
          @if($showAoManagement)
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

        @if($showCommissioner)

<li class="nav-small-cap">
    <span>Commissioner</span>
</li>

<li class="sidebar-item {{ request()->routeIs('admin.commissioner.index') ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('admin.commissioner.index') }}">
        <i class="ti ti-crown"></i>
        <span>Commissioner Complaints</span>
    </a>
</li>

<li class="sidebar-item {{ request()->routeIs('admin.commissioner.informed') ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('admin.commissioner.informed') }}">
        <i class="ti ti-bell-ringing"></i>
        <span>Informed Complaints</span>
    </a>
</li>

@endif
          
          <!-- USER MANAGEMENT -->
          @if($showUsers)
          <li class="nav-small-cap">
            <span>User Management</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('users.index') }}">
              <i class="ti ti-users"></i>
              <span>Users</span>
            </a>
          </li>
<!-- REPORT -->
          @if($showRatingReport)
          <li class="nav-small-cap">
            <span>Report</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('reports.rating-points') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('reports.rating-points') }}">
              <i class="ti ti-chart-bar"></i>
              <span>Rating Report</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('reports.manual-complaints') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('reports.manual-complaints') }}">
              <i class="ti ti-file-description"></i>
              <span>Manual Complaint Report</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('reports.qr-complaints') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('reports.qr-complaints') }}">
              <i class="ti ti-qrcode"></i>
              <span>QR Complaint Report</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('reports.division-counter-totals') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('reports.division-counter-totals') }}">
              <i class="ti ti-building-community"></i>
              <span>Division Counter Total</span>
            </a>
          </li>
          @endif

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

          <li class="sidebar-item {{ request()->routeIs('manual-complaint-sources.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('manual-complaint-sources.index') }}">
              <i class="ti ti-adjustments"></i>
              <span>Manual Source Settings</span>
            </a>
          </li>
          @endif

          @if($isSuperAdmin)
          <li class="sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('roles.index') }}">
              <i class="ti ti-user"></i>
              <span>Roles</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('permission-groups.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('permission-groups.index') }}">
              <i class="ti ti-shield-lock"></i>
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
      <div class="fw-semibold" align="center">
        <a href="#" data-bs-toggle="dropdown">
          <img src="{{ asset('assets/images/pdmt_logo.png') }}" width="45" class="rounded-circle">
        </a>
        {{-- <span>Welcome to {{ auth()->user()->name }} Dashboard!</span> --}}
        <span>Smart Feedback Management System</span>

      </div>

      <!-- RIGHT -->
      <!-- RIGHT -->
      <div class="d-flex align-items-center gap-3">
        <span>{{ auth()->user()->name }} Dashboard</span>

        <!-- 🌓 THEME TOGGLE -->
        <button id="themeToggleBtn" type="button" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center shadow-sm theme-toggle-btn" style="width: 38px; height: 38px;" title="Switch Theme (Dark / Light)">
          <i id="themeIcon" class="bi bi-moon-stars-fill text-primary"></i>
        </button>

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
              @php
              $roleKey = strtolower(trim((string) auth()->user()->role));
              $isSuperAdmin = $roleKey === 'super admin' || (auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin());
              if (isset($item->complaint)) {
              $notificationUrl = route('admin.manual-complaints.index');
              } elseif (in_array($roleKey, ['administrative officer', 'a/o', 'ao'], true)) {
              $notificationUrl = route('admin.ao.index');
              } elseif ($isSuperAdmin || in_array($roleKey, ['commissioner', 'commisioner'], true)) {
              $notificationUrl = route('admin.commissioner.index');
              } elseif ($roleKey === 'user') {
              $notificationUrl = route('admin.feedback.index');
              } else {
              $notificationUrl = route('dashboard');
              }
              @endphp
              <a href="{{ $notificationUrl }}" class="notif-item text-decoration-none text-reset">
                <div class="notif-icon">
                  <i class="ti ti-message"></i>
                </div>

                <div class="notif-content">
                  <div class="notif-text">
                    @if(isset($item->complaint))
                    Manual Complaint: {{ \Illuminate\Support\Str::limit($item->complaint, 60) }}
                    @else
                    {{ \Illuminate\Support\Str::limit($item->note ?? '-', 60) }}
                    @endif
                  </div>
                  <small class="text-muted">
                    {{ $item->created_at->diffForHumans() }}
                  </small>
                </div>
              </a>
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
          <a href="#" data-bs-toggle="dropdown"
            class="d-flex align-items-center justify-content-center rounded-circle"
            style="width:45px;height:45px;background:#e7f1ff;">
            <i class="ti ti-user" style="font-size:22px;color:#0d6efd;"></i>
          </a>

          <div class="dropdown-menu dropdown-menu-end">
            <a href="{{ route('users.show', auth()->user()->id) }}" class="dropdown-item fw-semibold">
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

        <div class="text-center mt-5 pt-3 pb-2 text-muted small border-top" style="border-color: rgba(148, 163, 184, 0.25) !important;">
          <div class="fw-semibold">
            Provincial Department of Motor Traffic (PDMT) • Northern Provincial Council, Sri Lanka
          </div>
          <div class="mt-1" style="font-size: 11.5px; opacity: 0.85;">
            Official Citizen Feedback, Service Quality Monitoring & Complaint Redressal System • © {{ date('Y') }} All Rights Reserved
          </div>
        </div>

      </div>
    </div>

  </div>

  <!-- JS -->
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    document.getElementById('menuBtn').addEventListener('click', function() {
      document.getElementById('main-wrapper').classList.toggle('show-sidebar');
    });

    // Theme Toggle Handler
    (function() {
      const toggleBtn = document.getElementById('themeToggleBtn');
      const icon = document.getElementById('themeIcon');

      function updateThemeUI(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('app_theme', theme);
        if (theme === 'dark') {
          if (icon) icon.className = 'bi bi-sun-fill text-warning';
          if (toggleBtn) {
            toggleBtn.classList.remove('btn-light');
            toggleBtn.classList.add('btn-dark');
          }
        } else {
          if (icon) icon.className = 'bi bi-moon-stars-fill text-primary';
          if (toggleBtn) {
            toggleBtn.classList.remove('btn-dark');
            toggleBtn.classList.add('btn-light');
          }
        }
      }

      const activeTheme = localStorage.getItem('app_theme') || 'light';
      updateThemeUI(activeTheme);

      if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
          const current = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'dark' : 'light';
          const target = current === 'dark' ? 'light' : 'dark';
          updateThemeUI(target);
        });
      }
    })();
  </script>

  @yield('script')

</body>

</html>
