<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['disk', 'path', 'original_name', 'mime', 'size', 'alt_text'];

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk ?: 'public')->url($this->path);
    }
}
