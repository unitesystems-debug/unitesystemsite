<?php

namespace App\Http\Controllers;

use App\Models\ContentItem;
use App\Models\JobPosting;
use App\Models\Setting;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function reply(Request $request)
    {
        if (Setting::get('chat_enabled', '1') !== '1') {
            return response()->json(['reply' => 'Chat is turned off right now. Please use the contact form instead.'], 403);
        }

        $validated = $request->validate(['message' => 'required|string|max:500']);
        $message = strtolower($validated['message']);

        // Keyword search across open jobs.
        $jobs = JobPosting::query()->open()
            ->where(function ($q) use ($message) {
                foreach (array_filter(explode(' ', $message)) as $word) {
                    if (strlen($word) < 3) {
                        continue;
                    }
                    $q->orWhere('title', 'like', "%{$word}%")
                        ->orWhere('category', 'like', "%{$word}%")
                        ->orWhere('location', 'like', "%{$word}%");
                }
            })
            ->take(3)->get();

        if ($jobs->isNotEmpty()) {
            $list = $jobs->map(fn ($j) => "• {$j->title} — {$j->location} (".url('/jobs/'.$j->slug).')')->implode("\n");

            return response()->json(['reply' => "Here are some open roles that might match:\n\n{$list}\n\nYou can see all jobs at ".url('/jobs')]);
        }

        // Keyword search across FAQs.
        $faqs = ContentItem::query()
            ->whereIn('group', ['faqs_employers', 'faqs_professionals'])
            ->where('active', true)
            ->where(function ($q) use ($message) {
                foreach (array_filter(explode(' ', $message)) as $word) {
                    if (strlen($word) < 4) {
                        continue;
                    }
                    $q->orWhere('title', 'like', "%{$word}%")->orWhere('body', 'like', "%{$word}%");
                }
            })
            ->take(1)->get();

        if ($faqs->isNotEmpty()) {
            return response()->json(['reply' => $faqs->first()->body]);
        }

        $company = Setting::get('company_name', 'Unite Systems');

        return response()->json([
            'reply' => "I can help with questions about {$company}'s services and open jobs. Try asking about a specialty (like \"nursing\" or \"imaging\"), or visit ".url('/jobs')." to browse open roles, or ".url('/contact')." to reach our team directly.",
        ]);
    }
}

