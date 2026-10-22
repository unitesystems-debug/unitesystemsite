<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'phone', 'profession', 'locations',
        'adult_confirmed', 'languages', 'skills', 'experience_years', 'disability_status',
        'accommodation', 'sms_consent', 'resume_path', 'resume_name',
    ];

    protected function casts(): array
    {
        return [
            'adult_confirmed' => 'boolean',
            'sms_consent' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Applications submitted by this candidate (matched via the shared user_id). */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'user_id', 'user_id');
    }

    public function fullName(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
