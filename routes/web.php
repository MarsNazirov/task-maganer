<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('tasks')->group(function () {
    route::get('/', [TaskController::class, 'index'])->name('tasks');
    route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
    route::get('/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    route::put('/{task}', [TaskController::class, 'update'])->name('tasks.update');
    route::delete('/{task}', [TaskController::class, 'destroy'])->name('tasks.delete');

    route::patch('/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
});
