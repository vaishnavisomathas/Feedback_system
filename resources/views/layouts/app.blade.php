<!doctype html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'PDMT Feedback Management System')</title>

  <link rel="shortcut icon" href="{{ asset('assets/images/pdmt_logo.png') }}">

  <!-- Modern Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Core CSS -->
  <link href="{{ asset('assets/css/styles.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

  <!-- Chart.js for High-End Interactive Analytics -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <script>
    (function() {
      const savedTheme = localStorage.getItem('app_theme') || 'light';
      document.documentElement.setAttribute('data-bs-theme', savedTheme);
    })();
  </script>

  <style>
    :root {
      --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      --gov-navy-900: #0a192f;
      --gov-navy-800: #0f274a;
      --gov-blue-600: #1d4ed8;
      --gov-blue-500: #2563eb;
      --gov-gold-500: #f59e0b;
      --gov-gold-600: #d97706;
      --gov-emerald-500: #10b981;
    }

    body {
      margin: 0;
      background: #f4f6fa;
      font-family: var(--font-sans);
      color: #1e293b;
      transition: background-color 0.25s ease, color 0.25s ease;
      -webkit-font-smoothing: antialiased;
    }

    /* =========================================================
       DARK THEME STYLES
    ========================================================= */
    [data-bs-theme="dark"] body {
      background: #090d16 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .left-sidebar {
      background: #0f172a !important;
      border-right: 1px solid #1e293b !important;
    }

    [data-bs-theme="dark"] .sidebar-title {
      color: #f8fafc !important;
    }

    [data-bs-theme="dark"] .nav-small-cap {
      color: #64748b !important;
    }

    [data-bs-theme="dark"] .sidebar-link {
      color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .sidebar-link i {
      color: #94a3b8 !important;
    }

    [data-bs-theme="dark"] .sidebar-link:hover {
      background: #1e293b !important;
      color: #ffffff !important;
    }

    [data-bs-theme="dark"] .sidebar-item.active .sidebar-link {
      background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%) !important;
      color: #ffffff !important;
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4) !important;
    }

    [data-bs-theme="dark"] .app-headers {
      background: #0f172a !important;
      border-bottom: 1px solid #1e293b !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .card,
    [data-bs-theme="dark"] .table-card {
      background-color: #0f172a !important;
      border: 1px solid #1e293b !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .card-header,
    [data-bs-theme="dark"] .table-header {
      background-color: #141e33 !important;
      border-bottom: 1px solid #1e293b !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .table {
      color: #e2e8f0 !important;
      border-color: #1e293b !important;
    }

    [data-bs-theme="dark"] .table th,
    [data-bs-theme="dark"] .table td {
      border-color: #1e293b !important;
      color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .table-hover tbody tr:hover {
      background-color: #162238 !important;
    }

    [data-bs-theme="dark"] .dashboard-table,
    [data-bs-theme="dark"] .ao-table,
    [data-bs-theme="dark"] .complaint-table,
    [data-bs-theme="dark"] .report-table {
      background-color: #0f172a !important;
    }

    [data-bs-theme="dark"] .dashboard-table thead th,
    [data-bs-theme="dark"] .ao-table thead th,
    [data-bs-theme="dark"] .complaint-table thead th,
    [data-bs-theme="dark"] .report-table thead th {
      background: #141e33 !important;
      color: #f8fafc !important;
      border-bottom-color: #1e293b !important;
    }

    [data-bs-theme="dark"] .form-control,
    [data-bs-theme="dark"] .form-select {
      background-color: #0f172a !important;
      border-color: #334155 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .form-control:focus,
    [data-bs-theme="dark"] .form-select:focus {
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
    }

    [data-bs-theme="dark"] .dropdown-menu {
      background-color: #0f172a !important;
      border: 1px solid #1e293b !important;
      color: #f1f5f9 !important;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6) !important;
    }

    [data-bs-theme="dark"] .dropdown-item {
      color: #cbd5e1 !important;
    }

    [data-bs-theme="dark"] .dropdown-item:hover {
      background-color: #1e293b !important;
      color: #ffffff !important;
    }

    [data-bs-theme="dark"] .notif-header {
      background: #141e33 !important;
      border-bottom: 1px solid #1e293b !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .notif-item {
      border-bottom: 1px solid #1e293b !important;
    }

    [data-bs-theme="dark"] .notif-item:hover {
      background: #162238 !important;
    }

    [data-bs-theme="dark"] .notif-footer {
      background: #141e33 !important;
      border-top: 1px solid #1e293b !important;
    }

    [data-bs-theme="dark"] .modal-content {
      background-color: #0f172a !important;
      border: 1px solid #1e293b !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .modal-header,
    [data-bs-theme="dark"] .modal-footer {
      border-color: #1e293b !important;
    }

    [data-bs-theme="dark"] .select2-container .select2-selection--single {
      background-color: #0f172a !important;
      border-color: #334155 !important;
    }

    [data-bs-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .select2-dropdown {
      background-color: #0f172a !important;
      border-color: #334155 !important;
      color: #f1f5f9 !important;
    }

    [data-bs-theme="dark"] .select2-search--dropdown .select2-search__field {
      background-color: #090d16 !important;
      border-color: #334155 !important;
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
      background-color: #0f172a !important;
    }

    [data-bs-theme="dark"] .bg-light {
      background-color: #141e33 !important;
    }

    [data-bs-theme="dark"] .border {
      border-color: #1e293b !important;
    }

    /* =========================================================
       SIDEBAR
    ========================================================= */
    .left-sidebar {
      width: 270px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      background: #ffffff;
      border-right: 1px solid #e2e8f0;
      z-index: 1000;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
    }

    .brand-logos {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 18px 18px 14px 18px;
      border-bottom: 1px solid rgba(226, 232, 240, 0.8);
    }

    [data-bs-theme="dark"] .brand-logos {
      border-bottom-color: #1e293b;
    }

    .sidebar-logo {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      background: #ffffff;
      padding: 2px;
    }

    .sidebar-title {
      font-size: 13.5px;
      font-weight: 700;
      color: #0f172a;
      line-height: 1.25;
      margin: 0;
    }

    .sidebar-subtitle {
      font-size: 11px;
      color: #64748b;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 2px;
    }

    .scroll-sidebars {
      flex: 1;
      overflow-y: auto;
      padding: 12px 14px 20px 14px;
    }

    .scroll-sidebars ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .nav-small-cap {
      font-size: 10.5px;
      color: #64748b;
      padding: 16px 12px 6px;
      text-transform: uppercase;
      font-weight: 800;
      letter-spacing: 0.8px;
    }

    .sidebar-item {
      margin: 3px 0;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 9px 14px;
      color: #334155;
      text-decoration: none;
      border-radius: 9px;
      font-size: 13.5px;
      font-weight: 600;
      transition: all 0.18s ease-in-out;
    }

    .sidebar-link i {
      font-size: 17px;
      color: #64748b;
      transition: color 0.18s ease;
      width: 20px;
      text-align: center;
    }

    .sidebar-link:hover {
      background: #f1f5f9;
      color: #0f172a;
      transform: translateX(3px);
    }

    .sidebar-link:hover i {
      color: #2563eb;
    }

    .sidebar-item.active .sidebar-link {
      background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 100%);
      color: #ffffff !important;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .sidebar-item.active .sidebar-link i {
      color: #ffffff;
    }

    /* =========================================================
       HEADER
    ========================================================= */
    .app-headers {
      position: fixed;
      top: 0;
      left: 270px;
      width: calc(100% - 270px);
      height: 64px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(8px);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 24px;
      border-bottom: 1px solid #e2e8f0;
      z-index: 999;
      transition: all 0.25s ease;
    }

    .header-branding {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .header-logo-pill {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #f8fafc;
      padding: 5px 12px 5px 6px;
      border-radius: 20px;
      border: 1px solid #e2e8f0;
    }

    [data-bs-theme="dark"] .header-logo-pill {
      background: #141e33;
      border-color: #1e293b;
    }

    .header-title-text {
      font-size: 13.5px;
      font-weight: 700;
      color: #0f172a;
      letter-spacing: -0.2px;
    }

    [data-bs-theme="dark"] .header-title-text {
      color: #f8fafc;
    }

    .gov-live-pill {
      background: #ecfdf5;
      color: #065f46;
      border: 1px solid #a7f3d0;
      font-size: 11px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 20px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    [data-bs-theme="dark"] .gov-live-pill {
      background: rgba(16, 185, 129, 0.15);
      color: #34d399;
      border-color: rgba(52, 211, 153, 0.3);
    }

    .pulse-dot {
      width: 7px;
      height: 7px;
      background: #10b981;
      border-radius: 50%;
      box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.35);
      animation: pulse 1.8s infinite;
    }

    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6); }
      70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
      100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    /* THEME TOGGLE */
    .theme-toggle-btn {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid #e2e8f0;
      background: #ffffff;
      color: #475569;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    [data-bs-theme="dark"] .theme-toggle-btn {
      background: #141e33;
      border-color: #1e293b;
      color: #f59e0b;
    }

    .theme-toggle-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    }

    /* NOTIFICATION DROPDOWN */
    .notif-badge {
      position: absolute;
      top: -2px;
      right: -2px;
      font-size: 10px;
      padding: 3px 6px;
      font-weight: 700;
    }

    .notif-dropdown {
      width: 340px;
      border-radius: 14px;
      overflow: hidden;
      border: 1px solid #e2e8f0;
      box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
    }

    .notif-header {
      padding: 12px 16px;
      font-weight: 700;
      font-size: 13.5px;
      background: #f8fafc;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .notif-body {
      max-height: 340px;
      overflow-y: auto;
    }

    .notif-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      padding: 12px 16px;
      border-bottom: 1px solid #f1f5f9;
      transition: background 0.18s ease;
    }

    .notif-item:hover {
      background: #f8fafc;
    }

    .notif-icon {
      width: 34px;
      height: 34px;
      border-radius: 50%;
      background: #eff6ff;
      color: #2563eb;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      flex-shrink: 0;
    }

    [data-bs-theme="dark"] .notif-icon {
      background: rgba(37, 99, 235, 0.2);
      color: #60a5fa;
    }

    .notif-text {
      font-size: 13px;
      font-weight: 600;
      color: #1e293b;
      line-height: 1.35;
    }

    [data-bs-theme="dark"] .notif-text {
      color: #f1f5f9;
    }

    .notif-footer {
      text-align: center;
      padding: 10px;
      background: #f8fafc;
      border-top: 1px solid #e2e8f0;
    }

    /* USER AVATAR */
    .user-avatar-btn {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%);
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 15px;
      border: 2px solid #ffffff;
      box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
      cursor: pointer;
      text-decoration: none;
      transition: transform 0.2s ease;
    }

    .user-avatar-btn:hover {
      transform: scale(1.04);
      color: #ffffff;
    }

    /* =========================================================
       BODY & CONTENT
    ========================================================= */
    .body-wrapper {
      margin-left: 270px;
      padding-top: 64px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .container-fluids {
      padding: 24px 28px 40px 28px !important;
      width: 100%;
      flex: 1;
    }

    .body-wrapper .container,
    .body-wrapper .container-fluid {
      max-width: 100% !important;
      padding: 0 !important;
      margin: 0 !important;
    }

    /* GLOBAL CARD & TABLE ENHANCEMENTS */
    .card {
      border-radius: 14px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
      transition: all 0.2s ease;
    }

    .card:hover {
      box-shadow: 0 6px 18px rgba(15, 23, 42, 0.07);
    }

    .btn {
      font-weight: 600;
      border-radius: 9px;
      padding: 7px 16px;
      font-size: 13.5px;
      transition: all 0.18s ease;
    }

    .btn-primary {
      background: #2563eb;
      border-color: #2563eb;
    }

    .btn-primary:hover {
      background: #1d4ed8;
      border-color: #1d4ed8;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* Pagination */
    .pagination {
      margin-bottom: 0 !important;
      gap: 4px;
    }

    .page-item .page-link {
      border-radius: 8px !important;
      font-size: 13px;
      font-weight: 600;
      padding: 6px 14px;
      color: #334155;
      border-color: #e2e8f0;
    }

    [data-bs-theme="dark"] .page-item .page-link {
      background-color: #0f172a;
      border-color: #1e293b;
      color: #cbd5e1;
    }

    .page-item.active .page-link {
      background-color: #2563eb !important;
      border-color: #2563eb !important;
      color: #ffffff !important;
      box-shadow: 0 3px 10px rgba(37, 99, 235, 0.35);
    }

    /* SELECT2 POLISH */
    .select2-container .select2-selection--single {
      height: 40px !important;
      border-radius: 9px !important;
      border: 1px solid #cbd5e1 !important;
      display: flex !important;
      align-items: center !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 40px !important;
      padding-left: 12px !important;
      font-size: 13.5px !important;
      font-weight: 500 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 38px !important;
      right: 10px !important;
    }

    /* =========================================================
       RESPONSIVE BREAKPOINTS
    ========================================================= */
    @media (max-width: 1199px) {
      .left-sidebar {
        left: -270px;
      }

      #main-wrapper.show-sidebar .left-sidebar {
        left: 0;
        box-shadow: 0 0 25px rgba(0,0,0,0.25);
      }

      .app-headers {
        left: 0;
        width: 100%;
      }

      .body-wrapper {
        margin-left: 0;
      }
    }

    @media (max-width: 768px) {
      .app-headers {
        height: 58px;
        padding: 0 14px;
      }

      .container-fluids {
        padding: 16px 14px 28px 14px !important;
      }

      .header-title-text {
        font-size: 12px;
        max-width: 160px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .notif-dropdown {
        width: calc(100vw - 28px);
        right: -10px;
      }
    }
  </style>
</head>

<body>

  <div id="main-wrapper">

    <!-- SIDEBAR -->
    <aside class="left-sidebar">

      <!-- LOGO / BRAND HEADER -->
      <div class="brand-logos">
        <img src="{{ asset('assets/images/npc_logo.png') }}" class="sidebar-logo" alt="NPC Logo">
        <div>
          <h6 class="sidebar-title">Provincial Department of Motor Traffic</h6>
          <div class="sidebar-subtitle">Northern Province </div>
        </div>
      </div>

      <nav class="scroll-sidebars">
        <ul>

          <!-- OVERVIEW SECTION -->
          <li class="nav-small-cap">
            <span>Main Menu</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dashboard') }}">
              <i class="bi bi-speedometer2"></i>
              <span>Executive Dashboard</span>
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

          // Role-based visibility
          $showDivisionList = $isSuperAdmin || $isAdmin || $isCommissioner;
          $showDivisionQr = true;
          $showFeedback = true;
          $showComplaintList = $isSuperAdmin || $isUser;
          $showManualComplaintEntry = $isSuperAdmin || $isUser || $isAdministrativeOfficer || $isCommissioner;
          $showAoManagement = $isSuperAdmin || $isAdministrativeOfficer;
          $showCommissioner = $isSuperAdmin || $isCommissioner;
          $showRatingReport = $isSuperAdmin || $isAdmin || $isUser || $isAdministrativeOfficer || $isCommissioner;
          $showUsers = $isSuperAdmin || $isAdmin;
          @endphp

          <!-- COUNTERS & QR -->
          @if($showDivisionList || $showDivisionQr)
          <li class="nav-small-cap">
            <span>Counters &amp; QR</span>
          </li>

          @if($showDivisionList)
          <li class="sidebar-item {{ request()->routeIs('counters.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('counters.index') }}">
              <i class="bi bi-building"></i>
              <span>Division &amp; Counters</span>
            </a>
          </li>
          @endif

          @if($showDivisionQr)
          <li class="sidebar-item {{ request()->routeIs('ds-divisions.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('ds-divisions.index') }}">
              <i class="bi bi-qr-code-scan"></i>
              <span>Division QR Generation</span>
            </a>
          </li>
          @endif
          @endif

          <!-- CITIZEN FEEDBACK -->
          @if($showFeedback)
          <li class="nav-small-cap">
            <span>Feedback</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.feedback.index') }}">
              <i class="bi bi-chat-square-heart"></i>
              <span>Citizen Feedback</span>
            </a>
          </li>
          @endif

          <!-- COMPLAINTS MANAGEMENT -->
          @if($showComplaintList || $showManualComplaintEntry)
          <li class="nav-small-cap">
            <span>Grievances &amp; Complaints</span>
          </li>

          @if($showComplaintList)
          <li class="sidebar-item {{ request()->routeIs('admin.complain.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.complain.index') }}">
              <i class="bi bi-exclamation-octagon"></i>
              <span>QR Complaints</span>
            </a>
          </li>
          @endif

          @if($showManualComplaintEntry)
          <li class="sidebar-item {{ request()->routeIs('admin.manual-complaints.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.manual-complaints.index') }}">
              <i class="bi bi-journal-text"></i>
              <span>Manual Complaints</span>
            </a>
          </li>
          @endif
          @endif

          <!-- WORKFLOW MANAGEMENT -->
          @if($showAoManagement || $showCommissioner)
          <li class="nav-small-cap">
            <span>Workflow Actions</span>
          </li>

          @if($showAoManagement)
          <li class="sidebar-item {{ request()->routeIs('admin.ao.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.ao.index') }}">
              <i class="bi bi-shield-check"></i>
              <span>A/O Investigation</span>
            </a>
          </li>
          @endif

          @if($showCommissioner)
          <li class="sidebar-item {{ request()->routeIs('admin.commissioner.index') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.commissioner.index') }}">
              <i class="bi bi-award"></i>
              <span>Commissioner Action</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('admin.commissioner.informed') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('admin.commissioner.informed') }}">
              <i class="bi bi-bell"></i>
              <span>Informed Complaints</span>
            </a>
          </li>
          @endif
          @endif

          <!-- EXECUTIVE REPORTS -->
          @if($showRatingReport)
          <li class="nav-small-cap">
            <span>Executive Reports</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('reports.rating-points') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('reports.rating-points') }}">
              <i class="bi bi-graph-up"></i>
              <span>Rating Points Report</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('reports.manual-complaints') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('reports.manual-complaints') }}">
              <i class="bi bi-file-earmark-bar-graph"></i>
              <span>Manual Complaints Report</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('reports.qr-complaints') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('reports.qr-complaints') }}">
              <i class="bi bi-file-earmark-text"></i>
              <span>QR Complaints Report</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('reports.division-counter-totals') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('reports.division-counter-totals') }}">
              <i class="bi bi-pie-chart"></i>
              <span>Division Counter Totals</span>
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
              <i class="bi bi-people"></i>
              <span>Staff Users</span>
            </a>
          </li>
          @endif

          <!-- SYSTEM SETTINGS -->
          <li class="nav-small-cap">
            <span>Configuration</span>
          </li>

          <li class="sidebar-item {{ request()->routeIs('complain.types.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('complain.types.index') }}">
              <i class="bi bi-list-check"></i>
              <span>Complaint Types</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('service.quality.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('service.quality.index') }}">
              <i class="bi bi-star"></i>
              <span>Service Quality Metrics</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('manual-complaint-sources.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('manual-complaint-sources.index') }}">
              <i class="bi bi-sliders"></i>
              <span>Manual Complaint Sources</span>
            </a>
          </li>

          @if($isSuperAdmin)
          <li class="sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('roles.index') }}">
              <i class="bi bi-person-badge"></i>
              <span>Access Roles</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('permission-groups.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('permission-groups.index') }}">
              <i class="bi bi-shield-lock"></i>
              <span>Permission Groups</span>
            </a>
          </li>

          <li class="sidebar-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('permissions.index') }}">
              <i class="bi bi-key"></i>
              <span>System Permissions</span>
            </a>
          </li>
          @endif

          @endauth

        </ul>
      </nav>

    </aside>

    <!-- HEADER -->
    <header class="app-headers">

      <!-- LEFT: MOBILE TOGGLE & BRAND BADGE -->
      <div class="d-flex align-items-center gap-3">
        <button id="menuBtn" class="btn btn-sm btn-light border d-xl-none" aria-label="Toggle Sidebar">
          <i class="bi bi-list fs-5"></i>
        </button>

        <div class="header-branding">
          <div class="header-logo-pill d-none d-sm-flex">
            <img src="{{ asset('assets/images/pdmt_logo.png') }}" width="28" height="28" alt="PDMT Crest" class="rounded-circle">
            <span class="header-title-text">PDMT- Smart Feedback and Complaint Management System </span>
          </div>

          <div class="gov-live-pill d-none d-md-inline-flex">
            <span class="pulse-dot"></span>
            <span>Live Civic Network</span>
          </div>
        </div>
      </div>

      <!-- RIGHT: THEME TOGGLE, NOTIFICATIONS, PROFILE -->
      <div class="d-flex align-items-center gap-2 gap-sm-3">

        <!-- THEME TOGGLE -->
        <button id="themeToggleBtn" type="button" class="theme-toggle-btn shadow-sm" title="Toggle Dark/Light Mode">
          <i id="themeIcon" class="bi bi-moon-stars-fill"></i>
        </button>

        <!-- NOTIFICATION DROPDOWN -->
        <div class="dropdown">
          <a class="btn btn-sm btn-light border position-relative rounded-circle d-flex align-items-center justify-content-center" href="#" data-bs-toggle="dropdown" style="width: 38px; height: 38px;" aria-expanded="false" title="Notifications">
            <i class="bi bi-bell fs-6"></i>

            @if(isset($notificationCount) && $notificationCount > 0)
            <span class="badge bg-danger rounded-pill notif-badge">
              {{ $notificationCount }}
            </span>
            @endif
          </a>

          <div class="dropdown-menu dropdown-menu-end notif-dropdown p-0">

            <div class="notif-header">
              <span class="d-flex align-items-center gap-2">
                <i class="bi bi-bell-fill text-primary"></i> Notifications
              </span>
              @if(isset($notificationCount) && $notificationCount > 0)
              <span class="badge bg-primary rounded-pill">{{ $notificationCount }} new</span>
              @endif
            </div>

            <div class="notif-body">
              @if(isset($notificationList) && count($notificationList) > 0)
                @foreach($notificationList as $item)
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
                      <i class="bi bi-chat-left-dots-fill"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div class="notif-text">
                        @if(isset($item->complaint))
                          <span class="badge bg-warning text-dark me-1" style="font-size: 10px;">Manual</span>
                          {{ \Illuminate\Support\Str::limit($item->complaint, 55) }}
                        @else
                          <span class="badge bg-info text-dark me-1" style="font-size: 10px;">QR</span>
                          {{ \Illuminate\Support\Str::limit($item->note ?? '-', 55) }}
                        @endif
                      </div>
                      <small class="text-muted d-block mt-1">
                        <i class="bi bi-clock me-1"></i>{{ $item->created_at->diffForHumans() }}
                      </small>
                    </div>
                  </a>
                @endforeach
              @else
                <div class="text-center p-4 text-muted">
                  <i class="bi bi-bell-slash fs-2 d-block mb-2 text-secondary opacity-50"></i>
                  <span class="small fw-semibold">No new notifications</span>
                </div>
              @endif
            </div>

            <div class="notif-footer">
              <a href="{{ route('admin.complain.index') }}" class="small fw-bold text-primary text-decoration-none">
                View All Complaints <i class="bi bi-arrow-right"></i>
              </a>
            </div>

          </div>
        </div>

        <!-- USER PROFILE DROPDOWN -->
        <div class="dropdown">
          <a href="#" data-bs-toggle="dropdown" class="user-avatar-btn text-decoration-none" title="{{ auth()->user()->name ?? 'User' }}">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
          </a>

          <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-2" style="min-width: 230px; border-radius: 12px;">
            <div class="px-3 py-2 border-bottom">
              <div class="fw-bold text-dark">{{ auth()->user()->name ?? 'Staff User' }}</div>
              <div class="small text-muted text-truncate">{{ auth()->user()->email ?? '' }}</div>
              <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill mt-1" style="font-size: 10px;">
                {{ auth()->user()->role ?? 'Staff' }}
              </span>
            </div>

            <a href="{{ route('users.show', auth()->user()->id) }}" class="dropdown-item d-flex align-items-center gap-2 py-2">
              <i class="bi bi-person text-secondary"></i>
              <span>My Profile</span>
            </a>

            <a href="{{ route('password.change.form') }}" class="dropdown-item d-flex align-items-center gap-2 py-2">
              <i class="bi bi-shield-lock text-secondary"></i>
              <span>Change Password</span>
            </a>

            <div class="dropdown-divider my-1"></div>

            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </button>
            </form>
          </div>
        </div>

      </div>

    </header>

    <!-- CONTENT BODY -->
    <div class="body-wrapper">
      <div class="container-fluids">

        @yield('content')

        <!-- FOOTER -->
        <footer class="text-center mt-5 pt-4 pb-3 text-muted small border-top" style="border-color: rgba(148, 163, 184, 0.2) !important;">
          <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 px-2">
            <div class="text-start">
              <span class="fw-bold text-dark">Provincial Department of Motor Traffic (PDMT)</span>
              <span class="text-muted">&bull; Northern Provincial Council, Sri Lanka</span>
            </div>
            <div class="text-end">
              <span>Official Citizen Feedback &amp; Grievance Redressal Portal &bull; &copy; {{ date('Y') }} All Rights Reserved</span>
            </div>
          </div>
        </footer>

      </div>
    </div>

  </div>

  <!-- CORE SCRIPTS -->
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    // Mobile Sidebar Toggle
    const menuBtn = document.getElementById('menuBtn');
    if (menuBtn) {
      menuBtn.addEventListener('click', function() {
        document.getElementById('main-wrapper').classList.toggle('show-sidebar');
      });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
      const wrapper = document.getElementById('main-wrapper');
      const sidebar = document.querySelector('.left-sidebar');
      const menuButton = document.getElementById('menuBtn');
      if (wrapper && wrapper.classList.contains('show-sidebar') && window.innerWidth < 1200) {
        if (sidebar && !sidebar.contains(event.target) && menuButton && !menuButton.contains(event.target)) {
          wrapper.classList.remove('show-sidebar');
        }
      }
    });

    // Theme Toggle Handler
    (function() {
      const toggleBtn = document.getElementById('themeToggleBtn');
      const icon = document.getElementById('themeIcon');

      function updateThemeUI(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('app_theme', theme);
        if (icon) {
          if (theme === 'dark') {
            icon.className = 'bi bi-sun-fill text-warning';
          } else {
            icon.className = 'bi bi-moon-stars-fill text-primary';
          }
        }
      }

      const currentTheme = localStorage.getItem('app_theme') || 'light';
      updateThemeUI(currentTheme);

      if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
          const activeTheme = document.documentElement.getAttribute('data-bs-theme') || 'light';
          const nextTheme = activeTheme === 'dark' ? 'light' : 'dark';
          updateThemeUI(nextTheme);
        });
      }
    })();
  </script>

  @yield('script')
  @yield('scripts')

</body>
</html>
