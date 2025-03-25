<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        // Áp dụng middleware role.student cho tất cả các phương thức
        $this->middleware('role.student');
    }

    // Hiển thị danh sách bài tập
    public function indexAssignments()
    {
        return view('student.assignments.index');
    }

    // Hiển thị form nộp bài
    public function createSubmission()
    {
        return view('student.submissions.create');
    }

    // Hiển thị danh sách challenge
    public function indexChallenges()
    {
        return view('student.challenges.index');
    }

    // Hiển thị form chỉnh sửa thông tin cá nhân
    public function editProfile()
    {
        return view('student.profile.edit');
    }
}
