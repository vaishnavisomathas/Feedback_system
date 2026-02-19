<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\ServiceQuality;
use Illuminate\Support\Carbon;

class FeedbackController extends Controller
{
     public function __construct()
    {
        // Prevent browser caching to block back-button resubmission
        $this->middleware(function ($request, $next) {
            $response = $next($request);
            return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', '0');
        });
    }
   public function show($division, $counterName)
{

    $counter = Counter::where('division_name',$division)
        ->where('counter_name',$counterName)
        ->firstOrFail();

      // Generate a unique token for this feedback session
        session([
            'rating_access' => true,
            'rating_counter' => $counter->id,
            'feedback_token' => bin2hex(random_bytes(16)), // NEW token
        ]);

 $qualities = ServiceQuality::orderBy('name')->get();
        return view('feedback', [
            'counter' => $counter,
             'qualities' => $qualities,
            'selectedDivision' => $counter->division_name,
            'counterName' => $counter->counter_name,
                        'feedback_token' => session('feedback_token'),

        ]);
    }
    public function store(Request $request)
    {
           if (!session('rating_access') || session('feedback_token') !== $request->feedback_token) {
            return redirect()->route('feedback.closed')
                ->with('error', '⚠ Session Expired. Please scan the QR code again.');
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

        session()->forget(['rating_access', 'feedback_token']);

    return redirect()->route('feedback.thankyou');
    }

   public function closed()
    {
        return view('feedback-closed'); // show message "Session Expired"
    }

}
