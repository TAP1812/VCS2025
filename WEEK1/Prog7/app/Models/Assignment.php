<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path'
    ];

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
