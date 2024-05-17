<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Log::info('api.php loaded');

Route::get('/test', function () {
    Log::info('Test route accessed');
    return response()->json(['status' => 'working']);
});

use App\Http\Controllers\GarbageBinController;
Route::get('/garbage-bins', [GarbageBinController::class, 'index']);
