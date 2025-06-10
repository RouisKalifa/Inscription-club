<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

        protected $casts = [
        'name'              => 'encrypted',
        // 'email'          => 'encrypted',  <-- ligne retirée
        'role'              => 'encrypted',
        'remember_token'    => 'encrypted',
        'email_verified_at' => 'encrypted',
        'password'          => 'hashed',
        'created_at'        => 'datetime',
        'updated_at'        => 'datetime',
    ];

}
