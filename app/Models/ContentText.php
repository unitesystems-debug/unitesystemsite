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

    /**
     * Resolve a "carousel" type field: a JSON-encoded {images: [...], interval: seconds}
     * payload. Returns public URLs and the rotation interval in milliseconds.
     * Also gracefully reads a legacy plain "image" value as a single-slide carousel.
     */
    public static function carousel(string $page, string $key): array
    {
        $decoded = static::decodeCarousel(static::text($page, $key, ''));

        return [
            'images' => array_map(
                fn (string $path) => str_starts_with($path, 'http') ? $path : Storage::disk('public')->url($path),
                $decoded['images']
            ),
            'interval' => $decoded['interval'] * 1000,
        ];
    }

    /** Decode a carousel field's stored JSON value into images + interval (seconds). */
    public static function decodeCarousel(?string $value): array
    {
        $decoded = json_decode((string) $value, true);

        if (is_array($decoded) && array_key_exists('images', $decoded)) {
            return [
                'images' => array_values(array_filter((array) $decoded['images'])),
                'interval' => max(1, (int) ($decoded['interval'] ?? 6)),
            ];
        }

        // Legacy / plain value: treat a single non-JSON path as one image.
        return [
            'images' => blank($value) ? [] : [$value],
            'interval' => 6,
        ];
    }

    /** Encode images + interval (seconds) into a carousel field's stored JSON value. */
    public static function encodeCarousel(array $images, int $interval = 6): string
    {
        return json_encode([
            'images' => array_values(array_filter($images)),
            'interval' => max(1, $interval),
        ]);
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
