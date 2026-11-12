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

@if($roles->isNotEmpty())
    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" data-animate>
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-ink mb-4">{{ $t('roles_label', 'Roles we staff') }}</p>
            <div class="flex flex-wrap gap-2.5">
                @foreach($roles as $role)
                    <span class="rounded-full bg-surface border border-line-strong px-4 py-2 text-sm text-navy">{{ $role->title }}</span>
                @endforeach
            </div>
        </div>
    </section>
@endif

@if($specialtyGroups->isNotEmpty())
    <section class="py-20 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mb-14" data-animate>
                <x-eyebrow>{{ $t('specialties_eyebrow', 'Specialties') }}</x-eyebrow>
                <h2 class="text-3xl font-serif text-navy">{{ $t('specialties_title', 'A closer look at what we place.') }}</h2>
                @if($t('specialties_intro'))
                    <p class="mt-4 text-slate-ink">{{ $t('specialties_intro') }}</p>
                @endif
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
@endif

<section class="py-16 bg-navy text-white text-center">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" data-animate>
        <h2 class="text-2xl font-serif">{{ $t('cta_title', 'Need talent, fast?') }}</h2>
        <p class="mt-3 text-mist">{{ $t('cta_body', 'Tell us about your staffing needs and a recruiter will respond with a clear plan.') }}</p>
        <a href="/contact" class="mt-6 inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-navy hover:bg-ice transition">{{ $t('cta_label', 'Request Talent') }}</a>
    </div>
</section>

@endsection
