<?php

namespace App\Http\Controllers;

use App\Models\ServiceQuality;
use Illuminate\Http\Request;

class ServiceQualityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $qualities = ServiceQuality::latest()->paginate($perPage);
        return view('admin.service_quality.index',compact('qualities'));
    }

    public function store(Request $request)
    {
        ServiceQuality::create($request->validate([
            'name'=>'required|max:100',
                    'type'  => 'required|in:good,average,bad',

            'color'=>'nullable|max:20'
        ]));

        return back()->with('success','Service Quality Added');
    }

    public function update(Request $request,$id)
    {
        $q = ServiceQuality::findOrFail($id);

        $q->update($request->validate([
            'name'=>'required|max:100',
                    'type'  => 'required|in:good,average,bad',
            'color'=>'nullable|max:20'
        ]));

        return back()->with('success','Updated Successfully');
    }

    public function destroy($id)
    {
        ServiceQuality::findOrFail($id)->delete();
        return back()->with('success','Deleted Successfully');
    }
}
