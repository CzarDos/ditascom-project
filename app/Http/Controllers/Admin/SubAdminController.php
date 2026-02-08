<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Http\Middleware\AdminMiddleware;

class SubAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(AdminMiddleware::class);
    }

    public function index(Request $request)
    {
        $query = User::where('role', 'sub-administrator');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('parish_name', 'like', "%{$search}%")
                  ->orWhere('parish_address', 'like', "%{$search}%");
            });
        }
        
        $subAdmins = $query->paginate(10);
        return view('admin.subadmins.index', compact('subAdmins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'parish_name' => ['required', 'string', 'max:255'],
            'parish_address' => ['required', 'string', 'max:255'],
            'parish_logo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Handle parish logo upload
        $parishLogoPath = null;
        if ($request->hasFile('parish_logo')) {
            $parishLogoPath = $request->file('parish_logo')->store('parish_logos', 'public');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'parish_name' => $validated['parish_name'],
            'parish_address' => $validated['parish_address'],
            'parish_logo' => $parishLogoPath,
            'password' => Hash::make($validated['password']),
            'role' => 'sub-administrator',
        ]);

        return redirect()->route('admin.subadmins.index')
            ->with('success', 'Sub-administrator created successfully.');
    }

    public function edit(User $subadmin)
    {
        return view('admin.subadmins.edit', compact('subadmin'));
    }

    public function update(Request $request, User $subadmin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($subadmin->id)],
            'parish_name' => ['required', 'string', 'max:255'],
            'parish_address' => ['required', 'string', 'max:255'],
            'parish_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $subadmin->name = $validated['name'];
        $subadmin->email = $validated['email'];
        $subadmin->parish_name = $validated['parish_name'];
        $subadmin->parish_address = $validated['parish_address'];
        
        // Handle parish logo upload
        if ($request->hasFile('parish_logo')) {
            // Delete old logo if exists
            if ($subadmin->parish_logo && \Storage::disk('public')->exists($subadmin->parish_logo)) {
                \Storage::disk('public')->delete($subadmin->parish_logo);
            }
            
            $parishLogoPath = $request->file('parish_logo')->store('parish_logos', 'public');
            $subadmin->parish_logo = $parishLogoPath;
        }
        
        if (!empty($validated['password'])) {
            $subadmin->password = Hash::make($validated['password']);
        }

        $subadmin->save();

        return redirect()->route('admin.subadmins.index')
            ->with('success', 'Sub-administrator updated successfully.');
    }

    public function destroy(User $subadmin)
    {
        // Delete parish logo if exists
        if ($subadmin->parish_logo && \Storage::disk('public')->exists($subadmin->parish_logo)) {
            \Storage::disk('public')->delete($subadmin->parish_logo);
        }
        
        $subadmin->delete();

        return redirect()->route('admin.subadmins.index')
            ->with('success', 'Sub-administrator deleted successfully.');
    }
} 