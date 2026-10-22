@extends('layouts.app')

@section('title', $t('hero_title'))
@section('meta_description', $t('hero_intro'))

@section('content')

<section class="bg-blue-wash py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <x-eyebrow align="center">{{ $t('hero_eyebrow') }}</x-eyebrow>
        <h1 class="text-4xl sm:text-5xl font-serif text-navy leading-tight">{{ $t('hero_title') }}</h1>
        <p class="mt-5 text-lg text-slate-ink">{{ $t('hero_intro') }}</p>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        @foreach($industries as $industry)
            <div id="{{ $industry->extra_text }}" data-animate class="grid lg:grid-cols-2 gap-10 items-start scroll-mt-24">
                <div>
                    <h2 class="text-2xl font-serif text-navy">{{ $industry->title }}</h2>
                    <p class="mt-1 text-brand-red-deep font-medium">{{ $industry->subtitle }}</p>
                    <p class="mt-4 text-slate-ink">{{ $industry->body }}</p>
                </div>
                <div class="rounded-2xl bg-surface border border-line p-6">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-ink mb-3">Roles we staff</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(($industry->points ?? []) as $role)
                            <span class="rounded-full bg-white border border-line-strong px-3 py-1.5 text-sm text-navy">{{ $role }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="specialties" class="py-20 bg-surface scroll-mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-14" data-animate>
            <x-eyebrow>{{ $t('specialties_eyebrow') }}</x-eyebrow>
            <h2 class="text-3xl font-serif text-navy">{{ $t('specialties_title') }}</h2>
            <p class="mt-4 text-slate-ink">{{ $t('specialties_intro') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($specialtyGroups as $i => $group)
                <div data-animate style="--animate-delay: {{ ($i % 4) * 0.08 }}s" class="rounded-2xl bg-white border border-line p-6">
                    <h3 class="font-semibold text-navy mb-3">{{ $group->title }}</h3>
                    <ul class="space-y-1.5">
                        @foreach(($group->points ?? []) as $role)
                            <li class="text-sm text-slate-ink">{{ $role }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="models" class="py-16 bg-navy text-white text-center scroll-mt-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" data-animate>
        <h2 class="text-2xl font-serif">Need healthcare talent, fast?</h2>
        <p class="mt-3 text-mist">Tell us about your staffing needs and a recruiter will respond with a clear plan.</p>
        <a href="/contact" class="mt-6 inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-navy hover:bg-ice transition">Request Talent</a>
    </div>
</section>

@endsection
