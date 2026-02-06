<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use Illuminate\Http\Request;

class PermissionGroupController extends Controller
{
     public function index()
    {
        $groups = PermissionGroup::all();
        return view('admin.permissions.groups', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:permission_groups']);

        PermissionGroup::create(['name' => $request->name]);

        return back()->with('success','Group created');
    }
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $group = PermissionGroup::findOrFail($id);
    $group->update([
        'name' => $request->name,
    ]);

    return back()->with('success', 'Permission group updated successfully');
}

    public function destroy($id)
    {
        PermissionGroup::findOrFail($id)->delete();
        return back()->with('success','Group deleted');
    }
}
