@extends('layouts.app')

@section('title', 'My Account')

@section('content')
<section class="bg-blue-wash py-14">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-navy">My Account</h1>
        <p class="mt-2 text-slate-ink">Manage your candidate profile and track your applications.</p>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        @if(session('status'))
            <div class="rounded-lg bg-teal-wash text-teal-deep text-sm p-3">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="rounded-lg bg-red-wash text-brand-red-deep text-sm p-3">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="rounded-2xl border border-line p-6">
            <h2 class="font-semibold text-navy text-lg mb-5">Profile</h2>
            @php($inputClass = 'w-full rounded-lg border border-line-strong bg-white px-3.5 py-2.5 text-sm text-navy placeholder:text-slate-ink/60 focus:outline-none focus:ring-2 focus:ring-brand-red-deep/25 focus:border-brand-red-deep transition')
            @php($fileClass = 'block w-full text-sm text-slate-ink file:mr-3 file:rounded-full file:border-0 file:bg-red-tint file:px-4 file:py-2 file:text-xs file:font-semibold file:text-brand-red-deep hover:file:bg-red-wash file:cursor-pointer cursor-pointer')
            <form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <input type="text" name="first_name" placeholder="First name" required value="{{ old('first_name', $profile->first_name) }}" class="{{ $inputClass }}">
                    <input type="text" name="last_name" placeholder="Last name" required value="{{ old('last_name', $profile->last_name) }}" class="{{ $inputClass }}">
                    <input type="tel" name="phone" placeholder="Phone number" required value="{{ old('phone', $profile->phone) }}" class="{{ $inputClass }}">
                    <input type="text" name="profession" placeholder="Profession / specialty" value="{{ old('profession', $profile->profession) }}" class="{{ $inputClass }}">
                    <input type="text" name="locations" placeholder="Preferred locations" required value="{{ old('locations', $profile->locations) }}" class="{{ $inputClass }} sm:col-span-2">
                    <input type="text" name="languages" placeholder="Languages spoken" value="{{ old('languages', $profile->languages) }}" class="{{ $inputClass }}">
                    <input type="text" name="experience_years" placeholder="Years of experience" value="{{ old('experience_years', $profile->experience_years) }}" class="{{ $inputClass }}">
                </div>
                <textarea name="skills" rows="3" placeholder="Skills & certifications" class="{{ $inputClass }}">{{ old('skills', $profile->skills) }}</textarea>

                <div>
                    <label class="block text-sm font-medium text-navy mb-1.5">Resume</label>
                    @if($profile->resume_name)
                        <p class="text-sm text-slate-ink mb-2">On file: <a href="{{ route('account.resume') }}" class="text-brand-red-deep underline">{{ $profile->resume_name }}</a></p>
                    @endif
                    <input type="file" name="resume" class="{{ $fileClass }}">
                </div>

                <label class="flex items-center gap-2.5 text-sm text-slate-ink">
                    <input type="checkbox" name="sms_consent" value="1" class="h-4 w-4 rounded border-line-strong text-brand-red-deep focus:ring-brand-red-deep" @checked(old('sms_consent', $profile->sms_consent))>
                    <span>Receive SMS updates about opportunities.</span>
                </label>

                <button class="rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition shadow-sm">Save changes</button>
            </form>
        </div>

        <div>
            <h2 class="font-semibold text-navy text-lg mb-5">My applications</h2>
            @if($applications->isEmpty())
                <p class="text-sm text-slate-ink">You haven't applied to any roles yet. <a href="{{ route('jobs.index') }}" class="text-brand-blue-deep underline">Browse open jobs</a>.</p>
            @else
                <div class="overflow-x-auto rounded-2xl border border-line">
                    <table class="w-full text-sm">
                        <thead class="bg-surface text-left">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-navy">Job</th>
                                <th class="px-4 py-3 font-semibold text-navy">Applied</th>
                                <th class="px-4 py-3 font-semibold text-navy">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line">
                            @foreach($applications as $app)
                                <tr>
                                    <td class="px-4 py-3">
                                        @if($app->job)
                                            <a href="{{ route('jobs.show', $app->job->slug) }}" class="text-brand-blue-deep hover:underline">{{ $app->job->title }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-slate-ink">{{ $app->created_at->format('M j, Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                            @class([
                                                'bg-ice text-brand-blue-deep' => $app->status === 'new',
                                                'bg-amber/20 text-amber' => $app->status === 'reviewing',
                                                'bg-teal-wash text-teal-deep' => in_array($app->status, ['shortlisted','placed']),
                                                'bg-red-wash text-brand-red-deep' => $app->status === 'rejected',
                                            ])">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
