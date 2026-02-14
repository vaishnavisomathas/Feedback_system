<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $permissions = Permission::with('group')->latest()->get();
        $groups = PermissionGroup::pluck('name','id');
        return view('permissions.index', compact('permissions','groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'group_id' => 'required'
        ]);

        Permission::create([
            'name' => $request->name,
            'group_id' => $request->group_id,
            'guard_name' => 'web'
        ]);

        return back()->with('success','Permission created');
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:permissions,name,'.$id,
            'group_id' => 'required'
        ]);

        $permission->update([
            'name'=>$request->name,
            'group_id'=>$request->group_id
        ]);

        return back()->with('success','Permission updated');
    }

    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();
        return back()->with('success','Permission deleted');
    }}