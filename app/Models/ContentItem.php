<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class ContentItem extends Model
{
    protected $fillable = [
        'group', 'icon', 'title', 'subtitle', 'body', 'extra_text', 'points',
        'image_id', 'featured', 'active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'array',
            'featured' => 'boolean',
            'active' => 'boolean',
        ];
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'image_id');
    }

    /** Active items for a group, ordered, cached. */
    public static function group(string $group)
    {
        return Cache::rememberForever("content_items.$group", function () use ($group) {
            return static::query()->where('group', $group)->where('active', true)
                ->orderBy('sort_order')->orderBy('id')->get();
        });
    }

    public static function flushCache(string $group): void
    {
        Cache::forget("content_items.$group");
    }

    protected static function booted(): void
    {
        static::saved(fn (ContentItem $row) => static::flushCache($row->group));
        static::deleted(fn (ContentItem $row) => static::flushCache($row->group));
    }
}
