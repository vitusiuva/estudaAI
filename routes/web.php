<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\StudyLogController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('plans', PlanController::class);
    Route::resource('disciplines', DisciplineController::class);
    Route::resource('study-logs', StudyLogController::class);
    Route::resource('topics', TopicController::class);
    Route::resource('revisions', RevisionController::class);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
