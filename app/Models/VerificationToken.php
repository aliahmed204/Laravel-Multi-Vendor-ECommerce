<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationToken extends Model
{
    use HasFactory;

    protected $fillable =[
        'verify_type',
        'verify_id',
        'email',
        'token'
    ];

    public function verify()
    {
        return $this->morphTo();
    }
}
