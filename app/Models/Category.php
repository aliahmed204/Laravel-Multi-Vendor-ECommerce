<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Sluggable;
    public $fillable = [
        'name',
        'slug',
        'ordering',
        'is_active',
        'parent_id',
        'description',
        'is_child_of',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public static function booted()
    {
        static::creating(function(Category $category){
            $category->ordering = self::getLatestOrderNumber();
        });
    }
    public static function getLatestOrderNumber()
    {
        $latest = Category::latest()->value('ordering');
        if ($latest) {
            return $latest + 1 ;
        }
        return '1' ;
    }
//    public static function booted()
//    {
//        static::creating(function(Category $category){
//            $category->slug = Str::slug($category->name);
//        });
//
//        static::updating(function(Category $category){
//            $category->slug = Str::slug($category->name);
//        });
//
//    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // sub categories has many children
    public function children()
    {
        return $this->hasMany(Category::class, 'is_child_of')
                ->orderBy('ordering');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function scopeIsParent($query)
    {
        return $query->whereNull('parent_id');
    }
    public function scopeIsSubCat($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeIsNotSubCatChild($query)
    {
        return $query->whereNull('is_child_of');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordering');
    }

//    public function getRouteKeyName()
//    {
//        return 'slug';
//    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('image')
            ->useFallbackUrl(asset('images/users/cats/cat.jpg'))
            ->singleFile();
    }


}
