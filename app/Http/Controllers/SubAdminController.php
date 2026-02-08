<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SubAdminController extends Controller
{
    public function index()
    {
        $subAdmins = User::where('role', 'sub-administrator')->get();
        return view('admin.sub-admins.index', compact('subAdmins'));
    }

    public function create()
    {
        return view('admin.sub-admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'sub-administrator',
        ]);

        return redirect()->route('admin.sub-admins.index')
            ->with('success', 'Sub-administrator account created successfully.');
    }

    public function edit(User $subAdmin)
    {
        return view('admin.sub-admins.edit', compact('subAdmin'));
    }

    public function update(Request $request, User $subAdmin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $subAdmin->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $subAdmin->name = $request->name;
        $subAdmin->email = $request->email;
        
        if ($request->filled('password')) {
            $subAdmin->password = Hash::make($request->password);
        }

        $subAdmin->save();

        return redirect()->route('admin.sub-admins.index')
            ->with('success', 'Sub-administrator account updated successfully.');
    }

    public function destroy(User $subAdmin)
    {
        $subAdmin->delete();

        return redirect()->route('admin.sub-admins.index')
            ->with('success', 'Sub-administrator account deleted successfully.');
    }
} 