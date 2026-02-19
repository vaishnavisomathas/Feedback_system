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
    $baseQuery = Feedback::with(['counter','complainType','serviceQuality'])
        ->whereNotNull('note')
        ->where('note','!=','');

   
    if(request('division')){
        $baseQuery->whereHas('counter', function($q){
            $q->where('division_name','like','%'.request('division').'%');
        });
    }

    if(request('counter')){
        $baseQuery->whereHas('counter', function($q){
            $q->where('counter_name','like','%'.request('counter').'%');
        });
    }

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

    $allRatings = (clone $baseQuery)
        ->where(function($q){
            $q->whereNull('status')
              ->orWhere('status','pending');
        })
        ->latest()
        ->paginate(request('per_page',10), ['*'], 'pending_page')
        ->withQueryString();

    $readRatings = (clone $baseQuery)
        ->whereNotNull('status')
        ->latest()
        ->paginate(request('per_page',10), ['*'], 'all_page')
        ->withQueryString();

    $types = ComplainType::all();
    $serviceQualities = \App\Models\ServiceQuality::all();

    return view('admin.complain.index', compact('allRatings','readRatings','types','serviceQualities'));
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
    $serviceQualities = ServiceQuality::all(); 
    $filters = [
        'division' => $request->division,
        'counter' => $request->counter,
        'from' => $request->from,
        'to' => $request->to,
        'service_quality' => $request->service_quality,
        'rating' => $request->rating,
    ];

    $pendingAO = Feedback::with(['counter','complainType','serviceQuality'])
        ->where('status','ao')
        ->when($filters['division'], fn($q) => $q->whereHas('counter', fn($q) => $q->where('division_name', 'like', "%{$filters['division']}%")))
        ->when($filters['counter'], fn($q) => $q->whereHas('counter', fn($q) => $q->where('counter_name', 'like', "%{$filters['counter']}%")))
        ->when($filters['service_quality'], fn($q) => $q->where('service_quality_id', $filters['service_quality']))
        ->when($filters['rating'], fn($q) => $q->where('rating', $filters['rating']))
        ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
        ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
        ->latest()
        ->paginate($request->per_page ?? 10, ['*'], 'pending');

    $closedAO = Feedback::with(['counter','complainType','serviceQuality'])
        ->whereIn('status',['commissioner','completed','rejected'])
        ->when($filters['division'], fn($q) => $q->whereHas('counter', fn($q) => $q->where('division_name', 'like', "%{$filters['division']}%")))
        ->when($filters['counter'], fn($q) => $q->whereHas('counter', fn($q) => $q->where('counter_name', 'like', "%{$filters['counter']}%")))
        ->when($filters['service_quality'], fn($q) => $q->where('service_quality_id', $filters['service_quality']))
        ->when($filters['rating'], fn($q) => $q->where('rating', $filters['rating']))
        ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
        ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
        ->latest()
        ->paginate($request->per_page ?? 10, ['*'], 'closed');

    return view('admin.ao.index', compact('pendingAO','closedAO','serviceQualities','filters'));
}


public function aoSave(Request $request, $id)
{
    $feedback = Feedback::findOrFail($id);

       $feedback->ao_remarks = $request->ao_remarks;

    if ($request->action === 'forward') {
        $feedback->status = 'commissioner';
    } elseif ($request->action === 'reject') {
        $feedback->status = 'rejected';
    }

    $feedback->save();

    return redirect()->back()->with('success', 'Complaint updated successfully.');
}

public function commissionerIndex(Request $request)
{
    $serviceQualities = ServiceQuality::all();

    $filters = [
        'division' => $request->division,
        'counter' => $request->counter,
        'status' => $request->status,
        'from' => $request->from,
        'to' => $request->to,
        'service_quality' => $request->service_quality,
        'rating' => $request->rating,
    ];

    $pendingCommissioner = Feedback::with(['counter','complainType','serviceQuality'])
        ->where('status','commissioner')
        ->when($filters['division'], fn($q) => $q->whereHas('counter', fn($q) => $q->where('division_name','like',"%{$filters['division']}%")))
        ->when($filters['counter'], fn($q) => $q->whereHas('counter', fn($q) => $q->where('counter_name','like',"%{$filters['counter']}%")))
        ->when($filters['service_quality'], fn($q) => $q->where('service_quality_id', $filters['service_quality']))
        ->when($filters['rating'], fn($q) => $q->where('rating', $filters['rating']))
        ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
        ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
        ->latest()
        ->paginate($request->per_page ?? 10, ['*'], 'pending');

    $closedCommissioner = Feedback::with(['counter','complainType','serviceQuality'])
        ->where('status','completed')
        ->when($filters['division'], fn($q) => $q->whereHas('counter', fn($q) => $q->where('division_name','like',"%{$filters['division']}%")))
        ->when($filters['counter'], fn($q) => $q->whereHas('counter', fn($q) => $q->where('counter_name','like',"%{$filters['counter']}%")))
        ->when($filters['service_quality'], fn($q) => $q->where('service_quality_id', $filters['service_quality']))
        ->when($filters['rating'], fn($q) => $q->where('rating', $filters['rating']))
        ->when($filters['from'], fn($q) => $q->whereDate('created_at', '>=', $filters['from']))
        ->when($filters['to'], fn($q) => $q->whereDate('created_at', '<=', $filters['to']))
        ->latest()
        ->paginate($request->per_page ?? 10, ['*'], 'closed');

    return view('admin.commissioner.index', compact(
        'pendingCommissioner','closedCommissioner','serviceQualities','filters'
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
}
