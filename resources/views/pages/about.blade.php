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
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" data-animate>
        <x-eyebrow>{{ $t('story_eyebrow') }}</x-eyebrow>
        <h2 class="text-3xl font-serif text-navy mb-6">{{ $t('story_title') }}</h2>
        <div class="prose-content text-slate-ink">{!! $t('story_body') !!}</div>

        <div class="mt-12 grid md:grid-cols-2 gap-6">
            <div class="rounded-2xl bg-ice p-7">
                <h3 class="font-semibold text-navy text-lg mb-2">Our mission</h3>
                <p class="text-sm text-slate-ink">{{ $t('mission') }}</p>
            </div>
            <div class="rounded-2xl bg-teal-wash p-7">
                <h3 class="font-semibold text-navy text-lg mb-2">Our vision</h3>
                <p class="text-sm text-slate-ink">{{ $t('vision') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-14" data-animate>
            <x-eyebrow>{{ $t('values_eyebrow') }}</x-eyebrow>
            <h2 class="text-3xl font-serif text-navy">{{ $t('values_title') }}</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($values as $i => $v)
                <div data-animate style="--animate-delay: {{ ($i % 3) * 0.1 }}s" class="rounded-2xl bg-white border border-line p-6">
                    <h3 class="font-semibold text-navy">{{ $v->title }}</h3>
                    <p class="mt-2 text-sm text-slate-ink">{{ $v->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section id="why" class="py-20 bg-navy text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-14" data-animate>
            <div class="flex items-center gap-2 mb-3">
                <span class="h-px w-6 bg-brand-red shrink-0"></span>
                <span class="text-xs font-semibold uppercase tracking-wide text-brand-red">{{ $t('why_eyebrow') }}</span>
            </div>
            <h2 class="text-3xl font-serif">{{ $t('why_title') }}</h2>
            <p class="mt-4 text-mist">{{ $t('why_intro') }}</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-14">
            @foreach($principles as $i => $p)
                <div data-animate style="--animate-delay: {{ ($i % 3) * 0.1 }}s" class="rounded-2xl bg-navy-soft p-6">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10"><x-app-icon :name="$p->icon" class="w-5 h-5" /></span>
                    <h3 class="mt-3 font-semibold">{{ $p->title }}</h3>
                    <p class="mt-1 text-sm text-mist">{{ $p->body }}</p>
                </div>
            @endforeach
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 border-t border-white/10 pt-10">
            @foreach($facts as $f)
                <div>
                    <p class="text-xs uppercase tracking-wide text-mist">{{ $f->title }}</p>
                    <p class="mt-1 font-semibold text-lg">{{ $f->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-10" data-animate>
            <x-eyebrow>{{ $t('locations_eyebrow') }}</x-eyebrow>
            <h2 class="text-3xl font-serif text-navy">{{ $t('locations_title') }}</h2>
        </div>
        <div class="grid sm:grid-cols-2 gap-6">
            @foreach($locations as $i => $loc)
                <div data-animate style="--animate-delay: {{ $i * 0.1 }}s" class="rounded-2xl bg-blue-wash p-7">
                    <h3 class="font-semibold text-navy">{{ $loc->title }}</h3>
                    <p class="mt-1 text-sm text-slate-ink">{{ $loc->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
