<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GarbageBinController;
use App\Http\Controllers\Admin\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('garbage-bins', GarbageBinController::class);

Route::get('admin/garbage-bins', [AdminController::class, 'index'])->name('admin.garbage-bins.index');
Route::get('admin/garbage-bins/create', [AdminController::class, 'create'])->name('admin.garbage-bins.create');
Route::post('admin/garbage-bins', [AdminController::class, 'store'])->name('admin.garbage-bins.store');
Route::get('admin/garbage-bins/{id}/edit', [AdminController::class, 'edit'])->name('admin.garbage-bins.edit');
Route::put('admin/garbage-bins/{id}', [AdminController::class, 'update'])->name('admin.garbage-bins.update');
Route::delete('admin/garbage-bins/{id}', [AdminController::class, 'destroy'])->name('admin.garbage-bins.destroy');