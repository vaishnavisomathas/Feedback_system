<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
{
    $users = User::latest()->get();
       $roles = Role::all();
    return view('admin.user.index', compact('users','roles'));
}

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'role' => 'required|string',
          'password' => 'required|string|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
'password' => Hash::make($request->password),
        'dob' => $request->dob,
        'nic_number' => $request->nic_number,
        'role' => $request->role,
        'phone' => $request->phone,
    ]);

    return back()->with('success', 'User created successfully');
}
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->dob = $request->dob;
    $user->nic_number = $request->nic_number;
    $user->role = $request->role;
    $user->phone = $request->phone;

    if ($request->password) {
        $user->password = Hash::make($request->password); 
    }

    $user->save();

    return back()->with('success', 'User updated successfully');
}
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return back()->with('success', 'User deleted successfully');
}}