@extends('layouts.app')

@section('title', $t('hero_title', 'Find your next healthcare role.'))
@section('meta_description', $t('hero_intro'))

@section('content')

<section class="bg-blue-wash py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <x-eyebrow align="center">{{ $t('hero_eyebrow') }}</x-eyebrow>
        <h1 class="text-4xl sm:text-5xl font-serif text-navy leading-tight">{{ $t('hero_title') }}</h1>
        <p class="mt-5 text-lg text-slate-ink">{{ $t('hero_intro') }}</p>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" class="flex flex-wrap gap-3 mb-10 bg-surface border border-line rounded-2xl p-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by title or location…"
                   class="flex-1 min-w-[220px] rounded-lg border border-line-strong px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-brand-blue">
            <select name="category" class="rounded-lg border border-line-strong px-4 py-2.5 text-sm">
                <option value="">All categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ $cat }}</option>
                @endforeach
            </select>
            <button class="rounded-lg bg-brand-blue-deep px-5 py-2.5 text-sm font-semibold text-white hover:bg-navy transition">Search</button>
        </form>

        @if($jobs->isEmpty())
            <div class="text-center py-16 rounded-2xl bg-surface border border-line">
                <h2 class="text-xl font-semibold text-navy">{{ $t('empty_title') }}</h2>
                <p class="mt-2 text-slate-ink">{{ $t('empty_text') }}</p>
                <a href="/register" class="mt-5 inline-flex items-center rounded-full bg-brand-blue-deep px-6 py-3 text-sm font-semibold text-white">Create your profile</a>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jobs as $job)
                    <a href="{{ route('jobs.show', $job->slug) }}" class="block rounded-2xl bg-white border border-line p-6 hover:shadow-lg transition relative">
                        @if($job->featured)
                            <span class="absolute top-4 right-4 rounded-full bg-amber/20 text-amber text-xs font-semibold px-2.5 py-1">Featured</span>
                        @endif
                        <span class="inline-flex items-center rounded-full bg-teal-wash text-teal-deep text-xs font-semibold px-2.5 py-1">{{ $job->job_type ?: 'Open' }}</span>
                        <h3 class="mt-3 font-semibold text-navy">{{ $job->title }}</h3>
                        <p class="mt-1 text-sm text-slate-ink">{{ $job->location }} @if($job->shift)· {{ $job->shift }}@endif</p>
                        @if($job->pay)<p class="mt-1 text-sm font-medium text-brand-blue-deep">{{ $job->pay }}</p>@endif
                        <p class="mt-3 text-sm text-slate-ink line-clamp-3">{{ $job->summary }}</p>
                    </a>
                @endforeach
            </div>
            <div class="mt-10">{{ $jobs->links() }}</div>
        @endif

        <div class="mt-16 rounded-2xl bg-navy text-white p-10 text-center">
            <h2 class="text-2xl font-bold">{{ $t('register_prompt_title') }}</h2>
            <p class="mt-2 text-mist max-w-xl mx-auto">{{ $t('register_prompt_text') }}</p>
            <a href="/register" class="mt-6 inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-navy hover:bg-ice transition">Create Your Profile</a>
        </div>
    </div>
</section>

@endsection
