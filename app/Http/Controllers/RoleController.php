<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function index()
    {
$roles = Role::with('permissions')->get();
$permissionGroups = PermissionGroup::with('permissions')->get();
    return view('roles.index', compact('roles','permissionGroups'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'nullable|array'
    ]);

    $role = Role::create([
        'name' => $request->name,
        'guard_name' => 'web'
    ]);

    // IMPORTANT FIX
    $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();

    $role->syncPermissions($permissions);

    return back()->with('success','Role created successfully');
}



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request,$id)
{
    $role = Role::findOrFail($id);

    $request->validate([
        'name'=>'required|unique:roles,name,'.$id,
        'permissions'=>'nullable|array'
    ]);

    $role->update(['name'=>$request->name]);

    $permissions = Permission::whereIn('id', $request->permissions ?? [])->get();

    $role->syncPermissions($permissions);

    return back()->with('success','Role updated successfully');
}



    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return back()->with('success','Role deleted successfully');
    }
}
