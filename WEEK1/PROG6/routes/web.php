<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

// Các route hiện có
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Route cho sinh viên
Route::get('/student/assignments', [StudentController::class, 'indexAssignments'])->name('student.assignments.index')->middleware('auth');
Route::get('/student/submissions/create', [StudentController::class, 'createSubmission'])->name('student.submissions.create')->middleware('auth');
Route::get('/student/challenges', [StudentController::class, 'indexChallenges'])->name('student.challenges.index')->middleware('auth');
Route::get('/student/profile/edit', [StudentController::class, 'editProfile'])->name('student.profile.edit')->middleware('auth');

// Route placeholder cho giáo viên (sẽ triển khai sau)
Route::get('/teacher/students', function () {
    return 'Danh sách sinh viên';
})->middleware(['auth', 'role.teacher'])->name('teacher.students.index');
Route::get('/teacher/assignments/create', function () {
    return 'Form giao bài tập';
})->middleware(['auth', 'role.teacher'])->name('teacher.assignments.create');
Route::get('/teacher/submissions', function () {
    return 'Danh sách bài làm';
})->middleware(['auth', 'role.teacher'])->name('teacher.submissions.index');
Route::get('/teacher/challenges/create', function () {
    return 'Form tạo challenge';
})->middleware(['auth', 'role.teacher'])->name('teacher.challenges.create');

// Route placeholder cho chức năng chung (sẽ triển khai sau)
Route::get('/users', function () {
    return 'Danh sách người dùng';
})->middleware('auth')->name('users.index');
Route::get('/messages', function () {
    return 'Trang nhắn tin';
})->middleware('auth')->name('messages.index');
