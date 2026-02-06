<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Feedback;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CounterController extends Controller
{
  public function index()
    {
        $counters = Counter::latest()->get();
        return view('admin.counter.index', compact('counters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'district' => 'required|string|max:255',
            'division_name' => 'required|string|max:255',
        ]);

        Counter::create($request->all());

        return redirect()->back()->with('success', 'Counter created successfully.');
    }

    public function update(Request $request, Counter $counter)
    {
        $request->validate([
            'district' => 'required|string|max:255',
            'division_name' => 'required|string|max:255',
            'counter_name' => 'required|string|max:255',
        ]);

        $counter->update($request->all());

        return redirect()->back()->with('success', 'Counter updated successfully.');
    }

    public function destroy(Counter $counter)
    {
        $counter->delete();
        return redirect()->back()->with('success', 'Counter deleted successfully.');
    }
  

public function feedback_index(Request $request)
{
    $ratings = Feedback::with('counter')

        // SEARCH (grouped OR conditions)
        ->when($request->filled('search'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->where('vehicle_number', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%')
                      ->orWhere('note', 'like', '%' . $request->search . '%');
            });
        })

        // COUNTER FILTER
        ->when($request->filled('counter'), function ($q) use ($request) {
            $q->where('counter_id', $request->counter);
        })

        // DATE FILTERS
        ->when($request->filled('start_date'), function ($q) use ($request) {
            $q->whereDate('created_at', '>=', $request->start_date);
        })
        ->when($request->filled('end_date'), function ($q) use ($request) {
            $q->whereDate('created_at', '<=', $request->end_date);
        })

        ->latest()
        ->paginate(10)
        ->withQueryString();

    $counters = Counter::orderBy('division_name')->get();

    return view('admin.feed_back.index', compact('ratings', 'counters'));
}
public function downloadPdf(Request $request)
    {
        $ratings = Feedback::with('counter')

            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('vehicle_number', 'like', '%' . $request->search . '%')
                          ->orWhere('phone', 'like', '%' . $request->search . '%')
                          ->orWhere('note', 'like', '%' . $request->search . '%');
                });
            })

            ->when($request->filled('counter'), fn ($q) =>
                $q->where('counter_id', $request->counter)
            )

            ->when($request->filled('start_date'), fn ($q) =>
                $q->whereDate('created_at', '>=', $request->start_date)
            )

            ->when($request->filled('end_date'), fn ($q) =>
                $q->whereDate('created_at', '<=', $request->end_date)
            )

            ->latest()
            ->get();

        $pdf = Pdf::loadView('admin.feed_back.pdf', [
            'ratings' => $ratings,
            'printedAt' => now()->timezone('Asia/Colombo'),
        ]);

        return $pdf->download('feedback_report.pdf');
    }

}
