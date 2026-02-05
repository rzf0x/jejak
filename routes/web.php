<?php

use App\Livewire\Auth\Login;
use App\Http\Controllers\Auth\GoogleController;
use App\Livewire\Dashboard;
use App\Livewire\DailyProgressForm;
use App\Livewire\DailyProgressList;
use App\Livewire\TargetForm;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Guest routes (only for non-authenticated users)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');

    // Google OAuth routes
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Targets
    Route::get('/targets/create', TargetForm::class)->name('targets.create');
    Route::get('/targets/{target}/edit', TargetForm::class)->name('targets.edit');

    // Daily Progress
    Route::get('/progress', DailyProgressList::class)->name('progress.index');
    Route::get('/progress/create', DailyProgressForm::class)->name('progress.create');

    // Logout
    Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');
});

