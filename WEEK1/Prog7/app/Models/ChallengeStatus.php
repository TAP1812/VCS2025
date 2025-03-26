<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallengeStatus extends Model
{
    protected $table = 'challenge_status';
    
    protected $fillable = [
        'student_id',
        'challenge_id',
        'status',
        'solved_at'
    ];

    protected $casts = [
        'solved_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}
