<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResumeUploader
{
    /**
     * Store an uploaded resume on the private "local" disk and return its
     * relative path + the original file name, or null if nothing was uploaded.
     *
     * @return array{path: string, name: string}|null
     */
    public static function store(?UploadedFile $file): ?array
    {
        if (! $file) {
            return null;
        }

        $filename = Str::random(32).'.'.$file->getClientOriginalExtension();
        $path = Storage::disk('local')->putFileAs('resumes', $file, $filename);

        return ['path' => $path, 'name' => $file->getClientOriginalName()];
    }
}

