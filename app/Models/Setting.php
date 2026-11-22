<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::rememberForever("setting.$key", function () use ($key, $default) {
            return static::query()->where('key', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting.$key");
    }

    public static function all_(): array
    {
        return static::query()->pluck('value', 'key')->all();
    }

    /**
     * Resolve the `social_links` setting: the new JSON array of
     * {platform, url, label?} once configured, otherwise migrate the legacy
     * single-platform settings (social_linkedin, social_facebook, etc.).
     *
     * @return array<int, array{platform: string, url: string, label?: string}>
     */
    public static function socialLinks(): array
    {
        $stored = static::get('social_links');

        if ($stored !== null) {
            return json_decode($stored, true) ?: [];
        }

        $legacy = [
            'linkedin' => static::get('social_linkedin', 'https://www.linkedin.com/company/unitesystemsllc/home/?viewAsMember=true'),
            'facebook' => static::get('social_facebook'),
            'twitter' => static::get('social_twitter'),
            'instagram' => static::get('social_instagram'),
        ];

        return collect($legacy)
            ->filter()
            ->map(fn ($url, $platform) => ['platform' => $platform, 'url' => $url])
            ->values()
            ->all();
    }
}
