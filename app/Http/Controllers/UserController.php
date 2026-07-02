<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
{
    $authRole = auth()->user()->role;
    
    // Admin sees all users, Commissioner doesn't see Admin users
    if ($authRole === 'admin') {
        $users = User::latest()->get();
    } else {
        $users = User::where('role', '!=', 'admin')->latest()->get();
    }
    
    $roles = Role::all();
    return view('admin.user.index', compact('users','roles'));
}

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'role' => 'required|string',
    ]);

    $nextPasswordCode = (User::max('temp_password_code') ?? 0) + 1;
    $defaultPassword = 'pdmt@' . str_pad((string) $nextPasswordCode, 3, '0', STR_PAD_LEFT);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($defaultPassword),
        'dob' => $request->dob,
        'nic_number' => $request->nic_number,
        'role' => $request->role,
        'phone' => $request->phone,
        'must_change_password' => true,
        'temp_password_code' => $nextPasswordCode,
    ]);

    try {
        Mail::raw(
            "Hello {$user->name},\n\n" .
            "Your account has been created for PDMT Feedback System.\n" .
            "Login Email: {$user->email}\n" .
            "Temporary Password: {$defaultPassword}\n\n" .
            "Please login and change your password immediately.",
            function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('PDMT Account Created - Temporary Password');
            }
        );
    } catch (\Throwable $e) {
        Log::error('User created but email send failed', [
            'user_id' => $user->id,
            'email' => $user->email,
            'error' => $e->getMessage(),
        ]);

        return back()->with('warning', "User created successfully. Email could not be sent. Temporary password: {$defaultPassword}");
    }

    return back()->with('success', 'User created successfully and login details sent by email.');
}
public function show($id)
{
    $user = User::findOrFail($id);
    return view('admin.user.show', compact('user'));
}

public function changePassword(Request $request, $id)
{
    $user = User::findOrFail($id);

    if ((int) auth()->id() !== (int) $user->id) {
        abort(403, 'You can only change your own password.');
    }

    $request->validate([
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
    ]);

    $user->password = Hash::make($request->password);
    $user->must_change_password = false;
    $user->save();

    return back()->with('success', 'Password changed successfully.');
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