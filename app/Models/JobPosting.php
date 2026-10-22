<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category', 'location', 'job_type', 'shift', 'pay', 'summary',
        'description', 'requirements', 'benefits', 'status', 'featured',
    ];

    protected function casts(): array
    {
        return [
            'requirements' => 'array',
            'benefits' => 'array',
            'featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (JobPosting $job) {
            if (blank($job->slug)) {
                $job->slug = Str::slug($job->title).'-'.Str::lower(Str::random(5));
            }
        });
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
}
