<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\ContactMessage;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Storage;

class ResumeDownloadController extends Controller
{
    public function application(JobApplication $application)
    {
        abort_unless($application->resume_path, 404);

        return Storage::disk('local')->download($application->resume_path, $application->resume_name ?: 'resume.pdf');
    }

    public function candidate(CandidateProfile $candidate)
    {
        abort_unless($candidate->resume_path, 404);

        return Storage::disk('local')->download($candidate->resume_path, $candidate->resume_name ?: 'resume.pdf');
    }

    public function contactMessage(ContactMessage $contactMessage)
    {
        abort_unless($contactMessage->resume_path, 404);

        return Storage::disk('local')->download($contactMessage->resume_path, $contactMessage->resume_name ?: 'resume.pdf');
    }
}

