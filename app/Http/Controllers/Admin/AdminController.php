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

       
    }
}