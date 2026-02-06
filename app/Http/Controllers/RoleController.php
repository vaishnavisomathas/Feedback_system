<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
   public function index()
    {
$groups = PermissionGroup::with('permissions')->get();
$roles = Role::with('permissions')->get();
return view('admin.roles.index', compact('roles', 'groups'));

    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        $role->syncPermissions($request->permissions);

        return back()->with('success','Role created');
    }

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'permissions' => 'nullable|array',
        'permissions.*' => 'string|exists:permissions,name',
    ]);

    $role = Role::findById($id);

    $role->name = $request->name;
    $role->save();

    if ($request->permissions) {
        $role->syncPermissions($request->permissions);
    } else {
        $role->syncPermissions([]); // remove all if empty
    }

    return back()->with('success', 'Role updated successfully');
}
    public function destroy($id)
    {
        Role::findById($id)->delete();
        return back()->with('success','Role deleted');
    }
}
