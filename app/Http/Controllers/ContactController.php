<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\ContentItem;
use App\Models\ContentText;
use App\Services\Notifier;
use App\Services\ResumeUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $t = fn (string $key, string $default = '') => ContentText::text('contact', $key, $default);

        return view('pages.contact', [
            't' => $t,
            'audience' => $request->get('for') === 'professional' ? 'professional' : 'employer',
            'nextSteps' => ContentItem::group('contact_next_steps'),
            'faqsEmployers' => ContentItem::group('faqs_employers'),
            'faqsProfessionals' => ContentItem::group('faqs_professionals'),
            'professions' => ContentItem::group('specialties'),
        ]);
    }

    public function store(Request $request)
    {
        // Honeypot field — silently succeed for bots.
        if (filled($request->input('website'))) {
            return back()->with('status', 'Thanks — we received your message.');
        }

        $validated = $request->validate([
            'audience' => 'nullable|in:professional,employer',
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:190',
            'phone' => 'nullable|string|max:40',
            'organization' => 'nullable|string|max:160',
            'profession' => 'nullable|string|max:120',
            'location' => 'nullable|string|max:160',
            'message' => 'nullable|string|max:4000',
            'sms_consent' => 'nullable|boolean',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $upload = ResumeUploader::store($request->file('resume'));

        $contact = ContactMessage::create([
            'audience' => $validated['audience'] ?? null,
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'] ?? null,
            'organization' => $validated['organization'] ?? null,
            'profession' => $validated['profession'] ?? null,
            'location' => $validated['location'] ?? null,
            'message' => $validated['message'] ?? null,
            'sms_consent' => $request->boolean('sms_consent'),
            'resume_path' => $upload['path'] ?? null,
            'resume_name' => $upload['name'] ?? null,
        ]);

        Notifier::notifyAdmin(
            'Website enquiry: '.$validated['name'],
            'New website enquiry',
            [
                'I am' => ($validated['audience'] ?? 'employer') === 'professional' ? 'Looking for work' : 'Hiring',
                'Name' => $validated['name'],
                'Email' => $contact->email,
                'Phone' => $validated['phone'] ?? '—',
                'Organization' => $validated['organization'] ?? '—',
                'Profession' => $validated['profession'] ?? '—',
                'Location' => $validated['location'] ?? '—',
                'Message' => $validated['message'] ?? '—',
                'SMS consent' => $request->boolean('sms_consent') ? 'Yes' : 'No',
            ],
            $upload ? [['path' => Storage::disk('local')->path($upload['path']), 'name' => $upload['name']]] : [],
            [$contact->email, $validated['name']]
        );

        return back()->with('status', 'Thanks — we received your message. A recruiter will be in touch shortly.');
    }
}

