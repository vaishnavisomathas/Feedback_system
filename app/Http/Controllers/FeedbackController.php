<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
     public function show($division, $counterName)
    {
        // Find the counter by division and name
        $counter = Counter::where('division_name', $division)
                          ->where('counter_name', $counterName)
                          ->firstOrFail();

        return view('feedback', [
            'counter' => $counter,
            'selectedDivision' => $counter->division_name,
            'counterName' => $counter->counter_name,
        ]);
    }
    public function store(Request $request)
    {
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
        ]);

        return back()->with('success', 'Thank you for your feedback!');
    }
}
