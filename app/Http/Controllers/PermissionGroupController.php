<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use Illuminate\Http\Request;

class PermissionGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index()
    {
        $groups = PermissionGroup::latest()->get();
        return view('permission_groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permission_groups,name'
        ]);

        PermissionGroup::create([
            'name'=>$request->name
        ]);

        return back()->with('success','Permission Group created successfully');
    }

    public function update(Request $request,$id)
    {
        $group = PermissionGroup::findOrFail($id);

        $request->validate([
            'name'=>'required|unique:permission_groups,name,'.$id
        ]);

        $group->update([
            'name'=>$request->name
        ]);

        return back()->with('success','Permission Group updated successfully');
    }

    public function destroy($id)
    {
        PermissionGroup::findOrFail($id)->delete();

        return back()->with('success','Permission Group deleted successfully');
    }
}
