<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Carbon;

class FeedbackController extends Controller
{
   public function show($division, $counterName)
{
    $counter = Counter::where('division_name',$division)
        ->where('counter_name',$counterName)
        ->firstOrFail();

     session([
            'rating_access' => true,
            'rating_counter' => $counter->id
        ]);


        return view('feedback', [
            'counter' => $counter,
            'selectedDivision' => $counter->division_name,
            'counterName' => $counter->counter_name,
        ]);
    }
    public function store(Request $request)
    {
           if(!session('rating_access')){
            return redirect()->route('feedback.closed');
        }
        $request->validate([
                  'counter_id'       => 'required|exists:counters,id',
            'rating'           => 'required|integer|min:1|max:5',
            'service_quality'  => 'required|string',
            'has_complaint'    => 'required|in:yes,no',
            'phone'            => 'nullable|required_if:has_complaint,yes|digits:10',
            'vehicle_number'   => 'nullable|string|max:20',
            'note'             => 'nullable|string|max:300',
        ]);

        Feedback::create([
            'counter_id'     => $request->counter_id,
            'rating'          => $request->rating,
            'service_quality' => $request->service_quality,
            'has_complaint'   => $request->has_complaint,
            'phone'           => $request->phone,
            'vehicle_number'  => $request->vehicle_number,
            'note'            => $request->note,
            'user_id'         => auth()->id(),
        ]);

              session()->forget(['rating_access','rating_counter']);

    return redirect()->route('feedback.thankyou');
    }

public function forwardedComplaints(Request $request)
{
    $query = Feedback::where('status', 'forwarded')
                ->with('counter');

    if ($request->counter) {
        $query->where('counter_id', $request->counter);
    }

    if ($request->service_quality) {
        $query->where('service_quality', $request->service_quality);
    }
    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    $ratings = $query->latest()->get();

    $counters = Counter::all();

    return view('admin.forwarded-complaints', compact('ratings','counters'));
}


public function forwardFeedback($id)
{
    $feedback = Feedback::findOrFail($id);

    if($feedback->status == 'pending') {
        $feedback->status = 'forwarded';
        $feedback->save();
    }

    return redirect()->route('admin.forwarded-complaints')
                     ->with('success', 'Feedback forwarded successfully!');
}


}
