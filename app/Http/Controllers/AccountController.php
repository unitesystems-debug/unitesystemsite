<?php

namespace App\Http\Controllers;

use App\Services\ResumeUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function edit(Request $request)
    {
        $profile = $request->user()->candidateProfile;
        $applications = $request->user()->jobApplications()->with('job')->latest()->get();

        return view('pages.account', compact('profile', 'applications'));
    }

    public function update(Request $request)
    {
        $profile = $request->user()->candidateProfile;

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => ['required', 'string', 'max:40', 'regex:/^[0-9+().\-\s]{7,20}$/'],
            'profession' => 'nullable|string|max:120',
            'locations' => 'required|string|max:255',
            'languages' => 'nullable|string|max:255',
            'skills' => 'nullable|string|max:3000',
            'experience_years' => 'nullable|string|max:20',
            'disability_status' => 'nullable|in:yes,no,prefer_not',
            'accommodation' => 'nullable|string|max:1000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $profile->fill([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'profession' => $validated['profession'] ?? null,
            'locations' => $validated['locations'],
            'languages' => $validated['languages'] ?? null,
            'skills' => $validated['skills'] ?? null,
            'experience_years' => $validated['experience_years'] ?? null,
            'disability_status' => $validated['disability_status'] ?? $profile->disability_status,
            'accommodation' => $validated['accommodation'] ?? null,
            'sms_consent' => $request->boolean('sms_consent'),
        ]);

        if ($request->hasFile('resume')) {
            $upload = ResumeUploader::store($request->file('resume'));
            $profile->resume_path = $upload['path'];
            $profile->resume_name = $upload['name'];
        }

        $profile->save();

        // Keep the display name on the user record in sync.
        $request->user()->update(['name' => $profile->fullName()]);

        return back()->with('status', 'Your profile has been updated.');
    }

    public function downloadResume(Request $request)
    {
        $profile = $request->user()->candidateProfile;
        abort_unless($profile && $profile->resume_path, 404);

        return Storage::disk('local')->download($profile->resume_path, $profile->resume_name ?: 'resume.pdf');
    }
}

