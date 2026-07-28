<?php

namespace App\Http\Controllers;

use App\Models\ComplainType;
use App\Models\Counter;
use App\Models\Feedback;
use App\Models\ReadComplaint;
use App\Models\ServiceQuality;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
public function index()
{
     $statusMap = [
    'pending' => null,
    'ao' => 'ao',
    'commissioner' => 'commissioner',
    'verified' => 'verified',
];

$status = $statusMap[$filters['status'] ?? ''] ?? null;
    $filters = [
    'division' => request('division'),
    'counter' => request('counter'),
    'status' => request('status'),
    'from' => request('from'),
    'to' => request('to'),
    'service_quality' => request('service_quality'),
    'rating' => request('rating'),
    'search' => request('search'),
    'complain_type' => request('complain_type'),
];
  $counters = Counter::orderBy('district')
        ->orderBy('division_name')
        ->orderBy('counter_name')
        ->get();
    $baseQuery = Feedback::with(['counter','complainType','serviceQuality'])
        ->whereNotNull('note')
        ->where('note','!=','');


    if(request('status')){
        $baseQuery->where('status', request('status'));
    }

    if(request('from')){
        $baseQuery->whereDate('created_at','>=', request('from'));
    }

    if(request('to')){
        $baseQuery->whereDate('created_at','<=', request('to'));
    }

 if(request('service_quality')){
    $baseQuery->where('service_quality_id', request('service_quality'));
}

if(request('rating')){
    $baseQuery->where('rating', request('rating'));
}
if(request('complain_type')){
    $baseQuery->where('complain_type_id', request('complain_type'));
}

if(request('search')){
    $baseQuery->where(function($q){
        $q->where('vehicle_number','like','%'.request('search').'%')
          ->orWhere('phone','like','%'.request('search').'%');
    });
}
    $allRatings = (clone $baseQuery)
        ->where(function($q){
            $q->whereNull('status')
              ->orWhere('status','pending');
        })
          ->when($filters['counter'], fn($q) => $q->where('counter_id', $filters['counter']))
       ->when($filters['division'], fn($q) => 
        $q->whereHas('counter', fn($q2) => $q2->where('division_name','like', "%{$filters['division']}%"))
    )
       ->when($status === null && ($filters['status'] ?? '') === 'pending', fn($q) => $q->whereNull('status'))
            ->when($status && $status !== 'pending', fn($q) => $q->where('status', $status))
        ->latest()
        ->paginate(request('per_page',10), ['*'], 'pending_page')
        ->withQueryString();

    $readRatings = (clone $baseQuery)
        ->whereNotNull('status')
           ->when($status === null && ($filters['status'] ?? '') === 'pending', fn($q) => $q->whereNull('status'))
            ->when($status && $status !== 'pending', fn($q) => $q->where('status', $status))
          ->when($filters['counter'], fn($q) => $q->where('counter_id', $filters['counter']))
       ->when($filters['division'], fn($q) => 
        $q->whereHas('counter', fn($q2) => $q2->where('division_name','like', "%{$filters['division']}%"))
    )
        ->latest()
        ->paginate(request('per_page',10), ['*'], 'all_page')
        ->withQueryString();

    $types = ComplainType::all();
    $serviceQualities = \App\Models\ServiceQuality::all();

    return view('admin.complain.index', compact('allRatings','readRatings','types','serviceQualities','counters','filters'));
}

public function saveuserRemarks(Request $request, $id)
{
    $request->validate([
        'remarks' => 'nullable|string|max:1000'
    ]);

    $feedback = Feedback::findOrFail($id);
    $feedback->user_remarks = $request->user_remarks;
        $feedback->complain_type_id = $request->complain_type_id;

    $feedback->status = 'ao'; // mark as read automatically
    $feedback->save();

    return back()->with('success','Remarks saved successfully');
}
public function sendToAO($id)
{
    $feedback = Feedback::findOrFail($id);

    $feedback->status = 'ao';
    $feedback->save();

    return redirect()->route('admin.ao.index')
        ->with('success','Sent to Administrative Officer');
}

public function forward(Request $request,$id)
{
    $feedback = Feedback::findOrFail($id);

    $feedback->complain_type_id = $request->complain_type_id;
    $feedback->user_remarks = $request->user_remarks;

    $feedback->status = 'ao';
    $feedback->save();


    return redirect()->route('admin.ao.index')
        ->with('success','Complaint forwarded successfully');
}

public function aoIndex(Request $request)
{
    $complainTypes = ComplainType::all();
    $serviceQualities = ServiceQuality::all(); 
    $filters = [
        'division' => $request->division,
        'counter' => $request->counter,
        'from' => $request->from,
        'to' => $request->to,
        'service_quality' => $request->service_quality,
        'rating' => $request->rating,
         'status' => $request->status, 
           'search' => $request->search,
    'complain_type' => $request->complain_type,
    ];
    $statusMap = [
    'pending' => null,
    'ao' => 'ao',
    'verified' => 'verified',
    'commissioner' => 'commissioner',
 
];

$status = $statusMap[$filters['status'] ?? ''] ?? null;
  $counters = Counter::orderBy('district')
        ->orderBy('division_name')
        ->orderBy('counter_name')
        ->get();
    $pendingAO = Feedback::with(['counter','complainType','serviceQuality'])
 
        ->where('status','ao')
            ->when($status === null && ($filters['status'] ?? '') === 'pending', fn($q) => $q->whereNull('status'))
            ->when($status && $status !== 'pending', fn($q) => $q->where('status', $status))
        ->when($filters['counter'], fn($q) => $q->where('counter_id', $filters['counter']))
       ->when($filters['division'], fn($q) => 
        $q->whereHas('counter', fn($q2) => $q2->where('division_name','like', "%{$filters['division']}%"))
    )
        ->when($filters['service_quality'], fn($q) => $q->where('service_quality_id', $filters['service_quality']))
        ->when($filters['rating'], fn($q) => $q->where('rating', $filters['rating']))
        ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
        ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
        ->when($filters['search'], function($q) use ($filters){
    $q->where(function($sub) use ($filters){
        $sub->where('vehicle_number','like','%'.$filters['search'].'%')
            ->orWhere('phone','like','%'.$filters['search'].'%');
    });
})
->when($filters['complain_type'], fn($q) => $q->where('complain_type_id', $filters['complain_type']))
         ->orderByDesc('id')
    ->paginate($request->per_page ?? 10, ['*'], 'pending')
    ->withQueryString();

    $closedAO = Feedback::with(['counter','complainType','serviceQuality'])
        ->whereIn('status',['verified','commissioner','completed','rejected'])
                  ->when($status === null && ($filters['status'] ?? '') === 'pending', fn($q) => $q->whereNull('status'))
            ->when($status && $status !== 'pending', fn($q) => $q->where('status', $status))
       ->when($filters['counter'], fn($q) => $q->where('counter_id', $filters['counter']))
       ->when($filters['division'], fn($q) => 
        $q->whereHas('counter', fn($q2) => $q2->where('division_name','like', "%{$filters['division']}%"))
    )
        ->when($filters['service_quality'], fn($q) => $q->where('service_quality_id', $filters['service_quality']))
        ->when($filters['rating'], fn($q) => $q->where('rating', $filters['rating']))
        ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
        ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
          ->when($filters['search'], function($q) use ($filters){
    $q->where(function($sub) use ($filters){
        $sub->where('vehicle_number','like','%'.$filters['search'].'%')
            ->orWhere('phone','like','%'.$filters['search'].'%');
    });
})
->when($filters['complain_type'], fn($q) => $q->where('complain_type_id', $filters['complain_type']))
   ->orderByDesc('id')
    ->paginate($request->per_page ?? 10, ['*'], 'closed')
    ->withQueryString();
    return view('admin.ao.index', compact('pendingAO','closedAO','serviceQualities','filters','counters','complainTypes'));
}


public function aoSave(Request $request, $id)
{
    $feedback = Feedback::findOrFail($id);

    $feedback->ao_remarks = $request->ao_remarks;

    if (in_array($request->action, ['inform_commissioner', 'forward'], true)) {
        $feedback->status = 'commissioner';
    } elseif ($request->action === 'verify') {
        $feedback->status = 'verified';
    } elseif ($request->action === 'reject') {
        $feedback->status = 'rejected';
    }

    $feedback->save();

    return redirect()->back()->with('success', 'Complaint updated successfully.');
}

public function commissionerIndex(Request $request)
{
    $serviceQualities = ServiceQuality::all();
    $complainTypes = ComplainType::all();

    $filters = [
        'division' => $request->division,
        'counter' => $request->counter,
        'status' => $request->status,
        'from' => $request->from,
        'to' => $request->to,
        'service_quality' => $request->service_quality,
        'rating' => $request->rating,
          'search' => $request->search,
    'complain_type' => $request->complain_type,
    ];
    $status = $filters['status'] ?? null;
   $counters = Counter::orderBy('district')
        ->orderBy('division_name')
        ->orderBy('counter_name')
        ->get();
    $perPage = $request->get('per_page', 10);
$pendingCommissioner = Feedback::with(['counter','complainType','serviceQuality'])
    ->whereNotNull('note')
    ->where('note', '!=', '')
    ->where(function ($query) {
        $query->whereNull('status')
              ->orWhereIn('status', [
                  'pending',
                  'ao',
                  'verified',
                  'commissioner',
                         'completed',
                'rejected',
              ]);
    })
    ->when($status === 'pending', function ($query) {
        $query->where(function ($q) {
            $q->whereNull('status')
              ->orWhere('status', 'pending');
        });
    })
      ->when(
        in_array(
            $status,
            ['ao', 'verified', 'commissioner', 'completed', 'rejected'],
            true
        ),
        fn ($query) => $query->where('status', $status)
    )
    ->when($filters['counter'], fn($q) => $q->where('counter_id', $filters['counter']))
    ->when($filters['division'], fn($q) =>
        $q->whereHas('counter', fn($q2) =>
            $q2->where('division_name', 'like', "%{$filters['division']}%")
        )
    )
    ->when($filters['service_quality'], fn($q) => $q->where('service_quality_id', $filters['service_quality']))
    ->when($filters['rating'], fn($q) => $q->where('rating', $filters['rating']))
    ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
    ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
    ->when($filters['complain_type'], fn($q) => $q->where('complain_type_id', $filters['complain_type']))
    ->when($filters['search'], function ($q) use ($filters) {
        $q->where(function ($sub) use ($filters) {
            $sub->where('vehicle_number', 'like', "%{$filters['search']}%")
                ->orWhere('phone', 'like', "%{$filters['search']}%");
        });
    })
    ->latest()
    ->paginate($perPage)
    ->withQueryString();
    return view('admin.commissioner.index', compact(
        'pendingCommissioner','serviceQualities','filters','counters','complainTypes'
    ));
}

public function commissionerClose(Request $request,$id)
{
    
    $feedback = Feedback::findOrFail($id);

    $feedback->commissioner_remarks = $request->final_remarks;
    $feedback->status = 'completed';
    $feedback->save();

    return back()->with('success','Complaint marked as Completed');
}
public function commissionerInformed(Request $request)
{
    $user = auth()->user();
    $roleKey = strtolower(trim((string) ($user->role ?? '')));
    $isSuperAdmin = $roleKey === 'super admin' || ($user && method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin());

    if ($roleKey !== 'commissioner' && !$isSuperAdmin) {
        abort(403);
    }

    $filters = [
        'counter' => $request->counter,
        'from' => $request->from,
        'to' => $request->to,
        'search' => $request->search,
        'complain_type' => $request->complain_type,
    ];

    $counters = Counter::orderBy('district')
        ->orderBy('division_name')
        ->orderBy('counter_name')
        ->get();

    $complainTypes = ComplainType::all();

    $informedComplaints = Feedback::with(['counter','complainType','serviceQuality'])
        ->whereNotNull('note')
        ->where('note', '!=', '')
        ->where('status', 'commissioner')
        ->when($filters['counter'], fn($q) => $q->where('counter_id', $filters['counter']))
        ->when($filters['complain_type'], fn($q) => $q->where('complain_type_id', $filters['complain_type']))
        ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
        ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
        ->when($filters['search'], function ($q) use ($filters) {
            $q->where(function ($sub) use ($filters) {
                $sub->where('vehicle_number', 'like', '%'.$filters['search'].'%')
                    ->orWhere('phone', 'like', '%'.$filters['search'].'%');
            });
        })
        ->latest()
        ->paginate($request->per_page ?? 10)
        ->withQueryString();

    return view('admin.commissioner.informed', compact(
        'informedComplaints',
        'filters',
        'counters',
        'complainTypes'
    ));
}
}
