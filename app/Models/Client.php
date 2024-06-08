<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Client extends User
{
    use HasFactory, Notifiable;
    protected $guard = 'client';
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'image',
        'address',
        'phone',
        'email_verified_at',
        'status',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
