<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GarbageBin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $bins = GarbageBin::all();
        return view('admin.garbage-bins.index', compact('bins'));
    }

    public function create()
    {
        return view('admin.garbage-bins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        GarbageBin::create($request->all());

        return redirect()->route('admin.garbage-bins.index')->with('success', 'Garbage bin added successfully');

    }
    public function edit(GarbageBin $garbageBin)
{
    return view('admin.garbage-bins.edit', compact('garbageBin'));
}


    // Add the update method
    public function update(Request $request, GarbageBin $garbageBin)
    {
        $request->validate([
            'type' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $garbageBin->update($request->all());

        return redirect()->route('admin.garbage-bins.index')->with('success', 'Garbage bin updated successfully');
    }
    public function destroy(GarbageBin $garbageBin)
    {
        $garbageBin->delete();

        return redirect()->route('admin.garbage-bins.index')->with('success', 'Garbage bin deleted successfully');
    }
}