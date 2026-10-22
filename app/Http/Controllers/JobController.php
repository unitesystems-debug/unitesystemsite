<?php

namespace App\Http\Controllers;

use App\Models\ContentText;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Services\Notifier;
use App\Services\ResumeUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = JobPosting::query()->open()->orderByDesc('featured')->latest();

        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $jobs = $query->paginate(9)->withQueryString();
        $categories = JobPosting::open()->pluck('category')->filter()->unique()->sort()->values();

        $t = fn (string $key, string $default = '') => ContentText::text('jobs', $key, $default);

        return view('jobs.index', compact('jobs', 'categories', 't'));
    }

    public function show(JobPosting $job)
    {
        abort_unless($job->status === 'open', 404);

        $alreadyApplied = false;
        if (auth()->check() && auth()->user()->isCandidate()) {
            $alreadyApplied = JobApplication::where('job_posting_id', $job->id)
                ->where('user_id', auth()->id())
                ->exists();
        }

        $relatedJobs = JobPosting::open()->where('id', '!=', $job->id)
            ->where('category', $job->category)
            ->take(3)->get();

        return view('jobs.show', compact('job', 'alreadyApplied', 'relatedJobs'));
    }

    public function apply(Request $request, JobPosting $job)
    {
        abort_unless($job->status === 'open', 404);

        // Honeypot field — silently succeed for bots.
        if (filled($request->input('website'))) {
            return back()->with('status', 'Thanks — your application has been received.');
        }

        $user = $request->user();

        if ($user && $user->isCandidate()) {
            $profile = $user->candidateProfile;
            abort_unless($profile, 422);

            $request->validate([
                'note' => 'nullable|string|max:2000',
                'consent' => 'accepted',
            ]);

            $resumePath = $profile->resume_path;
            $resumeName = $profile->resume_name;

            if ($request->hasFile('resume')) {
                $upload = ResumeUploader::store($request->file('resume'));
                $resumePath = $upload['path'];
                $resumeName = $upload['name'];
            }

            if (! $resumePath) {
                return back()->withErrors(['resume' => 'Add a resume to your profile first.'])->withInput();
            }

            $data = [
                'job_posting_id' => $job->id,
                'user_id' => $user->id,
                'first_name' => $profile->first_name,
                'last_name' => $profile->last_name,
                'email' => $user->email,
                'phone' => $profile->phone,
                'resume_path' => $resumePath,
                'resume_name' => $resumeName,
                'note' => $request->input('note'),
            ];
        } else {
            $validated = $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|max:190',
                'phone' => ['required', 'string', 'max:40', 'regex:/^[0-9+().\-\s]{7,20}$/'],
                'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
                'note' => 'nullable|string|max:2000',
                'consent' => 'accepted',
            ]);

            $upload = ResumeUploader::store($request->file('resume'));

            $data = [
                'job_posting_id' => $job->id,
                'user_id' => null,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => strtolower($validated['email']),
                'phone' => $validated['phone'],
                'resume_path' => $upload['path'],
                'resume_name' => $upload['name'],
                'note' => $validated['note'] ?? null,
            ];
        }

        $duplicate = JobApplication::where('job_posting_id', $job->id)
            ->whereRaw('LOWER(email) = ?', [strtolower($data['email'])])
            ->exists();

        if ($duplicate) {
            return back()->withErrors(['email' => 'You have already applied for this job. Our team will be in touch.']);
        }

        $application = JobApplication::create($data + ['status' => 'new']);

        Notifier::notifyAdmin(
            "New application: {$job->title} — {$data['first_name']} {$data['last_name']}",
            'New job application',
            [
                'Job' => "{$job->title} (#{$job->id})",
                'Location' => $job->location,
                'Name' => "{$data['first_name']} {$data['last_name']}",
                'Email' => $data['email'],
                'Phone' => $data['phone'],
                'Registered candidate' => $data['user_id'] ? 'Yes' : 'No',
                'Note' => $data['note'] ?: '—',
                'Application ID' => $application->id,
            ],
            [['path' => Storage::disk('local')->path($data['resume_path']), 'name' => $data['resume_name']]],
            [$data['email'], $data['first_name'].' '.$data['last_name']]
        );

        if (\App\Models\Setting::get('candidate_confirmation', '1') === '1') {
            Notifier::send(
                $data['email'],
                "We received your application — {$job->title}",
                '<p>Hi '.e($data['first_name']).',</p><p>We received your application for <strong>'.e($job->title).'</strong>. A recruiter will review it and contact you if your experience matches.</p><p>— The '.e(\App\Models\Setting::get('company_name', 'Unite Systems')).' team</p>'
            );
        }

        return back()->with('status', 'Thanks — your application has been received. A recruiter will be in touch if your experience matches.');
    }
}

