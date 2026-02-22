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


$pending = \App\Models\Feedback::where('status', 'pending')
            ->whereNotNull('note')
            ->where('note', '!=', '')
            ->count();    
            $ao = \App\Models\Feedback::where('status','ao')->count();
    $commissioner = \App\Models\Feedback::where('status','commissioner')->count();

        return view('welcome', compact(
            'totalRatings',
            'todayRatings',
            'monthRatings',
            'highestToday',
            'highestMonth',
            'highestYear',
            
            'pending','ao','commissioner'
        ));
    }
    }

