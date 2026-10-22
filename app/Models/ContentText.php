<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ContentText extends Model
{
    protected $fillable = ['page', 'key', 'label', 'value', 'type', 'sort_order'];

    /**
     * Fetch a single value, falling back to the given default when not set in the DB.
     */
    public static function text(string $page, string $key, string $default = ''): string
    {
        $all = static::forPage($page);

        return $all[$key] ?? $default;
    }

    /**
     * Resolve an "image" type field to a public URL, or the default if empty.
     */
    public static function image(string $page, string $key, string $default = ''): string
    {
        $value = static::text($page, $key, '');

        if (blank($value)) {
            return $default;
        }

        return str_starts_with($value, 'http') ? $value : Storage::disk('public')->url($value);
    }

    /** All key => value pairs for a page, cached. */
    public static function forPage(string $page): array
    {
        return Cache::rememberForever("content_texts.$page", function () use ($page) {
            return static::query()->where('page', $page)->pluck('value', 'key')->all();
        });
    }

    public static function flushCache(string $page): void
    {
        Cache::forget("content_texts.$page");
    }

    protected static function booted(): void
    {
        static::saved(fn (ContentText $row) => static::flushCache($row->page));
        static::deleted(fn (ContentText $row) => static::flushCache($row->page));
    }
}
