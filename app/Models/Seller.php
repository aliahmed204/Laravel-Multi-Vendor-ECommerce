<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Seller extends User implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;

    protected $guard = 'seller';
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
        'postal_code',
        'status',
        'payment_method',
        'payment_email',
        'verified',
        'completed',
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

    public function isVerified()
    {
        return $this->verified;
    }

    public function verify()
    {
        $this->verified = 1;
        $this->email_verified_at = now();
        $this->save();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->useFallbackUrl(asset('images/users/sellers/sellers.jpg'))
            ->singleFile();
    }

    public function verifyToken(){
        return $this->morphOne(VerificationToken::class , 'verify');
    }

    public function shop()
    {
        return $this->hasOne(Shop::class);
    }
}
