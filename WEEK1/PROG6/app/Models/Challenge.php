<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = ['hint', 'file_path'];

    public function statuses()
    {
        return $this->hasMany(ChallengeStatus::class);
    }
}
