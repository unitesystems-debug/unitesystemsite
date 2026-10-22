@extends('layouts.app')

@section('title', $t('title', 'Create your candidate profile'))

@section('content')
<section class="bg-blue-wash py-14">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-3xl sm:text-4xl font-serif text-navy">{{ $t('title') }}</h1>
        <p class="mt-3 text-slate-ink">{{ $t('intro') }}</p>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($errors->any())
            <div class="mb-6 rounded-lg bg-red-wash text-brand-red-deep text-sm p-4">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        @php($inputClass = 'w-full rounded-lg border border-line-strong bg-white px-3.5 py-2.5 text-sm text-navy placeholder:text-slate-ink/60 focus:outline-none focus:ring-2 focus:ring-brand-red-deep/25 focus:border-brand-red-deep transition')
        @php($fileClass = 'block w-full text-sm text-slate-ink file:mr-3 file:rounded-full file:border-0 file:bg-red-tint file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-red-deep hover:file:bg-red-wash file:cursor-pointer cursor-pointer')
        @php($checkboxClass = 'mt-0.5 h-4 w-4 shrink-0 rounded border-line-strong text-brand-red-deep focus:ring-brand-red-deep')

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">

            <div class="rounded-2xl border border-line p-6 space-y-4">
                <h2 class="font-semibold text-navy">Account</h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <input type="email" name="email" placeholder="Email address" required value="{{ old('email') }}" class="{{ $inputClass }} sm:col-span-2">
                    <input type="password" name="password" placeholder="Create a password" required class="{{ $inputClass }}">
                    <input type="password" name="password_confirmation" placeholder="Confirm password" required class="{{ $inputClass }}">
                </div>
            </div>

            <div class="rounded-2xl border border-line p-6 space-y-4">
                <h2 class="font-semibold text-navy">Candidate profile</h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <input type="text" name="first_name" placeholder="First name" required value="{{ old('first_name') }}" class="{{ $inputClass }}">
                    <input type="text" name="last_name" placeholder="Last name" required value="{{ old('last_name') }}" class="{{ $inputClass }}">
                    <input type="tel" name="phone" placeholder="Phone number" required value="{{ old('phone') }}" class="{{ $inputClass }}">
                    <input type="text" name="profession" placeholder="Profession / specialty" value="{{ old('profession') }}" class="{{ $inputClass }}">
                    <input type="text" name="locations" placeholder="Preferred locations" required value="{{ old('locations') }}" class="{{ $inputClass }} sm:col-span-2">
                    <input type="text" name="languages" placeholder="Languages spoken" value="{{ old('languages') }}" class="{{ $inputClass }}">
                    <input type="text" name="experience_years" placeholder="Years of experience" value="{{ old('experience_years') }}" class="{{ $inputClass }}">
                </div>
                <textarea name="skills" rows="3" placeholder="Skills & certifications" class="{{ $inputClass }}">{{ old('skills') }}</textarea>

                <div>
                    <label class="block text-sm font-medium text-navy mb-1.5">Resume (PDF or Word)</label>
                    <input type="file" name="resume" required class="{{ $fileClass }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-navy mb-1.5">Do you have a disability requiring accommodation? <span class="text-xs text-slate-ink font-normal">(optional)</span></label>
                    <select name="disability_status" class="{{ $inputClass }}">
                        <option value="prefer_not" selected>Prefer not to say</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <textarea name="accommodation" rows="2" placeholder="Accommodation notes (optional)" class="{{ $inputClass }}">{{ old('accommodation') }}</textarea>
                <p class="text-xs text-slate-ink">{{ $t('eeo_note') }}</p>
            </div>

            <div class="space-y-3">
                <label class="flex items-start gap-2.5 text-sm text-slate-ink leading-relaxed">
                    <input type="checkbox" name="adult_confirmed" value="1" required class="{{ $checkboxClass }}">
                    <span>I confirm that I am 18 years of age or older.</span>
                </label>
                <label class="flex items-start gap-2.5 text-sm text-slate-ink leading-relaxed">
                    <input type="checkbox" name="sms_consent" value="1" class="{{ $checkboxClass }}">
                    <span>I agree to receive SMS updates about opportunities. Message & data rates may apply.</span>
                </label>
                <label class="flex items-start gap-2.5 text-sm text-slate-ink leading-relaxed">
                    <input type="checkbox" name="consent" value="1" required class="{{ $checkboxClass }}">
                    <span>I agree to the <a href="/privacy" class="underline text-brand-red-deep">privacy policy</a>.</span>
                </label>
            </div>

            <button class="w-full rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition shadow-sm">Create my profile</button>
            <p class="text-center text-sm text-slate-ink">Already registered? <a href="{{ route('login') }}" class="text-brand-red-deep font-medium hover:underline">Sign in</a></p>
        </form>
    </div>
</section>
@endsection
