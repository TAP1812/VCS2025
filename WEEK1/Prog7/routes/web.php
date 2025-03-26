<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChallengeController;
use App\Http\Middleware\TeacherMiddleware;
use App\Http\Middleware\StudentMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Assignment routes
    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store')->middleware(TeacherMiddleware::class);
    Route::post('assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit')->middleware(StudentMiddleware::class);
    Route::get('download/assignments/{filePath}', [AssignmentController::class, 'download'])->name('download');

    // Message routes
    Route::post('messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    Route::put('messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Challenge routes
    Route::get('challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::post('challenges', [ChallengeController::class, 'store'])->name('challenges.store')->middleware(TeacherMiddleware::class);
    Route::post('challenges/{challenge}/solve', [ChallengeController::class, 'solve'])->name('challenges.solve')->middleware(StudentMiddleware::class);
});
