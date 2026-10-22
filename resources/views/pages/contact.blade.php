@extends('layouts.app')

@section('title', $t('hero_title'))
@section('meta_description', $t('hero_intro'))

@section('content')

<section class="bg-blue-wash py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <x-eyebrow align="center">{{ $t('hero_eyebrow') }}</x-eyebrow>
        <h1 class="text-4xl sm:text-5xl font-serif text-navy leading-tight">{{ $t('hero_title') }}</h1>
        <p class="mt-5 text-lg text-slate-ink">{{ $t('hero_intro') }}</p>
    </div>
</section>

<section class="py-16 bg-white" x-data="{ audience: '{{ $audience }}' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-5 gap-12">
        <div class="lg:col-span-2">
            <div class="inline-flex rounded-full bg-surface p-1 mb-8">
                <button type="button" @click="audience = 'employer'" :class="audience==='employer' ? 'bg-navy text-white' : 'text-slate-ink'" class="rounded-full px-4 py-2 text-sm font-semibold transition">I'm hiring</button>
                <button type="button" @click="audience = 'professional'" :class="audience==='professional' ? 'bg-navy text-white' : 'text-slate-ink'" class="rounded-full px-4 py-2 text-sm font-semibold transition">I'm looking for work</button>
            </div>

            <h3 class="font-semibold text-navy text-lg mb-4">What happens next</h3>
            <ol class="space-y-4">
                @foreach($nextSteps as $i => $step)
                    <li class="flex gap-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-ice text-brand-blue-deep text-sm font-semibold">{{ $i + 1 }}</span>
                        <span class="text-sm text-slate-ink">{{ $step->body }}</span>
                    </li>
                @endforeach
            </ol>

            <div class="mt-10 space-y-2 text-sm text-slate-ink">
                <p><strong class="text-navy">Phone:</strong> <a href="{{ $siteCompany['phone_href'] }}" class="hover:text-brand-blue-deep">{{ $siteCompany['phone'] }}</a></p>
                <p><strong class="text-navy">Email:</strong> <a href="mailto:{{ $siteCompany['email'] }}" class="hover:text-brand-blue-deep">{{ $siteCompany['email'] }}</a></p>
                @if($t('office_hours'))<p><strong class="text-navy">Hours:</strong> {{ $t('office_hours') }}</p>@endif
            </div>
        </div>

        <div class="lg:col-span-3">
            @if(session('status'))
                <div class="mb-4 rounded-lg bg-teal-wash text-teal-deep text-sm p-3">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="mb-4 rounded-lg bg-red-wash text-brand-red-deep text-sm p-3">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data" class="rounded-2xl border border-line bg-surface p-6 space-y-4 shadow-sm">
                @csrf
                @php($inputClass = 'w-full rounded-lg border border-line-strong bg-white px-3.5 py-2.5 text-sm text-navy placeholder:text-slate-ink/60 focus:outline-none focus:ring-2 focus:ring-brand-red-deep/25 focus:border-brand-red-deep transition')
                @php($fileClass = 'block w-full text-sm text-slate-ink file:mr-3 file:rounded-full file:border-0 file:bg-red-tint file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-red-deep hover:file:bg-red-wash file:cursor-pointer cursor-pointer')
                <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                <input type="hidden" name="audience" :value="audience">

                <div class="grid sm:grid-cols-2 gap-4">
                    <input type="text" name="name" placeholder="Full name" required value="{{ old('name') }}" class="{{ $inputClass }}">
                    <input type="email" name="email" placeholder="Email address" required value="{{ old('email') }}" class="{{ $inputClass }}">
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <input type="tel" name="phone" placeholder="Phone number" value="{{ old('phone') }}" class="{{ $inputClass }}">
                    <input type="text" name="location" placeholder="City, state" value="{{ old('location') }}" class="{{ $inputClass }}">
                </div>

                <div x-show="audience === 'employer'" class="grid sm:grid-cols-2 gap-4">
                    <input type="text" name="organization" placeholder="Organization name" value="{{ old('organization') }}" class="{{ $inputClass }}">
                </div>

                <div x-show="audience === 'professional'">
                    <select name="profession" class="{{ $inputClass }}">
                        <option value="">Profession / specialty</option>
                        @foreach($professions as $p)
                            <option value="{{ $p->title }}" @selected(old('profession') === $p->title)>{{ $p->title }}</option>
                        @endforeach
                    </select>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-navy mb-1.5">Resume (optional)</label>
                        <input type="file" name="resume" class="{{ $fileClass }}">
                    </div>
                </div>

                <textarea name="message" rows="4" placeholder="Tell us more…" class="{{ $inputClass }}">{{ old('message') }}</textarea>

                <label class="flex items-start gap-2.5 text-xs text-slate-ink leading-relaxed">
                    <input type="checkbox" name="sms_consent" value="1" class="mt-0.5 h-4 w-4 shrink-0 rounded border-line-strong text-brand-red-deep focus:ring-brand-red-deep">
                    <span>By providing a phone number and submitting this form you are consenting to be contacted by SMS text message. Message and Data Rates may apply. Message frequency may vary. You can STOP messaging by sending STOP and get more help by sending HELP <em>at any time</em>. View our <a href="https://www.unitehealthstaff.com/privacy-policy" class="underline hover:text-brand-red-deep">Privacy Policy</a>.</span>
                </label>

                <button class="w-full rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition shadow-sm">Send message</button>
            </form>
        </div>
    </div>
</section>

<section class="py-16 bg-surface" x-data="{ tab: 'employer' }">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-navy text-center mb-8">Frequently asked questions</h2>
        <div class="flex justify-center gap-2 mb-8">
            <button @click="tab='employer'" :class="tab==='employer' ? 'bg-navy text-white' : 'bg-white text-slate-ink'" class="rounded-full px-4 py-2 text-sm font-semibold transition">For employers</button>
            <button @click="tab='professional'" :class="tab==='professional' ? 'bg-navy text-white' : 'bg-white text-slate-ink'" class="rounded-full px-4 py-2 text-sm font-semibold transition">For professionals</button>
        </div>
        <div x-show="tab==='employer'" class="space-y-3">
            @foreach($faqsEmployers as $faq)
                <details class="rounded-xl bg-white border border-line p-4">
                    <summary class="font-medium text-navy cursor-pointer text-sm">{{ $faq->title }}</summary>
                    <p class="mt-2 text-sm text-slate-ink">{{ $faq->body }}</p>
                </details>
            @endforeach
        </div>
        <div x-show="tab==='professional'" x-cloak class="space-y-3">
            @foreach($faqsProfessionals as $faq)
                <details class="rounded-xl bg-white border border-line p-4">
                    <summary class="font-medium text-navy cursor-pointer text-sm">{{ $faq->title }}</summary>
                    <p class="mt-2 text-sm text-slate-ink">{{ $faq->body }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

@endsection
