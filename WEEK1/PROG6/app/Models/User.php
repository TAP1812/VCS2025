<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username', 'password', 'full_name', 'email', 'phone', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    // Quan hệ sẽ được thêm sau khi tạo các model khác

    public function username()
    {
        return 'username';
    }
}
