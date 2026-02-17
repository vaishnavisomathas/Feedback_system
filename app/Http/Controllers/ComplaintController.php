<?php

namespace App\Http\Controllers;

use App\Models\ComplainType;
use App\Models\Counter;
use App\Models\Feedback;
use App\Models\ReadComplaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
public function index()
{
    $baseQuery = Feedback::with(['counter','complainType','serviceQuality'])
        ->whereNotNull('note')
        ->where('note','!=','');

    // Pending tab
    $allRatings = (clone $baseQuery)
        ->where(function($q){
            $q->whereNull('status')
              ->orWhere('status','pending');
        })
        ->latest()
        ->paginate(10,['*'],'pending_page');

    // All complaints tab (everything except pending)
    $readRatings = (clone $baseQuery)
        ->whereNotNull('status')
        ->latest()
        ->paginate(10,['*'],'all_page');

    $types = ComplainType::all();

    return view('admin.complain.index',compact('allRatings','readRatings','types'));
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

public function aoIndex()
{
    // Complaints currently at AO
    $pendingAO = Feedback::with(['counter','complainType'])
        ->where('status','ao')
        ->latest()
        ->paginate(10, ['*'], 'pending');

    // Complaints already forwarded OR completed
    $closedAO = Feedback::with(['counter','complainType'])
        ->whereIn('status',['commissioner','completed'])
        ->latest()
        ->paginate(10, ['*'], 'closed');

    return view('admin.ao.index', compact('pendingAO','closedAO'));
}

public function aoSave(Request $request, $id)
{
    $feedback = Feedback::findOrFail($id);

    $feedback->ao_remarks = $request->ao_remarks;

    $feedback->status = 'commissioner';  
    $feedback->save();

    return back()->with('success','Forwarded to Commissioner');
}

public function commissionerIndex()
{
    $pendingCommissioner = Feedback::with(['counter','complainType'])
        ->where('status','commissioner')
        ->latest()
        ->paginate(10);

    $closedCommissioner = Feedback::with(['counter','complainType'])
        ->where('status','completed')
        ->latest()
        ->paginate(10);

    return view('admin.commissioner.index',
        compact('pendingCommissioner','closedCommissioner'));
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
