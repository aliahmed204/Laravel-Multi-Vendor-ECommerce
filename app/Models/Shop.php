<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Shop extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'phone',
        'description',
        'address',
        'seller_id'
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('logos')
            ->useFallbackUrl(asset('images/users/sellers/shop.jpg'))
            ->singleFile();
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }


}
