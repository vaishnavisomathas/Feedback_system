<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Counter;
use App\Models\ManualComplaint;
use App\Models\ManualComplaintSource;
use App\Models\ComplainType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   public function index()
    {
        // Total Ratings
        $totalRatings = Feedback::count();
        $totalComplaints = Feedback::whereNotNull('note')
            ->where('note', '!=', '')
            ->count();
        $totalManualFeedbackCount = ManualComplaint::count();

    $todayRatings = Feedback::whereDate('created_at', now())->count();

    $monthRatings = Feedback::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();

    // ================= TODAY =================
    $highestToday = Feedback::select(
            'counter_id',
            DB::raw('COUNT(*) as total'),
            DB::raw('AVG(rating) as avg_rating')
        )
        ->whereDate('created_at', now())
        ->groupBy('counter_id')
        ->with('counter')
        ->orderByDesc('total')
        ->first();

    // ================= MONTH =================
    $highestMonth = Feedback::select(
            'counter_id',
            DB::raw('COUNT(*) as total'),
            DB::raw('AVG(rating) as avg_rating')
        )
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->groupBy('counter_id')
        ->with('counter')
        ->orderByDesc('total')
        ->first();

    // ================= WEEK =================
    $highestWeek = Feedback::select(
            'counter_id',
            DB::raw('COUNT(*) as total'),
            DB::raw('AVG(rating) as avg_rating')
        )
        ->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])
        ->groupBy('counter_id')
        ->with('counter')
        ->orderByDesc('total')
        ->first();
   $latestComplaints = Feedback::with('counter')
        ->latest()
        ->limit(5)
        ->get();

$pending = \App\Models\Feedback::where('status', 'pending')
            ->whereNotNull('note')
            ->where('note', '!=', '')
            ->count();
            $ao = \App\Models\Feedback::where('status','ao')->count();
    $commissioner = \App\Models\Feedback::where('status','commissioner')->count();
$period = request('period','today');

$query = Feedback::query();

if($period == 'today'){
    $query->whereDate('created_at', today());
}

elseif($period == 'week'){
    $query->whereBetween('created_at', [
        now()->startOfWeek(),
        now()->endOfWeek()
    ]);
}

elseif($period == 'month'){
    $query->whereMonth('created_at', now()->month);
}

elseif($period == 'year'){
    $query->whereYear('created_at', now()->year);
}

$topDivisions = $query
->selectRaw('counter_id, AVG(rating) as avg_rating')
->groupBy('counter_id')
->orderByDesc('avg_rating')
->with('counter')
->take(5)
->get();
        return view('welcome', compact(
            'totalRatings',
            'totalComplaints',
            'totalManualFeedbackCount',
            'todayRatings',
            'monthRatings',
            'highestToday',
            'highestMonth',
            'highestWeek',
            'latestComplaints',
            'topDivisions',
            'pending','ao','commissioner'
        ));
    }

    public function ratingPointsReport(Request $request)
    {
        $roleKey = strtolower(trim((string) auth()->user()->role));

        if (!in_array($roleKey, ['super admin', 'admin', 'commissioner', 'commisioner','user','administrative officer'], true)) {
            abort(403, 'Unauthorized action.');
        }

        $period = $request->get('period', 'today');
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $selectedYear = (int) $request->get('year', now()->year);
        $selectedDivision = $request->get('division');
        $selectedFrom = $request->get('from');
        $selectedTo = $request->get('to');
       $perPage = (int) $request->get('per_page', 10);

if (!in_array($perPage, [10, 20, 50, 100], true)) {
    $perPage = 10;
}

        $baseQuery = Feedback::query()->whereNotNull('counter_id');

        if (!empty($selectedFrom) || !empty($selectedTo)) {
            try {
                $fromDate = !empty($selectedFrom) ? Carbon::parse($selectedFrom)->toDateString() : null;
            } catch (\Throwable $e) {
                $fromDate = null;
                $selectedFrom = null;
            }

            try {
                $toDate = !empty($selectedTo) ? Carbon::parse($selectedTo)->toDateString() : null;
            } catch (\Throwable $e) {
                $toDate = null;
                $selectedTo = null;
            }

            if (!empty($fromDate) && !empty($toDate) && $fromDate > $toDate) {
                [$fromDate, $toDate] = [$toDate, $fromDate];
                [$selectedFrom, $selectedTo] = [$selectedTo, $selectedFrom];
            }

            if (!empty($fromDate)) {
                $baseQuery->whereDate('created_at', '>=', $fromDate);
            }

            if (!empty($toDate)) {
                $baseQuery->whereDate('created_at', '<=', $toDate);
            }
        } elseif ($period === 'month') {
            try {
                $monthDate = Carbon::createFromFormat('Y-m', $selectedMonth);
            } catch (\Throwable $e) {
                $monthDate = now();
                $selectedMonth = $monthDate->format('Y-m');
            }

            $baseQuery->whereYear('created_at', $monthDate->year)
                ->whereMonth('created_at', $monthDate->month);
        } elseif ($period === 'year') {
            if ($selectedYear < 2000 || $selectedYear > 2100) {
                $selectedYear = (int) now()->year;
            }

            $baseQuery->whereYear('created_at', $selectedYear);
        } else {
            $period = 'today';
            $baseQuery->whereDate('created_at', now());
        }

        if (!empty($selectedDivision)) {
            $baseQuery->whereHas('counter', function ($query) use ($selectedDivision) {
                $query->where('division_name', $selectedDivision);
            });
        }

        $rankingQuery = (clone $baseQuery)
            ->select(
                'counter_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(rating) as avg_rating')
            )
            ->groupBy('counter_id')
            ->with('counter')
            ->orderByDesc('avg_rating');
$ranking = (clone $rankingQuery)
    ->paginate($perPage)
    ->withQueryString();

        $highest = (clone $rankingQuery)->first();
        $divisions = Counter::select('division_name')
            ->whereNotNull('division_name')
            ->distinct()
            ->orderBy('division_name')
            ->pluck('division_name');

        return view('reports.rating_points', compact(
            'ranking',
            'highest',
            'period',
            'selectedMonth',
            'selectedYear',
            'selectedDivision',
            'selectedFrom',
            'selectedTo',
            'perPage',
            'divisions'
        ));
    }

    public function ratingPointsReportPdf(Request $request)
    {
        $roleKey = strtolower(trim((string) auth()->user()->role));

        if (!in_array($roleKey, ['super admin', 'admin', 'commissioner', 'commisioner','user','administrative officer'], true)) {
            abort(403, 'Unauthorized action.');
        }

        $period = $request->get('period', 'today');
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $selectedYear = (int) $request->get('year', now()->year);
        $selectedDivision = $request->get('division');
        $selectedFrom = $request->get('from');
        $selectedTo = $request->get('to');

        $baseQuery = Feedback::query()->whereNotNull('counter_id');

        if (!empty($selectedFrom) || !empty($selectedTo)) {
            try {
                $fromDate = !empty($selectedFrom) ? Carbon::parse($selectedFrom)->toDateString() : null;
            } catch (\Throwable $e) {
                $fromDate = null;
            }

            try {
                $toDate = !empty($selectedTo) ? Carbon::parse($selectedTo)->toDateString() : null;
            } catch (\Throwable $e) {
                $toDate = null;
            }

            if (!empty($fromDate) && !empty($toDate) && $fromDate > $toDate) {
                [$fromDate, $toDate] = [$toDate, $fromDate];
            }

            if (!empty($fromDate)) {
                $baseQuery->whereDate('created_at', '>=', $fromDate);
            }

            if (!empty($toDate)) {
                $baseQuery->whereDate('created_at', '<=', $toDate);
            }
        } elseif ($period === 'month') {
            try {
                $monthDate = Carbon::createFromFormat('Y-m', $selectedMonth);
            } catch (\Throwable $e) {
                $monthDate = now();
            }

            $baseQuery->whereYear('created_at', $monthDate->year)
                ->whereMonth('created_at', $monthDate->month);
        } elseif ($period === 'year') {
            if ($selectedYear < 2000 || $selectedYear > 2100) {
                $selectedYear = (int) now()->year;
            }

            $baseQuery->whereYear('created_at', $selectedYear);
        } else {
            $baseQuery->whereDate('created_at', now());
        }

        if (!empty($selectedDivision)) {
            $baseQuery->whereHas('counter', function ($query) use ($selectedDivision) {
                $query->where('division_name', $selectedDivision);
            });
        }

        $ranking = $baseQuery
            ->select(
                'counter_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('AVG(rating) as avg_rating')
            )
            ->groupBy('counter_id')
            ->with('counter')
            ->orderByDesc('avg_rating')
            ->get();

        $html = view('reports.rating_points_pdf', compact(
            'ranking',
            'period',
            'selectedMonth',
            'selectedYear',
            'selectedDivision',
            'selectedFrom',
            'selectedTo'
        ))->render();

        $pdf = app('dompdf.wrapper')->loadHTML($html);

        return $pdf->download('Rating_Points_Report_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    public function manualComplaintReport(Request $request)
    {
        $this->authorizeManualComplaintReport();

        $query = $this->manualComplaintReportQuery($request);
        $perPage = (int) $request->get('per_page', 10);
        if (!in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 10;
        }

        $summaryQuery = clone $query;
        $summary = [
            'total' => (clone $summaryQuery)->count(),
            'pending' => (clone $summaryQuery)->whereIn('status', ['pending', 'ao'])->count(),
            'commissioner' => (clone $summaryQuery)->where('status', 'commissioner')->count(),
            'completed' => (clone $summaryQuery)->where('status', 'completed')->count(),
        ];

        $complaints = $query->latest('created_at')->paginate($perPage)->withQueryString();
        $sources = ManualComplaintSource::where('is_active', true)->orderBy('name')->get();

        return view('reports.manual_complaints', compact('complaints', 'sources', 'summary', 'perPage'));
    }

public function manualComplaintReportPdf(Request $request)
{
    $this->authorizeManualComplaintReport();

    $complaints = $this->manualComplaintReportQuery($request)
        ->latest('created_at')
        ->get();

    $html = view(
        'reports.manual_complaints_pdf',
        compact('complaints')
    )->render();

    $pdf = app('dompdf.wrapper');

    $pdf->setOptions([
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'defaultFont' => 'NotoSansTamil',
    ]);

    $pdf->loadHTML($html)
        ->setPaper('a4', 'landscape');

    return $pdf->download(
        'Manual_Complaint_Report_' .
        now()->format('Y-m-d_H-i-s') .
        '.pdf'
    );
}

    private function authorizeManualComplaintReport(): void
    {
        $role = strtolower(trim((string) auth()->user()->role));
        $allowed = ['super admin', 'admin', 'user', 'administrative officer', 'a/o', 'ao', 'commissioner', 'commisioner'];

        if (!in_array($role, $allowed, true)) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function manualComplaintReportQuery(Request $request)
    {
        return ManualComplaint::with(['sourceSetting', 'complainType', 'enteredByUser'])
            ->when($request->filled('source_id'), fn ($query) => $query->where('source_id', $request->source_id))
            ->when($request->filled('status'), function ($query) use ($request) {
                $request->status === 'pending'
                    ? $query->whereIn('status', ['pending', 'ao'])
                    : $query->where('status', $request->status);
            })
            ->when($request->filled('from'), fn ($query) => $query->whereDate('received_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($query) => $query->whereDate('received_at', '<=', $request->to))
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = $request->search;
                $query->where(function ($subQuery) use ($term) {
                    $subQuery->where('complainant_name', 'like', "%{$term}%")
                        ->orWhere('phone', 'like', "%{$term}%")
                        ->orWhere('vehicle_number', 'like', "%{$term}%")
                        ->orWhere('complaint', 'like', "%{$term}%");
                });
            });
    }

    public function qrComplaintReport(Request $request)
    {
        $this->authorizeComplaintReport();

        $query = $this->qrComplaintReportQuery($request);
        $perPage = (int) $request->get('per_page', 10);
        if (!in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 10;
        }

        $summary = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 'pending');
            })->count(),
            'ao' => (clone $query)->where('status', 'ao')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
        ];

        $complaints = $query->latest('created_at')->paginate($perPage)->withQueryString();
        $counters = Counter::orderBy('division_name')->orderBy('counter_name')->get();
        $types = ComplainType::orderBy('name')->get();

        return view('reports.qr_complaints', compact(
            'complaints', 'counters', 'types', 'summary', 'perPage'
        ));
    }

    public function qrComplaintReportPdf(Request $request)
    {
        $this->authorizeComplaintReport();

        $complaints = $this->qrComplaintReportQuery($request)
            ->latest('created_at')
            ->get();

        $html = view('reports.qr_complaints_pdf', compact('complaints'))->render();
        $pdf = app('dompdf.wrapper');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'NotoSansTamil',
        ]);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');

        return $pdf->download('QR_Complaint_Report_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    private function authorizeComplaintReport(): void
    {
        $role = strtolower(trim((string) auth()->user()->role));
        $allowed = ['super admin', 'admin', 'user', 'administrative officer', 'a/o', 'ao', 'commissioner', 'commisioner'];

        if (!in_array($role, $allowed, true)) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function qrComplaintReportQuery(Request $request)
    {
        return Feedback::with(['counter', 'complainType', 'serviceQuality'])
            ->whereNotNull('note')
            ->where('note', '!=', '')
            ->when($request->filled('counter'), fn ($q) => $q->where('counter_id', $request->counter))
            ->when($request->filled('status'), function ($q) use ($request) {
                $request->status === 'pending'
                    ? $q->where(function ($sub) {
                        $sub->whereNull('status')->orWhere('status', 'pending');
                    })
                    : $q->where('status', $request->status);
            })
            ->when($request->filled('complain_type'), fn ($q) => $q->where('complain_type_id', $request->complain_type))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->to))
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = $request->search;
                $q->where(function ($sub) use ($term) {
                    $sub->where('phone', 'like', "%{$term}%")
                        ->orWhere('complaint_email', 'like', "%{$term}%")
                        ->orWhere('vehicle_number', 'like', "%{$term}%")
                        ->orWhere('note', 'like', "%{$term}%");
                });
            });
    }

    public function divisionCounterTotalReport(Request $request)
    {
        $this->authorizeComplaintReport();

        $perPage = (int) $request->get('per_page', 10);
        if (!in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 10;
        }

        $query = $this->divisionCounterTotalQuery($request);
        $grandTotals = DB::query()->fromSub(clone $query, 'counter_totals')->selectRaw(
            'COALESCE(SUM(total_count), 0) as total_count, COALESCE(SUM(complaint_count), 0) as complaint_count, COALESCE(SUM(feedback_only_count), 0) as feedback_only_count'
        )->first();
        $rows = $query->paginate($perPage)->withQueryString();
        $divisions = Counter::whereNotNull('division_name')->distinct()->orderBy('division_name')->pluck('division_name');
        $counters = Counter::orderBy('division_name')->orderBy('counter_name')->get();

        return view('reports.division_counter_totals', compact(
            'rows', 'grandTotals', 'divisions', 'counters', 'perPage'
        ));
    }

    public function divisionCounterTotalReportPdf(Request $request)
    {
        $this->authorizeComplaintReport();

        $rows = $this->divisionCounterTotalQuery($request)->get();
        $grandTotals = (object) [
            'total_count' => $rows->sum('total_count'),
            'complaint_count' => $rows->sum('complaint_count'),
            'feedback_only_count' => $rows->sum('feedback_only_count'),
        ];
        $html = view('reports.division_counter_totals_pdf', compact('rows', 'grandTotals'))->render();
        $pdf = app('dompdf.wrapper')->loadHTML($html)->setPaper('a4', 'portrait');

        return $pdf->download('Division_Counter_Total_Report_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    private function divisionCounterTotalQuery(Request $request)
    {
        return Feedback::query()
            ->join('counters', 'counters.id', '=', 'feedbacks.counter_id')
            ->select(
                'feedbacks.counter_id',
                'counters.division_name',
                'counters.counter_name'
            )
            ->selectRaw('COUNT(feedbacks.id) as total_count')
            ->selectRaw("SUM(CASE WHEN feedbacks.note IS NOT NULL AND feedbacks.note != '' THEN 1 ELSE 0 END) as complaint_count")
            ->selectRaw("SUM(CASE WHEN feedbacks.note IS NULL OR feedbacks.note = '' THEN 1 ELSE 0 END) as feedback_only_count")
            ->when($request->filled('division'), fn ($q) => $q->where('counters.division_name', $request->division))
            ->when($request->filled('counter'), fn ($q) => $q->where('feedbacks.counter_id', $request->counter))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('feedbacks.created_at', '>=', $request->from))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('feedbacks.created_at', '<=', $request->to))
            ->groupBy('feedbacks.counter_id', 'counters.division_name', 'counters.counter_name')
            ->orderBy('counters.division_name')
            ->orderBy('counters.counter_name');
    }

}
