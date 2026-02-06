<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
     public function index()
    {
        $groups = PermissionGroup::all();
        $permissions = Permission::all();

        return view('admin.permissions.index', compact('groups','permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'group_id' => 'required'
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'group_id' => $request->group_id ?? null, 
        ]);

        return back()->with('success','Permission created');
    }
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'group_id' => 'nullable|exists:permission_groups,id',
    ]);

    $permission = Permission::findOrFail($id);
    $permission->update([
        'name' => $request->name,
'group_id' => $request->group_id ?? null,
    'guard_name' => $permission->guard_name ?? 'web',    ]);

    return back()->with('success', 'Permission updated successfully');
}

    public function destroy($id)
    {
        Permission::findById($id)->delete();
        return back()->with('success','Permission deleted');
    }
}
