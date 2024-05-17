<?php

namespace App\Http\Controllers;

use App\Models\GarbageBin;
use Illuminate\Http\Request;

class GarbageBinController extends Controller
{
    public function index()
    {
        return response()->json(GarbageBin::all());
    }
}
