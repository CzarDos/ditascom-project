<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Minister;

class MinisterController extends Controller
{
    public function index()
    {
        $ministers = Minister::orderBy('name')->paginate(10);
        return view('admin.ministers.index', compact('ministers'));
    }

    public function create()
    {
        return view('admin.ministers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:100',
            'email' => 'nullable|email|unique:ministers,email',
            'phone' => 'nullable|digits:11',
            'parish_assignment' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        Minister::create($request->all());

        return redirect()->route('admin.ministers.index')
            ->with('success', 'Minister added successfully.');
    }

    public function edit(Minister $minister)
    {
        return view('admin.ministers.edit', compact('minister'));
    }

    public function update(Request $request, Minister $minister)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:100',
            'email' => 'nullable|email|unique:ministers,email,' . $minister->id,
            'phone' => 'nullable|digits:11',
            'parish_assignment' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        $minister->update($request->all());

        return redirect()->route('admin.ministers.index')
            ->with('success', 'Minister updated successfully.');
    }

    public function destroy(Minister $minister)
    {
        $minister->delete();

        return redirect()->route('admin.ministers.index')
            ->with('success', 'Minister deleted successfully.');
    }
}
