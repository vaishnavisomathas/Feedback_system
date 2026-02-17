<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\ServiceQuality;
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

 $qualities = ServiceQuality::orderBy('name')->get();
        return view('feedback', [
            'counter' => $counter,
             'qualities' => $qualities,
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
'service_quality_id'  => 'required|exists:service_qualities,id',
            'has_complaint'    => 'required|in:yes,no',
            'phone'            => 'nullable|required_if:has_complaint,yes|digits:10',
            'vehicle_number'   => 'nullable|string|max:20',
            'note'             => 'nullable|string|max:300',
        ]);

        Feedback::create([
            'counter_id'     => $request->counter_id,
            'rating'          => $request->rating,
'service_quality_id' => $request->service_quality_id,
            'has_complaint'   => $request->has_complaint,
            'phone'           => $request->phone,
            'vehicle_number'  => $request->vehicle_number,
            'note'            => $request->note,
            'user_id'         => auth()->id(),
        ]);

              session()->forget(['rating_access','rating_counter']);

    return redirect()->route('feedback.thankyou');
    }



}
