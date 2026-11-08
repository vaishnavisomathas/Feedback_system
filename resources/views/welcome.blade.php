@extends('layouts.app')

@section('title', 'Executive Command Center - PDMT Northern Province')

@section('content')

<style>
/* =========================================================
   EXECUTIVE COMMAND CENTER - PDMT NORTHERN PROVINCE
========================================================= */

/* HERO BANNER */
.gov-hero-banner {
  background: linear-gradient(135deg, #071329 0%, #0f274a 50%, #1e3a8a 100%);
  color: #ffffff;
  border-radius: 16px;
  border-left: 6px solid #f59e0b;
  padding: 24px 28px;
  margin-bottom: 24px;
  box-shadow: 0 8px 24px rgba(10, 31, 68, 0.15);
  position: relative;
  overflow: hidden;
}

[data-bs-theme="dark"] .gov-hero-banner {
  background: linear-gradient(135deg, #040914 0%, #0a192f 50%, #1e3a8a 100%);
  border-left-color: #fbbf24;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

.gov-hero-pattern {
  position: absolute;
  right: -20px;
  top: -30px;
  opacity: 0.05;
  font-size: 200px;
  pointer-events: none;
  color: #ffffff;
}

.gov-emblem-box {
  width: 62px;
  height: 62px;
  background: #ffffff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4px;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
  flex-shrink: 0;
}

.gov-emblem-box img {
  width: 50px;
  height: 50px;
  object-fit: contain;
}

.gov-subtitle-badge {
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: #fbbf24;
  display: flex;
  align-items: center;
  gap: 6px;
}

.gov-title-main {
  font-size: 22px;
  font-weight: 800;
  color: #ffffff;
  letter-spacing: -0.3px;
  margin: 3px 0;
}

.gov-trilingual-tag {
  font-size: 12px;
  color: #cbd5e1;
}

.gov-quick-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-top: 14px;
}

.gov-action-btn {
  background: rgba(255, 255, 255, 0.12);
  color: #ffffff !important;
  font-size: 12px;
  font-weight: 600;
  padding: 6px 14px;
  border-radius: 8px;
  border: 1px solid rgba(255, 255, 255, 0.2);
  text-decoration: none;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

.gov-action-btn:hover {
  background: rgba(255, 255, 255, 0.25);
  transform: translateY(-1px);
}

/* SECTION TITLES */
.dash-section-header {
  font-size: 15px;
  font-weight: 800;
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 22px 0 14px 0;
  color: #0f172a;
  letter-spacing: -0.2px;
}

[data-bs-theme="dark"] .dash-section-header {
  color: #f8fafc;
}

/* TOP PERFORMING COUNTERS */
.gov-counter-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  transition: all 0.22s ease-in-out;
  overflow: hidden;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
}

[data-bs-theme="dark"] .gov-counter-card {
  background: #0f172a;
  border-color: #1e293b;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
}

.gov-counter-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
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
  font-size: 12.5px;
  font-weight: 700;
  color: #475569;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
}

[data-bs-theme="dark"] .gov-counter-title {
  color: #94a3b8;
}

.gov-counter-name {
  font-size: 16px;
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

/* EXECUTIVE METRIC STAT CARDS */
.gov-stat-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  padding: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
  transition: all 0.2s ease;
}

[data-bs-theme="dark"] .gov-stat-card {
  background: #0f172a;
  border-color: #1e293b;
}

.gov-stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(15, 23, 42, 0.07);
}

.gov-stat-num {
  font-size: 26px;
  font-weight: 800;
  color: #0f172a;
  line-height: 1.1;
  letter-spacing: -0.5px;
}

[data-bs-theme="dark"] .gov-stat-num {
  color: #f8fafc;
}

.gov-stat-lbl {
  font-size: 12.5px;
  font-weight: 600;
  color: #64748b;
  margin-top: 4px;
}

.gov-icon-box {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  flex-shrink: 0;
}

.box-blue { background: #eff6ff; color: #2563eb; }
.box-amber { background: #fffbeb; color: #d97706; }
.box-purple { background: #f5f3ff; color: #7c3aed; }
.box-emerald { background: #ecfdf5; color: #059669; }

[data-bs-theme="dark"] .box-blue { background: rgba(37, 99, 235, 0.2); color: #60a5fa; }
[data-bs-theme="dark"] .box-amber { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
[data-bs-theme="dark"] .box-purple { background: rgba(124, 58, 237, 0.2); color: #c4b5fd; }
[data-bs-theme="dark"] .box-emerald { background: rgba(16, 185, 129, 0.2); color: #34d399; }

/* REDRESSAL PIPELINE TRACKER STRIP */
.gov-tracker-strip {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 14px 20px;
  margin-top: 18px;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
}

[data-bs-theme="dark"] .gov-tracker-strip {
  background: #0f172a;
  border-color: #1e293b;
}

.tracker-badge-link {
  font-size: 12.5px;
  font-weight: 700;
  padding: 6px 14px;
  border-radius: 8px;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.18s ease;
}

.link-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
.link-pending:hover { background: #fef3c7; color: #92400e; }

.link-ao { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.link-ao:hover { background: #dbeafe; color: #1e40af; }

.link-commissioner { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }
.link-commissioner:hover { background: #ede9fe; color: #5b21b6; }

[data-bs-theme="dark"] .link-pending { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border-color: rgba(245, 158, 11, 0.3); }
[data-bs-theme="dark"] .link-ao { background: rgba(37, 99, 235, 0.15); color: #60a5fa; border-color: rgba(37, 99, 235, 0.3); }
[data-bs-theme="dark"] .link-commissioner { background: rgba(124, 58, 237, 0.15); color: #c4b5fd; border-color: rgba(124, 58, 237, 0.3); }

/* VISUAL CHARTS CARD */
.gov-chart-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  padding: 20px;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
}

[data-bs-theme="dark"] .gov-chart-card {
  background: #0f172a;
  border-color: #1e293b;
}

.chart-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 16px;
}

.chart-title {
  font-size: 14.5px;
  font-weight: 800;
  color: #0f172a;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

[data-bs-theme="dark"] .chart-title {
  color: #f8fafc;
}

/* DATA TABLES */
.gov-table-card {
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
  overflow: hidden;
}

[data-bs-theme="dark"] .gov-table-card {
  background: #0f172a;
  border-color: #1e293b;
}

.gov-table-header {
  padding: 14px 20px;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

[data-bs-theme="dark"] .gov-table-header {
  background: #141e33;
  border-bottom-color: #1e293b;
}

.gov-data-table th {
  font-size: 12.5px;
  font-weight: 700;
  color: #475569;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  padding: 12px 18px;
}

[data-bs-theme="dark"] .gov-data-table th {
  background: #141e33;
  color: #cbd5e1;
  border-bottom-color: #1e293b;
}

.gov-data-table td {
  padding: 12px 18px;
  font-size: 13.5px;
  border-bottom: 1px solid #f1f5f9;
}

[data-bs-theme="dark"] .gov-data-table td {
  border-bottom-color: #1e293b;
}

/* STATUS PILLS */
.gov-status-pill {
  font-size: 11px;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 20px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.pill-status-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
.pill-status-ao { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.pill-status-commissioner { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }
.pill-status-completed { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
.pill-status-rejected { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

/* LEADERBOARD MEDALS */
.rank-badge-item {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 13px;
}
.rb-1 { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
.rb-2 { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
.rb-3 { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
</style>

<div class="container-fluid px-0">

  {{-- ==============================================
     1. OFFICIAL GOVERNMENT HERO BANNER
  ============================================== --}}
  <div class="gov-hero-banner">
    <i class="bi bi-shield-check gov-hero-pattern"></i>

    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
      <div class="d-flex align-items-center gap-3">
        <div class="gov-emblem-box">
          <img src="{{ asset('assets/images/npc_logo.png') }}" alt="NPC Crest">
        </div>
        <div>
          <div class="gov-subtitle-badge">
            <i class="bi bi-geo-alt-fill"></i> Northern Provincial Council
          </div>
          <h2 class="gov-title-main">Provincial Department of Motor Traffic (PDMT)</h2>
          <div class="gov-trilingual-tag">
            Central Citizen Feedback Monitoring, Service Quality Assessment &amp; Grievance Redressal
          </div>
        </div>
      </div>

      <div class="d-flex flex-column align-items-md-end gap-2">
        <div class="gov-live-pill">
          <span class="pulse-indicator"></span>
          <span>Live Service Network Active</span>
        </div>
        <small class="text-white-50">
          <i class="bi bi-calendar3 me-1"></i>{{ now()->format('l, d F Y') }}
        </small>
      </div>
    </div>

    {{-- Quick Action Buttons --}}
    <div class="gov-quick-actions">
      <a href="{{ route('admin.feedback.index') }}" class="gov-action-btn">
        <i class="bi bi-chat-square-heart"></i> Citizen Feedback
      </a>
      <a href="{{ route('admin.complain.index') }}" class="gov-action-btn">
        <i class="bi bi-exclamation-octagon"></i> QR Complaints
      </a>
      <a href="{{ route('admin.manual-complaints.index') }}" class="gov-action-btn">
        <i class="bi bi-journal-plus"></i> Log Manual Complaint
      </a>
      <a href="{{ route('reports.rating-points') }}" class="gov-action-btn">
        <i class="bi bi-file-earmark-bar-graph"></i> Rating Report
      </a>
      <a href="{{ route('ds-divisions.index') }}" class="gov-action-btn">
        <i class="bi bi-qr-code-scan"></i> Division QR Codes
      </a>
    </div>
  </div>

  {{-- ==============================================
     2. TOP PERFORMING COUNTERS (MILESTONES)
  ============================================== --}}
  <div class="dash-section-header">
    <i class="bi bi-trophy-fill text-warning"></i>
    <span>Top Performing Service Counters</span>
  </div>

  <div class="row g-3">
    {{-- TODAY --}}
    <div class="col-sm-6 col-xl-3">
      <div class="gov-counter-card h-100">
        <div class="card-accent-bar accent-bar-today"></div>
        <div class="p-3 text-center">
          <div class="gov-counter-title">
            <i class="bi bi-sun-fill text-primary"></i> Highest Rated Today
          </div>
          <div class="gov-counter-name" title="{{ $highestToday->counter->counter_name ?? 'No Data' }}">
            {{ $highestToday->counter->counter_name ?? 'None' }}
          </div>
          <div class="small text-muted mb-2">
            {{ $highestToday->counter->division_name ?? 'No ratings yet today' }}
          </div>
          <div class="d-flex align-items-center justify-content-center gap-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
              {{ $highestToday->total ?? 0 }} Reviews
            </span>
            @if(isset($highestToday->avg_rating))
            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fw-bold">
              ★ {{ number_format($highestToday->avg_rating, 1) }}
            </span>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- THIS WEEK --}}
    <div class="col-sm-6 col-xl-3">
      <div class="gov-counter-card h-100">
        <div class="card-accent-bar accent-bar-week"></div>
        <div class="p-3 text-center">
          <div class="gov-counter-title">
            <i class="bi bi-calendar-week-fill text-indigo" style="color: #6366f1;"></i> Highest Rated This Week
          </div>
          <div class="gov-counter-name" title="{{ $highestWeek->counter->counter_name ?? 'No Data' }}">
            {{ $highestWeek->counter->counter_name ?? 'None' }}
          </div>
          <div class="small text-muted mb-2">
            {{ $highestWeek->counter->division_name ?? 'No ratings yet this week' }}
          </div>
          <div class="d-flex align-items-center justify-content-center gap-2">
            <span class="badge bg-indigo-subtle text-primary border rounded-pill" style="background:#e0e7ff; color:#4338ca;">
              {{ $highestWeek->total ?? 0 }} Reviews
            </span>
            @if(isset($highestWeek->avg_rating))
            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fw-bold">
              ★ {{ number_format($highestWeek->avg_rating, 1) }}
            </span>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- THIS MONTH --}}
    <div class="col-sm-6 col-xl-3">
      <div class="gov-counter-card h-100">
        <div class="card-accent-bar accent-bar-month"></div>
        <div class="p-3 text-center">
          <div class="gov-counter-title">
            <i class="bi bi-calendar-month-fill" style="color: #8b5cf6;"></i> Highest Rated This Month
          </div>
          <div class="gov-counter-name" title="{{ $highestMonth->counter->counter_name ?? 'No Data' }}">
            {{ $highestMonth->counter->counter_name ?? 'None' }}
          </div>
          <div class="small text-muted mb-2">
            {{ $highestMonth->counter->division_name ?? 'No ratings yet this month' }}
          </div>
          <div class="d-flex align-items-center justify-content-center gap-2">
            <span class="badge rounded-pill" style="background:#ede9fe; color:#6d28d9;">
              {{ $highestMonth->total ?? 0 }} Reviews
            </span>
            @if(isset($highestMonth->avg_rating))
            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fw-bold">
              ★ {{ number_format($highestMonth->avg_rating, 1) }}
            </span>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- THIS YEAR --}}
    <div class="col-sm-6 col-xl-3">
      <div class="gov-counter-card h-100">
        <div class="card-accent-bar accent-bar-year"></div>
        <div class="p-3 text-center">
          <div class="gov-counter-title">
            <i class="bi bi-award-fill text-warning"></i> Champion Counter {{ date('Y') }}
          </div>
          <div class="gov-counter-name" title="{{ $highestYear->counter->counter_name ?? 'No Data' }}">
            {{ $highestYear->counter->counter_name ?? 'None' }}
          </div>
          <div class="small text-muted mb-2">
            {{ $highestYear->counter->division_name ?? 'Annual cumulative leader' }}
          </div>
          <div class="d-flex align-items-center justify-content-center gap-2">
            <span class="badge rounded-pill" style="background:#fef3c7; color:#b45309;">
              {{ $highestYear->total ?? 0 }} Reviews
            </span>
            @if(isset($highestYear->avg_rating))
            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fw-bold">
              ★ {{ number_format($highestYear->avg_rating, 1) }}
            </span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ==============================================
     3. EXECUTIVE METRIC KPI CARDS
  ============================================== --}}
  <div class="dash-section-header">
    <i class="bi bi-speedometer2 text-primary"></i>
    <span>Citizen Feedback &amp; Grievance Metrics</span>
  </div>

  <div class="row g-3">
    {{-- TOTAL RATINGS --}}
    <div class="col-sm-6 col-xl-3">
      <a href="{{ route('admin.feedback.index') }}" class="text-decoration-none">
        <div class="gov-stat-card">
          <div>
            <div class="gov-stat-num">{{ number_format($totalRatings ?? 0) }}</div>
            <div class="gov-stat-lbl">Total Citizen Ratings</div>
            <div class="d-flex align-items-center gap-2 mt-2">
              <span class="badge bg-emerald-subtle text-success border border-success-subtle rounded-pill" style="font-size: 11px;">
                ★ {{ $overallAvgRating ?? '0.0' }} / 5.0
              </span>
              <span class="small text-muted" style="font-size: 11px;">{{ $satisfactionPercentage ?? 0 }}% Positive</span>
            </div>
          </div>
          <div class="gov-icon-box box-blue">
            <i class="bi bi-star-fill"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- TOTAL QR COMPLAINTS --}}
    <div class="col-sm-6 col-xl-3">
      <a href="{{ route('admin.complain.index') }}" class="text-decoration-none">
        <div class="gov-stat-card">
          <div>
            <div class="gov-stat-num text-danger">{{ number_format($totalComplaints ?? 0) }}</div>
            <div class="gov-stat-lbl">QR Grievances Logged</div>
            <div class="small text-muted mt-2" style="font-size: 11px;">
              Requires administrative action
            </div>
          </div>
          <div class="gov-icon-box box-amber">
            <i class="bi bi-shield-exclamation"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- TOTAL MANUAL COMPLAINTS --}}
    <div class="col-sm-6 col-xl-3">
      <a href="{{ route('admin.manual-complaints.index') }}" class="text-decoration-none">
        <div class="gov-stat-card">
          <div>
            <div class="gov-stat-num">{{ number_format($totalManualFeedbackCount ?? 0) }}</div>
            <div class="gov-stat-lbl">Manual Grievances Logged</div>
            <div class="small text-muted mt-2" style="font-size: 11px;">
              Walk-in / Letters / In-person
            </div>
          </div>
          <div class="gov-icon-box box-purple">
            <i class="bi bi-journal-text"></i>
          </div>
        </div>
      </a>
    </div>

    {{-- MONTH-TO-DATE VOLUME --}}
    <div class="col-sm-6 col-xl-3">
      <div class="gov-stat-card">
        <div>
          <div class="gov-stat-num">{{ number_format($monthRatings ?? 0) }}</div>
          <div class="gov-stat-lbl">Volume This Month</div>
          <div class="small text-muted mt-2" style="font-size: 11px;">
            Today: <strong>{{ number_format($todayRatings ?? 0) }}</strong> responses
          </div>
        </div>
        <div class="gov-icon-box box-emerald">
          <i class="bi bi-graph-up-arrow"></i>
        </div>
      </div>
    </div>
  </div>

  {{-- ==============================================
     4. COMPLAINTS WORKFLOW PIPELINE TRACKER
  ============================================== --}}
  <div class="gov-tracker-strip d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-shield-check text-primary fs-5"></i>
      <span class="small fw-bold text-secondary">Complaints Redressal Lifecycle Tracker:</span>
    </div>
    <div class="d-flex flex-wrap align-items-center gap-2">
      <a href="{{ route('admin.complain.index', ['status' => 'pending']) }}" class="tracker-badge-link link-pending">
        <i class="bi bi-clock-history"></i> Pending Initial Review: <strong>{{ $pending ?? 0 }}</strong>
      </a>
      <a href="{{ route('admin.ao.index') }}" class="tracker-badge-link link-ao">
        <i class="bi bi-arrow-right-circle"></i> Under AO Investigation: <strong>{{ $ao ?? 0 }}</strong>
      </a>
      <a href="{{ route('admin.commissioner.index') }}" class="tracker-badge-link link-commissioner">
        <i class="bi bi-award"></i> At Commissioner Action: <strong>{{ $commissioner ?? 0 }}</strong>
      </a>
    </div>
  </div>

  {{-- ==============================================
     5. VISUAL ANALYTICS CHARTS (INTERACTIVE CHART.JS)
  ============================================== --}}
  <div class="row mt-4 g-3">
    {{-- CHART 1: 6-MONTH TRENDS --}}
    <div class="col-lg-8">
      <div class="gov-chart-card h-100">
        <div class="chart-header">
          <h5 class="chart-title">
            <i class="bi bi-graph-up text-primary"></i>
            <span>Citizen Feedback &amp; Grievance Volume Trend (Last 6 Months)</span>
          </h5>
          <span class="badge bg-light text-muted border px-2 py-1 small">Monthly Aggregation</span>
        </div>
        <div style="position: relative; height: 280px; width: 100%;">
          <canvas id="feedbackTrendChart"></canvas>
        </div>
      </div>
    </div>

    {{-- CHART 2: RATING DISTRIBUTION --}}
    <div class="col-lg-4">
      <div class="gov-chart-card h-100">
        <div class="chart-header">
          <h5 class="chart-title">
            <i class="bi bi-pie-chart text-warning"></i>
            <span>Citizen Rating Distribution</span>
          </h5>
          <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1 small">1 to 5 Stars</span>
        </div>
        <div style="position: relative; height: 280px; width: 100%;">
          <canvas id="ratingDistributionChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- ==============================================
     6. TABLES (LATEST COMPLAINTS & TOP DIVISIONS)
  ============================================== --}}
  <div class="row mt-4 g-3">

    {{-- LATEST CITIZEN COMPLAINTS --}}
    <div class="col-lg-7">
      <div class="gov-table-card h-100 d-flex flex-column">
        <div class="gov-table-header">
          <span class="fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-shield-exclamation text-danger fs-5"></i>
            <span>Recent Citizen Complaints</span>
          </span>

          @php $role = auth()->user()->role ?? ''; @endphp
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
                <th>Vehicle Reg.</th>
                <th>Division Counter</th>
                <th>Rating</th>
                <th>Date &amp; Time</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($latestComplaints as $complaint)
              <tr>
                <td class="fw-bold text-dark">
                  {{ $complaint->vehicle_number ?: '-' }}
                </td>
                <td>
                  <span class="fw-semibold">{{ $complaint->counter->division_name ?? '-' }}</span>
                  <small class="text-muted d-block">{{ $complaint->counter->counter_name ?? '' }}</small>
                </td>
                <td>
                  <span class="text-warning fw-bold">
                    {{ str_repeat('★', (int) ($complaint->rating ?? 0)) }}
                  </span>
                </td>
                <td>
                  <div class="fw-semibold">{{ $complaint->created_at->format('d M Y') }}</div>
                  <small class="text-muted">{{ $complaint->created_at->format('h:i A') }}</small>
                </td>
                <td>
                  @if($complaint->status == null || $complaint->status == 'pending')
                    <span class="gov-status-pill pill-status-pending"><i class="bi bi-clock"></i> Pending</span>
                  @elseif($complaint->status == 'ao')
                    <span class="gov-status-pill pill-status-ao"><i class="bi bi-shield"></i> AO Review</span>
                  @elseif($complaint->status == 'commissioner')
                    <span class="gov-status-pill pill-status-commissioner"><i class="bi bi-award"></i> Commissioner</span>
                  @elseif($complaint->status == 'completed')
                    <span class="gov-status-pill pill-status-completed"><i class="bi bi-check-circle"></i> Resolved</span>
                  @elseif($complaint->status == 'rejected')
                    <span class="gov-status-pill pill-status-rejected"><i class="bi bi-x-circle"></i> Rejected</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">
                  <i class="bi bi-inbox d-block fs-3 mb-1 text-secondary opacity-50"></i>
                  No citizen complaints logged yet
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- TOP DS DIVISIONS RANKING --}}
    <div class="col-lg-5">
      <div class="gov-table-card h-100 d-flex flex-column">
        <div class="gov-table-header">
          <span class="fw-bold text-dark d-flex align-items-center gap-2">
            <i class="bi bi-bar-chart-line-fill text-primary fs-5"></i>
            <span>Division Satisfaction Ranking</span>
          </span>

          <form method="GET" class="d-flex m-0">
            <select name="period" class="form-select form-select-sm" onchange="this.form.submit()" style="font-size: 12px; border-radius: 8px;">
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
                <th style="width: 60px;">Rank</th>
                <th>Division / Office</th>
                <th class="text-end">Citizen Score</th>
              </tr>
            </thead>
            <tbody>
              @forelse($topDivisions as $index => $division)
              <tr>
                <td>
                  @if($index === 0)
                    <span class="rank-badge-item rb-1" title="1st Place">1</span>
                  @elseif($index === 1)
                    <span class="rank-badge-item rb-2" title="2nd Place">2</span>
                  @elseif($index === 2)
                    <span class="rank-badge-item rb-3" title="3rd Place">3</span>
                  @else
                    <span class="badge bg-light text-muted border px-2 py-1">#{{ $index + 1 }}</span>
                  @endif
                </td>
                <td class="fw-semibold">
                  {{ $division->counter->division_name ?? '-' }}
                </td>
                <td class="text-end fw-bold text-warning">
                  ★ {{ number_format($division->avg_rating, 1) }} <small class="text-muted fw-normal">/ 5.0</small>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" class="text-center py-4 text-muted">
                  <i class="bi bi-bar-chart d-block fs-3 mb-1 text-secondary opacity-50"></i>
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

@php
  $ratingDist = $ratingDistribution ?? [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
@endphp
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
  const textColor = isDark ? '#cbd5e1' : '#475569';
  const gridColor = isDark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(0, 0, 0, 0.06)';

  // 1. FEEDBACK TRENDS CHART
  const trendLabels = {!! json_encode($trendLabels ?? []) !!};
  const trendRatings = {!! json_encode($trendRatings ?? []) !!};
  const trendComplaints = {!! json_encode($trendComplaints ?? []) !!};

  const trendCtx = document.getElementById('feedbackTrendChart');
  if (trendCtx && typeof Chart !== 'undefined') {
    new Chart(trendCtx, {
      type: 'line',
      data: {
        labels: trendLabels.length ? trendLabels : ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        datasets: [
          {
            label: 'Total Feedback',
            data: trendRatings.length ? trendRatings : [12, 19, 15, 22, 28, 35],
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, 0.12)',
            fill: true,
            tension: 0.35,
            borderWidth: 3,
            pointBackgroundColor: '#2563eb',
            pointRadius: 4,
          },
          {
            label: 'Grievances / Complaints',
            data: trendComplaints.length ? trendComplaints : [2, 3, 1, 4, 2, 5],
            borderColor: '#ef4444',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            fill: true,
            tension: 0.35,
            borderWidth: 2,
            pointBackgroundColor: '#ef4444',
            pointRadius: 4,
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: { color: textColor, font: { family: 'Plus Jakarta Sans', weight: '600', size: 12 } }
          },
          tooltip: {
            padding: 10,
            cornerRadius: 8,
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 11 } }
          },
          y: {
            beginAtZero: true,
            grid: { color: gridColor },
            ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 11 }, precision: 0 }
          }
        }
      }
    });
  }

  // 2. RATING DISTRIBUTION DOUGHNUT CHART
  const ratingDist = {!! json_encode($ratingDist) !!};
  const distCtx = document.getElementById('ratingDistributionChart');

  if (distCtx && typeof Chart !== 'undefined') {
    new Chart(distCtx, {
      type: 'doughnut',
      data: {
        labels: ['5 Stars (Excellent)', '4 Stars (Good)', '3 Stars (Average)', '2 Stars (Poor)', '1 Star (Very Poor)'],
        datasets: [{
          data: [
            ratingDist[5] || 0,
            ratingDist[4] || 0,
            ratingDist[3] || 0,
            ratingDist[2] || 0,
            ratingDist[1] || 0
          ],
          backgroundColor: [
            '#10b981', // 5 Stars Emerald
            '#3b82f6', // 4 Stars Blue
            '#f59e0b', // 3 Stars Amber
            '#f97316', // 2 Stars Orange
            '#ef4444'  // 1 Star Red
          ],
          borderWidth: isDark ? 2 : 1,
          borderColor: isDark ? '#0f172a' : '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              boxWidth: 12,
              padding: 10,
              color: textColor,
              font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' }
            }
          }
        }
      }
    });
  }
});
</script>
@endsection
