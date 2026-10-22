<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'audience', 'name', 'email', 'phone', 'organization', 'profession', 'location',
        'message', 'sms_consent', 'resume_path', 'resume_name', 'is_read',
    ];

    protected function casts(): array
    {
        return [
            'sms_consent' => 'boolean',
            'is_read' => 'boolean',
        ];
    }
}
