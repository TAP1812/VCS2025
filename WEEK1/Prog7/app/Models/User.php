<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'password', 
        'fullname',
        'email',
        'phone',
        'role',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent() 
    {
        return $this->role === 'student';
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }

    public function challengeStatuses()
    {
        return $this->hasMany(ChallengeStatus::class, 'student_id');
    }
}
