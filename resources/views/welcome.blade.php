@extends('layouts.app')

@section('content')

<style>
/* =========================================================
   SRI LANKA GOVT. - DEPARTMENT OF MOTOR TRAFFIC (PDMT)
   OFFICIAL EXECUTIVE DASHBOARD STYLING
========================================================= */

/* 1. Official Government Hero Banner */
.gov-hero-banner {
  background: linear-gradient(135deg, #0a1f44 0%, #173878 50%, #1e40af 100%);
  color: #ffffff;
  border-radius: 14px;
  border-left: 6px solid #f59e0b; /* Sri Lankan Emblem Gold */
  padding: 18px 24px;
  margin-bottom: 20px;
  box-shadow: 0 4px 16px rgba(10, 31, 68, 0.12);
  position: relative;
  overflow: hidden;
}

[data-bs-theme="dark"] .gov-hero-banner {
  background: linear-gradient(135deg, #071329 0%, #0f274a 50%, #1e3a8a 100%);
  border-left-color: #fbbf24;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
}

.gov-hero-pattern {
  position: absolute;
  right: -20px;
  top: -20px;
  opacity: 0.08;
  font-size: 160px;
  pointer-events: none;
}

.gov-emblem-box {
  width: 58px;
  height: 58px;
  background: #ffffff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 5px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  flex-shrink: 0;
}

.gov-emblem-box img {
  width: 46px;
  height: 46px;
  object-fit: contain;
}

.gov-subtitle-badge {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #93c5fd;
  display: flex;
  align-items: center;
  gap: 6px;
}

.gov-title-main {
  font-size: 20px;
  font-weight: 800;
  color: #ffffff;
  letter-spacing: -0.3px;
  margin: 3px 0;
}

.gov-trilingual-tag {
  font-size: 12px;
  color: #cbd5e1;
}

.gov-live-pill {
  background: rgba(255, 255, 255, 0.14);
  backdrop-filter: blur(6px);
  color: #ffffff;
  font-size: 12px;
  font-weight: 600;
  padding: 6px 14px;
  border-radius: 20px;
  border: 1px solid rgba(255, 255, 255, 0.22);
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.pulse-indicator {
  width: 9px;
  height: 9px;
  background: #10b981;
  border-radius: 50%;
  display: inline-block;
  box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.4);
}

.gov-quick-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 10px;
}

.gov-action-btn {
  background: rgba(255, 255, 255, 0.12);
  color: #ffffff !important;
  font-size: 11.5px;
  font-weight: 600;
  padding: 5px 12px;
  border-radius: 6px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  text-decoration: none;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

.gov-action-btn:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: translateY(-1px);
}

/* 2. Section Titles */
.dash-section-header {
  font-size: 15px;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 18px 0 12px 0;
  color: #0f172a;
  letter-spacing: -0.2px;
}

[data-bs-theme="dark"] .dash-section-header {
  color: #f1f5f9;
}

/* 3. Top Performing Counter Cards */
.gov-counter-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  transition: all 0.22s ease-in-out;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
}

[data-bs-theme="dark"] .gov-counter-card {
  background: #1e293b;
  border-color: #334155;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
}

.gov-counter-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
}

.card-accent-bar {
  height: 4px;
  width: 100%;
}
.accent-bar-today { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
.accent-bar-week { background: linear-gradient(90deg, #6366f1, #818cf8); }
.accent-bar-month { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
.accent-bar-year { background: linear-gradient(90deg, #f59e0b, #fbbf24); }

.gov-counter-title {
  font-size: 13px;
  font-weight: 700;
  color: #1e293b;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

[data-bs-theme="dark"] .gov-counter-title {
  color: #f8fafc;
}

.gov-counter-name {
  font-size: 16.5px;
  font-weight: 800;
  color: #0f172a;
  margin: 6px 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

[data-bs-theme="dark"] .gov-counter-name {
  color: #f8fafc;
}

.gold-feedbacks-badge {
  background-color: #ffc107 !important;
  color: #000000 !important;
  font-weight: 700 !important;
  font-size: 12px !important;
  padding: 5px 14px !important;
  border-radius: 6px !important;
  display: inline-block;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* 4. Stat Summary Cards */
.gov-stat-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  padding: 18px 20px;
  transition: all 0.22s ease-in-out;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

[data-bs-theme="dark"] .gov-stat-card {
  background: #1e293b;
  border-color: #334155;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
}

.gov-stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 18px rgba(15, 23, 42, 0.07);
}

.gov-stat-num {
  font-size: 28px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.15;
}

[data-bs-theme="dark"] .gov-stat-num {
  color: #f8fafc;
}

.gov-stat-lbl {
  font-size: 13px;
  color: #64748b;
  font-weight: 600;
  margin-top: 3px;
}

[data-bs-theme="dark"] .gov-stat-lbl {
  color: #94a3b8;
}

.gov-icon-box {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
}

.box-emerald { background: #d1fae5; color: #059669; }
.box-blue { background: #dbeafe; color: #2563eb; }
.box-amber { background: #fef3c7; color: #d97706; }
.box-purple { background: #ede9fe; color: #7c3aed; }

[data-bs-theme="dark"] .box-emerald { background: rgba(5, 150, 105, 0.22); color: #34d399; }
[data-bs-theme="dark"] .box-blue { background: rgba(37, 99, 235, 0.22); color: #60a5fa; }
[data-bs-theme="dark"] .box-amber { background: rgba(217, 119, 6, 0.22); color: #fbbf24; }
[data-bs-theme="dark"] .box-purple { background: rgba(124, 58, 237, 0.22); color: #a78bfa; }

/* 5. Status Tracker Strip */
.gov-tracker-strip {
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  padding: 12px 20px;
  margin-top: 14px;
}

[data-bs-theme="dark"] .gov-tracker-strip {
  background: #1e293b;
  border-color: #334155;
}

.tracker-badge-link {
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 12.5px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  text-decoration: none;
  transition: all 0.2s ease;
}

.tracker-badge-link:hover {
  transform: translateY(-1px);
}

.link-pending { background: #fff8e6; color: #b45309; border: 1px solid #fde68a; }
.link-ao { background: #ecfeff; color: #0e7490; border: 1px solid #a5f3fc; }
.link-commissioner { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

[data-bs-theme="dark"] .link-pending { background: rgba(245, 158, 11, 0.18); color: #fbbf24; border-color: rgba(245, 158, 11, 0.35); }
[data-bs-theme="dark"] .link-ao { background: rgba(6, 182, 212, 0.18); color: #67e8f9; border-color: rgba(6, 182, 212, 0.35); }
[data-bs-theme="dark"] .link-commissioner { background: rgba(37, 99, 235, 0.18); color: #93c5fd; border-color: rgba(37, 99, 235, 0.35); }

/* 6. Official Table Styling */
.gov-table-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  overflow: hidden;
  box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
}

[data-bs-theme="dark"] .gov-table-card {
  background: #1e293b;
  border-color: #334155;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
}

.gov-table-header {
  padding: 14px 20px;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #ffffff;
}

[data-bs-theme="dark"] .gov-table-header {
  background: #1e293b;
  border-bottom-color: #334155;
}

.gov-data-table thead {
  background: #f8fafc;
}

[data-bs-theme="dark"] .gov-data-table thead {
  background: #182234;
}

.gov-data-table thead th {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  padding: 11px 16px;
  border-bottom: 1px solid #e2e8f0;
}

[data-bs-theme="dark"] .gov-data-table thead th {
  color: #94a3b8;
  border-bottom-color: #334155;
}

.gov-data-table tbody td {
  padding: 12px 16px;
  font-size: 13.5px;
  border-bottom: 1px solid #f1f5f9;
}

[data-bs-theme="dark"] .gov-data-table tbody td {
  border-bottom-color: #27354a;
}

.gov-data-table tbody tr:last-child td {
  border-bottom: none;
}

.gov-data-table tbody tr:hover {
  background-color: #f8fafc;
}

[data-bs-theme="dark"] .gov-data-table tbody tr:hover {
  background-color: #243044;
}

/* Table Status Pills */
.gov-status-pill {
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 11.5px;
  font-weight: 600;
  display: inline-block;
}

.pill-status-pending { background: #fff3cd; color: #856404; }
.pill-status-ao { background: #cff4fc; color: #055160; }
.pill-status-commissioner { background: #cfe2ff; color: #084298; }
.pill-status-completed { background: #d1e7dd; color: #0f5132; }
.pill-status-rejected { background: #f8d7da; color: #842029; }

[data-bs-theme="dark"] .pill-status-pending { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
[data-bs-theme="dark"] .pill-status-ao { background: rgba(6, 182, 212, 0.2); color: #67e8f9; }
[data-bs-theme="dark"] .pill-status-commissioner { background: rgba(59, 130, 246, 0.2); color: #93c5fd; }
[data-bs-theme="dark"] .pill-status-completed { background: rgba(16, 185, 129, 0.2); color: #6ee7b7; }
[data-bs-theme="dark"] .pill-status-rejected { background: rgba(239, 68, 68, 0.2); color: #fca5a5; }

/* Rank Medals */
.rank-badge-item {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 700;
}
.rb-1 { background: #fef3c7; color: #b45309; }
.rb-2 { background: #f1f5f9; color: #475569; }
.rb-3 { background: #ffedd5; color: #c2410c; }
</style>

<div class="container-fluid px-0">

  {{-- =========================================================
     OFFICIAL SRI LANKA GOVT. EXECUTIVE HERO BANNER
  ========================================================= --}}
  <div class="gov-hero-banner">
    <i class="bi bi-shield-check gov-hero-pattern"></i>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 position-relative">
      
      {{-- Official Dept Branding --}}
      <div class="d-flex align-items-center gap-3">
        <div class="gov-emblem-box">
          <img src="{{ asset('assets/images/npc_logo.png') }}" alt="Northern Provincial Council">
        </div>
        <div>
          <div class="gov-subtitle-badge">
            <span>Northern Provincial Council • Sri Lanka</span>
          </div>
          <h1 class="gov-title-main">
            Department of Motor Traffic
          </h1>
          <div class="gov-trilingual-tag">
            மோட்டார் போக்குவரத்து திணைக்களம் • Smart Citizen Feedback & Complaint Redressal System
          </div>

          {{-- Quick Officer Shortcuts --}}
          <div class="gov-quick-actions">
            <a href="{{ route('ds-divisions.index') }}" class="gov-action-btn">
              <i class="bi bi-qr-code"></i> Division QRs
            </a>
            <a href="{{ route('admin.feedback.index') }}" class="gov-action-btn">
              <i class="bi bi-star"></i> All Feedbacks
            </a>
            <a href="{{ route('admin.complain.index') }}" class="gov-action-btn">
              <i class="bi bi-exclamation-diamond"></i> Complaints
            </a>
            <a href="{{ route('reports.division-counter-totals') }}" class="gov-action-btn">
              <i class="bi bi-file-earmark-bar-graph"></i> Reports
            </a>
          </div>
        </div>
      </div>

      {{-- Right: Live Date & Role Status --}}
      <div class="d-flex flex-column align-items-md-end gap-1.5">
        <div class="gov-live-pill">
          <span class="pulse-indicator"></span>
          <span>Live Monitoring • {{ now()->format('D, d M Y') }}</span>
        </div>
        <div class="small text-white-50 mt-1">
          Logged Officer: <span class="badge bg-warning text-dark fw-bold px-2 py-0.5 rounded">{{ auth()->user()->role ?? 'Officer' }}</span>
        </div>
      </div>

    </div>
  </div>


  {{-- ==============================================
     1. TOP PERFORMING COUNTERS (TODAY, WEEK, MONTH, YEAR)
  ============================================== --}}
  <div class="dash-section-header">
    <i class="bi bi-trophy-fill text-warning fs-5"></i>
    <span>Top Performing Counters</span>
  </div>

  @php
    $periodsData = [
      'Today' => [$highestToday, 'accent-bar-today'],
      'This Week' => [$highestWeek, 'accent-bar-week'],
      'This Month' => [$highestMonth, 'accent-bar-month'],
      'This Year' => [$highestYear, 'accent-bar-year'],
    ];
  @endphp

  <div class="row g-3">
    @foreach($periodsData as $period => [$data, $accentClass])
    <div class="col-xl-3 col-md-6 col-12">
      <div class="gov-counter-card h-100 d-flex flex-column">
        <div class="card-accent-bar {{ $accentClass }}"></div>
        <div class="p-3 text-center d-flex flex-column justify-content-between flex-grow-1">
          <div>
            <div class="gov-counter-title">
              <i class="bi bi-trophy text-warning"></i>
              <span>Highest Feedback {{ $period }}</span>
            </div>
            <div class="text-muted small mt-1" style="font-size: 11.5px;">
              Division / Counter with most feedback
            </div>
            <div class="gov-counter-name" title="{{ ($data->counter->division_name ?? '-') . ' / ' . ($data->counter->counter_name ?? '-') }}">
              {{ $data->counter->division_name ?? '-' }} / {{ $data->counter->counter_name ?? '-' }}
            </div>
          </div>

          <div class="mt-2">
            <div>
              <span class="gold-feedbacks-badge">
                {{ $data->total ?? 0 }} Feedbacks
              </span>
            </div>
            <div class="fw-bold mt-2" style="font-size: 13.5px; color: #eab308;">
              <i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($data->avg_rating ?? 0, 1) }} / 5.0
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>


  {{-- ==============================================
     2. DASHBOARD OVERVIEW METRICS
  ============================================== --}}
  <div class="dash-section-header mt-4">
    <i class="bi bi-grid-fill text-primary fs-5"></i>
    <span>Department Overview Metrics</span>
  </div>

  <div class="row g-3">
    {{-- Total Feedback --}}
    <div class="col-xl-3 col-md-6 col-12">
      <a href="{{ route('admin.feedback.index') }}" class="text-decoration-none d-block h-100">
        <div class="gov-stat-card">
          <div>
            <div class="gov-stat-num">{{ $totalRatings ?? 0 }}</div>
            <div class="gov-stat-lbl">Total Feedbacks</div>
          </div>
          <div class="gov-icon-box box-emerald">
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- Today's Feedback --}}
    <div class="col-xl-3 col-md-6 col-12">
      <a href="{{ route('admin.feedback.index') }}" class="text-decoration-none d-block h-100">
        <div class="gov-stat-card">
          <div>
            <div class="gov-stat-num">{{ $todayRatings ?? 0 }}</div>
            <div class="gov-stat-lbl">Feedbacks Today</div>
          </div>
          <div class="gov-icon-box box-blue">
            <i class="bi bi-calendar2-check-fill"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- Online Complaints --}}
    <div class="col-xl-3 col-md-6 col-12">
      <a href="{{ route('admin.complain.index') }}" class="text-decoration-none d-block h-100">
        <div class="gov-stat-card">
          <div>
            <div class="gov-stat-num">{{ $totalComplaints ?? 0 }}</div>
            <div class="gov-stat-lbl">Online Complaints</div>
          </div>
          <div class="gov-icon-box box-amber">
            <i class="bi bi-chat-left-dots-fill"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- Manual Feedback --}}
    <div class="col-xl-3 col-md-6 col-12">
      <a href="{{ route('admin.manual-complaints.index') }}" class="text-decoration-none d-block h-100">
        <div class="gov-stat-card">
          <div>
            <div class="gov-stat-num">{{ $totalManualFeedbackCount ?? 0 }}</div>
            <div class="gov-stat-lbl">Manual Complaints</div>
          </div>
          <div class="gov-icon-box box-purple">
            <i class="bi bi-clipboard2-check-fill"></i>
          </div>
        </div>
      </a>
    </div>
  </div>

  {{-- Complaints Quick Status Strip --}}
  <div class="gov-tracker-strip d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-shield-check text-primary fs-5"></i>
      <span class="small fw-bold text-secondary">Complaints Redressal Workflow Tracker:</span>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2">
      <a href="{{ route('admin.complain.index', ['status' => 'pending']) }}" class="tracker-badge-link link-pending">
        <i class="bi bi-clock-history"></i> Pending Initial Review: <strong>{{ $pending ?? 0 }}</strong>
      </a>
      <a href="{{ route('admin.ao.index') }}" class="tracker-badge-link link-ao">
        <i class="bi bi-arrow-right-circle"></i> Under AO Review: <strong>{{ $ao ?? 0 }}</strong>
      </a>
      <a href="{{ route('admin.commissioner.index') }}" class="tracker-badge-link link-commissioner">
        <i class="bi bi-person-badge"></i> At Commissioner Action: <strong>{{ $commissioner ?? 0 }}</strong>
      </a>
    </div>
  </div>


  {{-- ==============================================
     3. TABLES SECTION (LATEST COMPLAINTS & TOP DIVISIONS)
  ============================================== --}}
  <div class="row mt-4 g-3">

    {{-- Latest Complaints Table --}}
    <div class="col-lg-6">
      <div class="gov-table-card h-100 d-flex flex-column">
        <div class="gov-table-header">
          <span class="fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-shield-exclamation text-danger fs-5"></i>
            <span>Latest Citizen Complaints</span>
          </span>

          @php $role = auth()->user()->role; @endphp
          @if($role == 'Administrative Officer')
              <a href="{{ route('admin.ao.index') }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
                  <span>View All</span> <i class="bi bi-arrow-right"></i>
              </a>
          @elseif($role == 'Commissioner')
              <a href="{{ route('admin.commissioner.index') }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
                  <span>View All</span> <i class="bi bi-arrow-right"></i>
              </a>
          @else
              <a href="{{ route('admin.complain.index') }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
                  <span>View All</span> <i class="bi bi-arrow-right"></i>
              </a>
          @endif
        </div>

        <div class="table-responsive flex-grow-1">
          <table class="table gov-data-table mb-0 align-middle">
            <thead>
              <tr>
                <th>Vehicle</th>
                <th>Division</th>
                <th>Rating</th>
                <th>Date & Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($latestComplaints as $complaint)
              <tr>
                <td class="fw-bold">
                  {{ $complaint->vehicle_number ?: '—' }}
                </td>
                <td>
                  {{ $complaint->counter->division_name ?? '-' }}
                </td>
                <td>
                  <span class="text-warning">
                    {{ ['','⭐','⭐⭐','⭐⭐⭐','⭐⭐⭐⭐','⭐⭐⭐⭐⭐'][$complaint->rating] ?? '' }}
                  </span>
                </td>
                <td>
                  <div class="fw-semibold">{{ $complaint->created_at->format('d M Y') }}</div>
                  <small class="text-muted">{{ $complaint->created_at->format('h:i A') }}</small>
                </td>
                <td>
                  @if($complaint->status == null || $complaint->status == 'pending')
                    <span class="gov-status-pill pill-status-pending">Pending</span>
                  @elseif($complaint->status == 'ao')
                    <span class="gov-status-pill pill-status-ao">AO Review</span>
                  @elseif($complaint->status == 'commissioner')
                    <span class="gov-status-pill pill-status-commissioner">Commissioner</span>
                  @elseif($complaint->status == 'completed')
                    <span class="gov-status-pill pill-status-completed">Completed</span>
                  @elseif($complaint->status == 'rejected')
                    <span class="gov-status-pill pill-status-rejected">Rejected</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">
                  <i class="bi bi-inbox d-block fs-3 mb-1"></i>
                  No citizen complaints logged
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Top DS Divisions (Ranking) --}}
    <div class="col-lg-6">
      <div class="gov-table-card h-100 d-flex flex-column">
        <div class="gov-table-header">
          <span class="fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-bar-chart-line-fill text-primary fs-5"></i>
            <span>Top DS Divisions (Service Rating)</span>
          </span>

          <form method="GET" class="d-flex m-0">
            <select name="period" class="form-select form-select-sm" onchange="this.form.submit()">
              <option value="today" {{ request('period')=='today'?'selected':'' }}>Today</option>
              <option value="week" {{ request('period')=='week'?'selected':'' }}>This Week</option>
              <option value="month" {{ request('period')=='month'?'selected':'' }}>This Month</option>
              <option value="year" {{ request('period')=='year'?'selected':'' }}>This Year</option>
            </select>
          </form>
        </div>

        <div class="table-responsive flex-grow-1">
          <table class="table gov-data-table mb-0 align-middle">
            <thead>
              <tr>
                <th style="width: 70px;">Rank</th>
                <th>Division</th>
                <th class="text-end">Citizen Satisfaction</th>
              </tr>
            </thead>
            <tbody>
              @forelse($topDivisions as $index => $division)
              <tr>
                <td>
                  @if($index === 0)
                    <span class="rank-badge-item rb-1" title="1st Place">🥇</span>
                  @elseif($index === 1)
                    <span class="rank-badge-item rb-2" title="2nd Place">🥈</span>
                  @elseif($index === 2)
                    <span class="rank-badge-item rb-3" title="3rd Place">🥉</span>
                  @else
                    <span class="badge bg-light text-muted border px-2 py-1">#{{ $index + 1 }}</span>
                  @endif
                </td>
                <td class="fw-semibold">
                  {{ $division->counter->division_name ?? '-' }}
                </td>
                <td class="text-end fw-bold text-warning">
                  ⭐ {{ number_format($division->avg_rating, 1) }} / 5.0
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" class="text-center py-4 text-muted">
                  <i class="bi bi-bar-chart d-block fs-3 mb-1"></i>
                  No ranking data available for this period
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

</div>

@endsection
