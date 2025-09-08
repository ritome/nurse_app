<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserDeleteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/user/delete', [UserDeleteController::class, 'destroy'])->name('user.delete');
    Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
    Route::get('/program/notes', function () {
        return view('program.notes');
    })->name('program.notes');
});

require __DIR__ . '/auth.php';
