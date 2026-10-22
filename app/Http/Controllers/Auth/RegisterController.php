<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\ContentText;
use App\Models\User;
use App\Services\Notifier;
use App\Services\ResumeUploader;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        $t = fn (string $key, string $default = '') => ContentText::text('register', $key, $default);

        return view('auth.register', ['t' => $t]);
    }

    public function store(Request $request)
    {
        if (filled($request->input('website'))) {
            return redirect('/');
        }

        $validated = $request->validate([
            'email' => 'required|email|max:190|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
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
            'adult_confirmed' => 'accepted',
            'consent' => 'accepted',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $upload = ResumeUploader::store($request->file('resume'));

        $user = DB::transaction(function () use ($validated, $request, $upload) {
            $user = User::create([
                'name' => $validated['first_name'].' '.$validated['last_name'],
                'email' => strtolower($validated['email']),
                'password' => $validated['password'],
                'role' => 'candidate',
            ]);

            CandidateProfile::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'profession' => $validated['profession'] ?? null,
                'locations' => $validated['locations'],
                'adult_confirmed' => $request->boolean('adult_confirmed'),
                'languages' => $validated['languages'] ?? null,
                'skills' => $validated['skills'] ?? null,
                'experience_years' => $validated['experience_years'] ?? null,
                'disability_status' => $validated['disability_status'] ?? 'prefer_not',
                'accommodation' => $validated['accommodation'] ?? null,
                'sms_consent' => $request->boolean('sms_consent'),
                'resume_path' => $upload['path'],
                'resume_name' => $upload['name'],
            ]);

            return $user;
        });

        event(new Registered($user));
        Auth::login($user);

        Notifier::notifyAdmin(
            "New candidate registration — {$validated['first_name']} {$validated['last_name']}",
            'New candidate registered',
            [
                'Name' => "{$validated['first_name']} {$validated['last_name']}",
                'Email' => $user->email,
                'Phone' => $validated['phone'],
                'Profession' => $validated['profession'] ?? '—',
                'Preferred locations' => $validated['locations'],
                'Languages' => $validated['languages'] ?? '—',
                'Skills / certifications' => $validated['skills'] ?? '—',
            ],
            [['path' => Storage::disk('local')->path($upload['path']), 'name' => $upload['name']]],
            [$user->email, $validated['first_name']]
        );

        return redirect()->route('account.edit')->with('status', 'Welcome! Your profile has been created.');
    }
}

