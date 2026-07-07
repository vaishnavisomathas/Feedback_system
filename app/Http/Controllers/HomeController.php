<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Counter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   public function index()
    {
        // Total Ratings
        $totalRatings = Feedback::count();

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

    // ================= YEAR =================
    $highestYear = Feedback::select(
            'counter_id',
            DB::raw('COUNT(*) as total'),
            DB::raw('AVG(rating) as avg_rating')
        )
        ->whereYear('created_at', now()->year)
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
            'todayRatings',
            'monthRatings',
            'highestToday',
            'highestMonth',
            'highestYear',
            'latestComplaints',
            'topDivisions',
            'pending','ao','commissioner'
        ));
    }

    public function ratingPointsReport(Request $request)
    {
        $roleKey = strtolower(trim((string) auth()->user()->role));

        if (!in_array($roleKey, ['super admin', 'admin', 'commissioner', 'commisioner'], true)) {
            abort(403, 'Unauthorized action.');
        }

        $period = $request->get('period', 'today');
        $selectedMonth = $request->get('month', now()->format('Y-m'));
        $selectedYear = (int) $request->get('year', now()->year);
        $selectedDivision = $request->get('division');
        $selectedFrom = $request->get('from');
        $selectedTo = $request->get('to');
        $perPage = (int) $request->get('per_page', 20);

        if (!in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 20;
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
            ->orderByDesc('total');

        $ranking = (clone $rankingQuery)
            ->paginate($perPage)
            ->appends($request->query());

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
}

