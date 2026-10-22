@extends('layouts.app')

@section('title', $job->title.' — '.$job->location)
@section('meta_description', $job->summary)

@section('content')

<section class="bg-blue-wash py-14">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" data-animate>
        <a href="{{ route('jobs.index') }}" class="text-sm text-brand-red-deep font-medium hover:underline">&larr; Back to all jobs</a>
        <div class="mt-4 flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-serif text-navy">{{ $job->title }}</h1>
                <p class="mt-2 text-slate-ink">{{ $job->location }} @if($job->job_type)· {{ $job->job_type }}@endif @if($job->shift)· {{ $job->shift }}@endif</p>
                @if($job->pay)<p class="mt-1 font-semibold text-brand-red-deep">{{ $job->pay }}</p>@endif
            </div>
            <a href="#apply" class="inline-flex items-center rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition">Apply now</a>
        </div>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-8" data-animate>
            <div class="prose-content text-slate-ink">{!! $job->description !!}</div>

            @if(!empty($job->requirements))
                <div>
                    <h3 class="font-semibold text-navy text-lg mb-3">Requirements</h3>
                    <ul class="space-y-2">
                        @foreach($job->requirements as $r)
                            <li class="flex items-start gap-2 text-sm text-slate-ink"><x-app-icon name="Check" class="w-4 h-4 text-brand-teal mt-0.5 shrink-0" /> {{ $r }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($job->benefits))
                <div>
                    <h3 class="font-semibold text-navy text-lg mb-3">Benefits</h3>
                    <ul class="space-y-2">
                        @foreach($job->benefits as $b)
                            <li class="flex items-start gap-2 text-sm text-slate-ink"><x-app-icon name="Check" class="w-4 h-4 text-brand-teal mt-0.5 shrink-0" /> {{ $b }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div id="apply" class="scroll-mt-24" data-animate style="--animate-delay: 0.15s">
            <div class="rounded-2xl border border-line bg-surface p-6 sm:p-7 sticky top-24 shadow-sm">
                <h3 class="font-semibold text-navy text-lg mb-5">Apply for this role</h3>

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

                @php($isCandidateUser = auth()->check() && auth()->user()->isCandidate())
                @php($inputClass = 'w-full rounded-lg border border-line-strong bg-white px-3.5 py-2.5 text-sm text-navy placeholder:text-slate-ink/60 focus:outline-none focus:ring-2 focus:ring-brand-red-deep/25 focus:border-brand-red-deep transition')
                @php($fileClass = 'block w-full text-sm text-slate-ink file:mr-3 file:rounded-full file:border-0 file:bg-red-tint file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-red-deep hover:file:bg-red-wash file:cursor-pointer cursor-pointer')

                @if($isCandidateUser)
                    @if($alreadyApplied)
                        <p class="text-sm text-slate-ink">You've already applied for this role. We'll be in touch.</p>
                    @else
                        <form method="POST" action="{{ route('jobs.apply', $job->slug) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div class="rounded-lg bg-white border border-line px-3.5 py-2.5 text-sm text-slate-ink">
                                Applying as <strong class="text-navy">{{ auth()->user()->email }}</strong> using your saved profile{{ auth()->user()->candidateProfile?->resume_name ? ' and resume' : '' }}.
                            </div>
                            @unless(auth()->user()->candidateProfile?->resume_path)
                                <div>
                                    <label class="block text-sm font-medium text-navy mb-1.5">Resume (required — none on file)</label>
                                    <input type="file" name="resume" class="{{ $fileClass }}" required>
                                </div>
                            @endunless
                            <div>
                                <label class="block text-sm font-medium text-navy mb-1.5">Note (optional)</label>
                                <textarea name="note" rows="3" class="{{ $inputClass }}"></textarea>
                            </div>
                            <label class="flex items-start gap-2.5 text-xs text-slate-ink leading-relaxed">
                                <input type="checkbox" name="consent" value="1" required class="mt-0.5 h-4 w-4 shrink-0 rounded border-line-strong text-brand-red-deep focus:ring-brand-red-deep">
                                <span>I agree to the <a href="/privacy" class="underline text-brand-red-deep">privacy policy</a> and consent to be contacted about this application.</span>
                            </label>
                            <button class="w-full rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition shadow-sm">Submit application</button>
                        </form>
                    @endif
                @else
                    @auth
                        <div class="mb-4 rounded-lg bg-white border border-line px-3.5 py-2.5 text-sm text-slate-ink">
                            Signed in as <strong class="text-navy">{{ auth()->user()->email }}</strong>. This account isn't a candidate profile, so you can still apply below as a guest, or <a href="{{ route('register') }}" class="underline text-brand-red-deep font-medium">create a candidate profile</a>.
                        </div>
                    @endauth
                    <form method="POST" action="{{ route('jobs.apply', $job->slug) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="first_name" placeholder="First name" required value="{{ old('first_name') }}" class="{{ $inputClass }}">
                            <input type="text" name="last_name" placeholder="Last name" required value="{{ old('last_name') }}" class="{{ $inputClass }}">
                        </div>
                        <input type="email" name="email" placeholder="Email address" required value="{{ old('email') }}" class="{{ $inputClass }}">
                        <input type="tel" name="phone" placeholder="Phone number" required value="{{ old('phone') }}" class="{{ $inputClass }}">
                        <div>
                            <label class="block text-sm font-medium text-navy mb-1.5">Resume (PDF or Word)</label>
                            <input type="file" name="resume" required class="{{ $fileClass }}">
                        </div>
                        <textarea name="note" rows="3" placeholder="Note (optional)" class="{{ $inputClass }}"></textarea>
                        <label class="flex items-start gap-2.5 text-xs text-slate-ink leading-relaxed">
                            <input type="checkbox" name="consent" value="1" required class="mt-0.5 h-4 w-4 shrink-0 rounded border-line-strong text-brand-red-deep focus:ring-brand-red-deep">
                            <span>I agree to the <a href="/privacy" class="underline text-brand-red-deep">privacy policy</a> and consent to be contacted about this application.</span>
                        </label>
                        <button class="w-full rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition shadow-sm">Submit application</button>
                        @guest
                            <p class="text-xs text-center text-slate-ink">Applying to more than one role? <a href="/register" class="underline text-brand-red-deep font-medium">Create a free profile</a> instead.</p>
                        @endguest
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if($relatedJobs->count())
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
            <h3 class="text-xl font-bold text-navy mb-6">Similar roles</h3>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($relatedJobs as $rj)
                    <a href="{{ route('jobs.show', $rj->slug) }}" class="block rounded-2xl bg-white border border-line p-5 hover:shadow-lg transition">
                        <h4 class="font-semibold text-navy text-sm">{{ $rj->title }}</h4>
                        <p class="mt-1 text-xs text-slate-ink">{{ $rj->location }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</section>

@endsection
