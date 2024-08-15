<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GeneralSetting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const STR = 1;

    public const FILE = 2;
    protected $fillable = ['key', 'value', 'type'];

    public static function getValue($key)
    {
        return Cache::remember('settings:' . $key, 5, function () use ($key) {
            return optional(self::firstWhere('key', $key))->value;
        });
    }
    public static function getAllValues()
    {
        return Cache::remember('settings:all', 5, function () {
            return self::all()->pluck('value', 'key');
        });
    }

    public static function setValue($key, $value)
    {
        $type ??= match (true) {
            $value instanceof UploadedFile || file_exists($value) => self::FILE,
            default => self::STR,
        };

        // Clear the cache for this key to ensure the updated value is fetched next time
        Cache::forget('settings:' . $key);

        return self::updateOrCreate([
            'key' => $key
        ], [
            'type' => $type,
            'value' => $value
        ]);
    }
    public static function setValues(array $settings)
    {
        foreach ($settings as $key => $value) {
            $type = match (true) {
                $value instanceof UploadedFile || file_exists($value) => self::FILE,
                default => self::STR,
            };

            self::updateOrCreate(
                ['key' => $key],
                ['type' => $type, 'value' => $value]
            );

// Clear the cache for this key to ensure the updated value is fetched next time
//            Cache::forget('settings:' . $key);
        }
        // Clear the cache for all to ensure the updated value is fetched next time
        Cache::forget('settings:all');

        return self::getAllValues();
    }

    public function value(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return match ($this->attributes['type']) {
                   // self::FILE => asset('Settings/Uploads') . '/' . $value,
                    default => $value,
                };
            },
            set: function ($value) {
                return match ($this->attributes['type']) {
                   // self::FILE => uploadFile($value),
                    default => $value,
                };
            }
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('site_logo')
            ->useFallbackUrl(asset('images/users/admins/site_logo.jpg'))
            ->singleFile();

        $this->addMediaCollection('site_favicon')
            ->useFallbackUrl(asset('images/users/admins/site_favicon.jpg'))
            ->singleFile();

    }
}
