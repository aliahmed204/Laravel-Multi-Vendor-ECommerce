<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Admin extends User implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;
    protected $guard = 'admin';
    const IMAGE_PATH = 'images/users/admins/';
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'image',
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

    public function getImageAttribute($value)
    {
        if ($value){
            return asset('images/users/admins/'.$value);
        }else{
            return asset('images/users/admins/admin1.jpg');
        }
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->useFallbackUrl(asset('images/users/admins/admin1.jpg'))
            ->singleFile();
    }

}
