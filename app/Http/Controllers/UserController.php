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
        $currentUser = auth()->user();
        $isSuperAdmin = $currentUser && (strtolower(trim((string) ($currentUser->role ?? ''))) === 'super admin' || (method_exists($currentUser, 'isSuperAdmin') && $currentUser->isSuperAdmin()));

        if ($isSuperAdmin) {
            $users = User::latest()->get();
            $roles = Role::all();
        } else {
            // Hide only Super Admin; keep other users visible even if role is null/trim issues.
            $users = User::query()
                ->where(function ($query) {
                    $query->whereNull('role')
                        ->orWhereRaw('LOWER(TRIM(role)) != ?', ['super admin']);
                })
                ->latest()
                ->get();

            // Keep Admin role visible, only exclude Super Admin from selection.
            $roles = Role::whereRaw('LOWER(name) != ?', ['super admin'])->get();
        }

        return view('admin.user.index', compact('users', 'roles', 'isSuperAdmin'));
    }

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'role' => 'required|string',
    ]);

    $normalizedRole = trim((string) $request->role);

    $nextPasswordCode = (User::max('temp_password_code') ?? 0) + 1;
    $defaultPassword = 'pdmt@' . str_pad((string) $nextPasswordCode, 3, '0', STR_PAD_LEFT);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($defaultPassword),
        'dob' => $request->dob,
        'nic_number' => $request->nic_number,
        'role' => $normalizedRole,
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
    $currentUser = auth()->user();
    $isSuperAdmin = $currentUser && (strtolower(trim((string) ($currentUser->role ?? ''))) === 'super admin' || (method_exists($currentUser, 'isSuperAdmin') && $currentUser->isSuperAdmin()));

    if (!$isSuperAdmin && (int) auth()->id() !== (int) $user->id) {
        abort(403, 'You can only change your own password.');
    }

    if ($isSuperAdmin && (int) auth()->id() !== (int) $user->id) {
        // Super Admin resetting another user's password
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    } else {
        // User (including Super Admin) changing their own password
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);
    }

    $user->password = Hash::make($request->password);
    $user->must_change_password = false;
    $user->save();

    return back()->with('success', 'Password changed successfully.');
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $currentUser = auth()->user();
    $isSuperAdmin = $currentUser && (strtolower(trim((string) ($currentUser->role ?? ''))) === 'super admin' || (method_exists($currentUser, 'isSuperAdmin') && $currentUser->isSuperAdmin()));
    $targetIsSuperAdmin = (strtolower(trim((string) ($user->role ?? ''))) === 'super admin' || (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()));

    if ($targetIsSuperAdmin && !$isSuperAdmin) {
        abort(403, 'You are not authorized to edit a Super Admin account.');
    }

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string',
        'password' => 'nullable|string|min:8',
    ]);

    $normalizedRole = trim((string) $request->role);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->dob = $request->dob;
    $user->nic_number = $request->nic_number;
    $user->role = $normalizedRole;
    $user->phone = $request->phone;

    $passwordUpdated = false;
    $newPassword = null;

    if ($request->filled('password')) {
        $newPassword = $request->password;
        $user->password = Hash::make($newPassword);
        $user->must_change_password = false;
        $passwordUpdated = true;
    }

    $user->save();

    if ($passwordUpdated && $request->boolean('send_password_email')) {
        try {
            Mail::raw(
                "Hello {$user->name},\n\n" .
                "Your password has been updated for PDMT Feedback System.\n" .
                "Login Email: {$user->email}\n" .
                "New Password: {$newPassword}\n\n" .
                "Please login with your new password.",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('PDMT Account Password Updated');
                }
            );
            return back()->with('success', 'User updated successfully and new password sent by email.');
        } catch (\Throwable $e) {
            Log::error('User updated but email send failed', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);

            return back()->with('warning', "User updated successfully. Email could not be sent. New password: {$newPassword}");
        }
    }

    return back()->with('success', 'User updated successfully');
}
public function destroy($id)
{
    $user = User::findOrFail($id);
    $currentUser = auth()->user();
    $isSuperAdmin = $currentUser && (strtolower(trim((string) ($currentUser->role ?? ''))) === 'super admin' || (method_exists($currentUser, 'isSuperAdmin') && $currentUser->isSuperAdmin()));
    $targetIsSuperAdmin = (strtolower(trim((string) ($user->role ?? ''))) === 'super admin' || (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()));

    if ($targetIsSuperAdmin && !$isSuperAdmin) {
        abort(403, 'You are not authorized to delete a Super Admin account.');
    }

    $user->delete();

    return back()->with('success', 'User deleted successfully');
}}