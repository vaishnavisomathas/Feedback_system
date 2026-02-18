<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Feedback;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CounterController extends Controller
{
 public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);

    $counters = Counter::latest()
        ->paginate($perPage)
        ->withQueryString(); // keeps filters in pagination links

    return view('admin.counter.index', compact('counters'));
}


public function store(Request $request)
{
    $request->validate([
        'district' => 'required',
        'division_name' => 'required',
        'counter_name' => 'required|alpha|size:1|uppercase'
    ]);

    // Check duplicate
    $exists = Counter::where('district',$request->district)
        ->where('division_name',$request->division_name)
        ->where('counter_name',strtoupper($request->counter_name))
        ->exists();

    if($exists){
        return back()->with('error','This counter letter already exists for this DS division');
    }

    Counter::create([
        'district'=>$request->district,
        'division_name'=>$request->division_name,
        'counter_name'=>strtoupper($request->counter_name)
    ]);

    return back()->with('success','Counter created successfully');
}


   public function update(Request $request, $id)
{
    $request->validate([
        'district' => 'required',
        'division_name' => 'required',
    ]);

    $exists = Counter::where('district',$request->district)
        ->where('division_name',$request->division_name)
        ->where('counter_name',strtoupper($request->counter_name))
        ->where('id','!=',$id)
        ->exists();

    if($exists){
        return back()->with('error','This counter letter already exists for this DS division');
    }

    $counter = Counter::findOrFail($id);

    $counter->update([
        'district'=>$request->district,
        'division_name'=>$request->division_name,
        'counter_name'=>strtoupper($request->counter_name)
    ]);

    return back()->with('success','Counter updated successfully');
}


    public function destroy(Counter $counter)
    {
        $counter->delete();
        return redirect()->back()->with('success', 'Counter deleted successfully.');
    }
  

public function feedback_index(Request $request)
{
    $perPage = $request->get('per_page', 10); // default 10 items per page

    $ratings = Feedback::with('counter')
        ->when($request->filled('search'), function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->where('vehicle_number', 'like', '%' . $request->search . '%')
                      ->orWhere('phone', 'like', '%' . $request->search . '%')
                      ->orWhere('note', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->filled('counter'), fn($q) => $q->where('counter_id', $request->counter))
        ->when($request->filled('start_date'), fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
        ->when($request->filled('end_date'), fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
        ->latest()
        ->paginate($perPage)
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
