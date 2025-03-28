<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ProfileController;
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
    
    // User routes
    Route::get('users', [DashboardController::class, 'users'])->name('users.index');
    Route::get('users/{user}', [DashboardController::class, 'showUser'])->name('users.show');

    // Assignment routes
    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store')->middleware(TeacherMiddleware::class);
    Route::get('assignments/{assignment}/submissions', [AssignmentController::class, 'viewSubmissions'])
        ->name('assignments.submissions')
        ->middleware(TeacherMiddleware::class);
    Route::post('assignments/{assignment}/submit', [AssignmentController::class, 'submit'])->name('assignments.submit')->middleware(StudentMiddleware::class);
    Route::put('submissions/{submission}', [AssignmentController::class, 'updateSubmission'])
        ->name('submissions.update')
        ->middleware(StudentMiddleware::class);
    Route::get('assignments/{assignment}/my-submission', [AssignmentController::class, 'viewMySubmission'])
        ->name('assignments.my-submission')
        ->middleware(StudentMiddleware::class);
    Route::get('assignments/download/{filePath}', [AssignmentController::class, 'downloadAssignment'])->name('assignments.download')->where('filePath', '.*');
    Route::get('submissions/download/{filePath}', [AssignmentController::class, 'downloadSubmission'])
        ->name('submissions.download')
        ->where('filePath', '.*');

    // Message routes
    Route::post('messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    Route::put('messages/{message}', [MessageController::class, 'update'])->name('messages.update');
    Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Challenge routes
    Route::get('challenges', [ChallengeController::class, 'index'])->name('challenges.index');
    Route::post('challenges', [ChallengeController::class, 'store'])
        ->name('challenges.store')
        ->middleware(TeacherMiddleware::class);
    Route::post('challenges/{challenge}/solve', [ChallengeController::class, 'solve'])->name('challenges.solve');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
