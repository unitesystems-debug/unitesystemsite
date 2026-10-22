@extends('layouts.app')

@section('title', $t('hero_title'))
@section('meta_description', $t('hero_intro'))

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden bg-blue-wash">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
        <div data-animate>
            <span class="inline-flex items-center rounded-full bg-blue-tint text-brand-red-deep text-xs font-semibold px-3 py-1">{{ $t('hero_badge') }}</span>
            <h1 class="mt-5 text-4xl sm:text-5xl font-serif text-navy leading-tight">{{ $t('hero_title') }}</h1>
            <p class="mt-5 text-lg text-slate-ink max-w-xl">{{ $t('hero_intro') }}</p>
            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="{{ $t('hero_primary_cta_href', '#employers') }}" class="inline-flex items-center rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition">{{ $t('hero_primary_cta_label') }}</a>
                <a href="{{ $t('hero_secondary_cta_href', '/jobs') }}" class="inline-flex items-center rounded-full border border-line-strong px-6 py-3 text-sm font-semibold text-navy hover:bg-white transition">{{ $t('hero_secondary_cta_label') }}</a>
            </div>
            <a href="{{ $t('hero_pro_link_href', '/register') }}" class="mt-5 inline-flex items-center gap-1 text-sm font-medium text-brand-red-deep hover:underline">{{ $t('hero_pro_link_label') }} <x-app-icon name="ArrowRight" class="w-4 h-4" /></a>
        </div>
        <div class="relative" data-animate style="--animate-delay: 0.15s">
            @if($heroImage)
                <img src="{{ $heroImage }}" alt="" class="rounded-2xl shadow-xl w-full object-cover aspect-[4/3]">
            @else
                <div class="rounded-2xl bg-gradient-to-br from-brand-red-deep to-navy aspect-[4/3] flex items-center justify-center shadow-xl">
                    <x-app-icon name="HeartPulse" class="w-24 h-24 text-white/30" />
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Trust bar --}}
<section class="relative bg-gradient-to-b from-teal-wash/50 to-white py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-animate class="rounded-2xl bg-white shadow-xl border border-line grid grid-cols-2 lg:grid-cols-5 overflow-hidden">
            @php($trustColors = ['bg-brand-red-deep', 'bg-navy', 'bg-brand-red-deep', 'bg-navy', 'bg-brand-red-deep'])
            @foreach($trust as $i => $item)
                <div class="p-6 md:p-7 border-line even:border-l [&:nth-child(n+3)]:border-t lg:border-t-0! lg:border-l lg:first:border-l-0">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl {{ $trustColors[$i % count($trustColors)] }} text-white shadow-sm"><x-app-icon :name="$item->icon" class="w-5 h-5" /></span>
                    <p class="mt-4 text-sm font-semibold text-navy">{{ $item->title }}</p>
                    <p class="mt-1 text-xs text-slate-ink">{{ $item->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Challenges --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-14" data-animate>
            <x-eyebrow>{{ $t('challenges_eyebrow') }}</x-eyebrow>
            <h2 class="text-3xl sm:text-4xl font-serif text-navy leading-tight">{{ $t('challenges_title') }}</h2>
            <p class="mt-4 text-slate-ink">{{ $t('challenges_intro') }}</p>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach($challenges as $i => $c)
                <div data-animate style="--animate-delay: {{ $i * 0.1 }}s" class="rounded-2xl border border-line p-7 bg-red-wash/40">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-brand-red-deep shadow-sm"><x-app-icon :name="$c->icon" class="w-5 h-5" /></span>
                    <h3 class="mt-4 font-semibold text-navy text-lg">{{ $c->title }}</h3>
                    <p class="mt-1 text-sm text-slate-ink">{{ $c->body }}</p>
                    <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-teal-deep">{{ $t('challenges_help_label') }}</p>
                    <p class="mt-1 text-sm text-navy">{{ $c->extra_text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Solutions --}}
<section id="employers" class="py-20 bg-blue-wash scroll-mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-14" data-animate>
            <x-eyebrow>{{ $t('solutions_eyebrow') }}</x-eyebrow>
            <h2 class="text-3xl sm:text-4xl font-serif text-navy leading-tight">{{ $t('solutions_title') }}</h2>
            <p class="mt-4 text-slate-ink">{{ $t('solutions_intro') }}</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($solutions as $i => $s)
                <div data-animate style="--animate-delay: {{ ($i % 3) * 0.1 }}s" class="rounded-2xl bg-white border border-line p-7 {{ $s->featured ? 'ring-2 ring-brand-red-deep' : '' }}">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-red-tint text-brand-red-deep"><x-app-icon :name="$s->icon" class="w-5 h-5" /></span>
                    <h3 class="mt-4 font-semibold text-navy text-lg">{{ $s->title }}</h3>
                    <p class="mt-2 text-sm text-slate-ink">{{ $s->body }}</p>
                    <ul class="mt-4 space-y-1.5">
                        @foreach(($s->points ?? []) as $point)
                            <li class="flex items-center gap-2 text-sm text-navy"><x-app-icon name="Check" class="w-4 h-4 text-brand-teal shrink-0" /> {{ $point }}</li>
                        @endforeach
                    </ul>
                    <a href="/contact" class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-brand-red-deep hover:underline">{{ $t('solutions_link_label') }} <x-app-icon name="ArrowRight" class="w-4 h-4" /></a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Process --}}
<section id="how-it-works" class="py-20 md:py-28 bg-white scroll-mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mb-16" data-animate>
            <x-eyebrow>{{ $t('process_eyebrow') }}</x-eyebrow>
            <h2 class="text-4xl sm:text-5xl font-serif text-navy leading-tight">{{ $t('process_title') }}</h2>
            <p class="mt-4 text-slate-ink">{{ $t('process_intro') }}</p>
        </div>
        <div class="grid md:grid-cols-4 gap-10 md:gap-6">
            @foreach($process as $i => $step)
                <div data-animate style="--animate-delay: {{ $i * 0.12 }}s" class="relative">
                    <span class="relative z-10 flex h-11 w-11 items-center justify-center rounded-2xl bg-white shadow-md border border-line text-brand-red-deep"><x-app-icon :name="$step->icon" class="w-5 h-5" /></span>
                    @unless($loop->last)
                        <div data-animate-line style="--animate-delay: {{ 0.3 + $i * 0.15 }}s" class="hidden md:block absolute top-[22px] left-11 right-[-1.5rem] h-0.5 bg-gradient-to-r from-brand-red-deep to-navy"></div>
                    @endunless
                    <span class="mt-4 block text-sm font-bold text-brand-red-deep">{{ $step->subtitle }}</span>
                    <h3 class="mt-1 font-semibold text-navy text-lg">{{ $step->title }}</h3>
                    <p class="mt-1 text-sm text-slate-ink">{{ $step->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Human expertise / People + platform --}}
<section class="py-20 md:py-28 bg-surface">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-14" data-animate>
        <x-eyebrow align="center">{{ $t('humantech_eyebrow') }}</x-eyebrow>
        <h2 class="text-4xl sm:text-5xl font-serif text-navy leading-tight">{{ $t('humantech_title') }}</h2>
        <p class="mt-4 text-slate-ink max-w-2xl mx-auto">{{ $t('humantech_intro') }}</p>
    </div>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-animate style="--animate-delay: 0.1s" class="dot-grid relative rounded-3xl border border-line bg-blue-wash/60 p-6 md:p-12 overflow-hidden">
            <div class="relative grid md:grid-cols-3 gap-8 md:gap-6 items-center">
                <div data-animate-line style="--animate-delay: 0.2s" class="hidden md:block absolute top-1/2 left-[29%] w-[7%] border-t-2 border-dashed border-brand-red-deep/50"></div>
                <div data-animate-line style="--animate-delay: 0.3s" class="hidden md:block absolute top-1/2 right-[29%] w-[7%] border-t-2 border-dashed border-navy/40"></div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-ink mb-4">{{ $t('humantech_left_label') }}</p>
                    <div class="space-y-4">
                        @foreach($humantechProfessionals as $p)
                            <div class="flex items-center gap-3 rounded-xl bg-white border border-line px-4 py-3 shadow-sm">
                                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-tint text-brand-red-deep"><x-app-icon :name="$p->icon" class="w-4 h-4" /></span>
                                <span class="text-sm font-semibold text-navy">{{ $p->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="relative rounded-2xl bg-white border-2 border-brand-red-deep shadow-xl p-6">
                    <span class="text-xs font-semibold uppercase tracking-wide text-brand-red-deep">{{ $t('humantech_hub_label') }}</span>
                    <h3 class="mt-1 font-serif text-xl text-navy">{{ $t('humantech_hub_title') }}</h3>
                    <div class="mt-4 space-y-3">
                        @foreach($humantechHubLayers as $l)
                            <div class="flex items-center gap-2 text-sm text-navy">
                                <x-app-icon :name="$l->icon" class="w-4 h-4 text-brand-red-deep shrink-0" />
                                {{ $l->title }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-ink mb-4 md:text-right">{{ $t('humantech_right_label') }}</p>
                    <div class="space-y-4">
                        @foreach($humantechOrganizations as $o)
                            <div class="flex items-center gap-3 md:flex-row-reverse rounded-xl bg-white border border-line px-4 py-3 shadow-sm">
                                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-ice text-navy"><x-app-icon :name="$o->icon" class="w-4 h-4" /></span>
                                <span class="text-sm font-semibold text-navy">{{ $o->title }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Featured jobs --}}
@if($featuredJobs->count())
<section class="py-20 bg-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10 flex-wrap gap-4" data-animate>
            <h2 class="text-3xl font-serif text-navy">Featured open roles</h2>
            <a href="/jobs" class="text-sm font-semibold text-brand-red-deep hover:underline">Browse all jobs →</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($featuredJobs as $i => $job)
                <a href="{{ route('jobs.show', $job->slug) }}" data-animate style="--animate-delay: {{ $i * 0.1 }}s" class="block rounded-2xl bg-white border border-line p-6 hover:shadow-lg transition">
                    <span class="inline-flex items-center rounded-full bg-teal-wash text-teal-deep text-xs font-semibold px-2.5 py-1">{{ $job->job_type ?: 'Open' }}</span>
                    <h3 class="mt-3 font-semibold text-navy">{{ $job->title }}</h3>
                    <p class="mt-1 text-sm text-slate-ink">{{ $job->location }}</p>
                    <p class="mt-3 text-sm text-slate-ink line-clamp-2">{{ $job->summary }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Professionals --}}
<section id="professionals" class="py-20 bg-red-wash scroll-mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-14 items-start">
        <div data-animate>
            <x-eyebrow>{{ $t('professionals_eyebrow') }}</x-eyebrow>
            <h2 class="text-3xl sm:text-4xl font-serif text-navy leading-tight">{{ $t('professionals_title') }}</h2>
            <p class="mt-4 text-slate-ink">{{ $t('professionals_intro') }}</p>
            <div class="mt-7 flex flex-wrap gap-4">
                <a href="{{ $t('professionals_primary_cta_href', '/jobs') }}" class="inline-flex items-center rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition">{{ $t('professionals_primary_cta_label') }}</a>
                <a href="{{ $t('professionals_secondary_cta_href', '/register') }}" class="inline-flex items-center rounded-full border border-line-strong px-6 py-3 text-sm font-semibold text-navy hover:bg-white transition">{{ $t('professionals_secondary_cta_label') }}</a>
            </div>
            <div class="mt-10 grid sm:grid-cols-2 gap-5">
                @foreach($professionalBenefits as $b)
                    <div class="flex items-start gap-3">
                        <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white text-brand-red-deep"><x-app-icon :name="$b->icon" class="w-4 h-4" /></span>
                        <div>
                            <p class="font-semibold text-navy text-sm">{{ $b->title }}</p>
                            <p class="text-sm text-slate-ink">{{ $b->body }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div data-animate style="--animate-delay: 0.15s">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-ink mb-4">{{ $t('professionals_specialties_label') }}</p>
            <div class="flex flex-wrap gap-2">
                @foreach($specialties as $sp)
                    <span class="rounded-full bg-white border border-red-tint px-3 py-1.5 text-sm text-navy">{{ $sp->title }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Employers --}}
<section class="py-20 bg-navy text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-14 items-start">
        <div data-animate>
            <div class="flex items-center gap-2 mb-3">
                <span class="h-px w-6 bg-brand-red shrink-0"></span>
                <span class="text-xs font-semibold uppercase tracking-wide text-brand-red">{{ $t('employers_eyebrow') }}</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-serif leading-tight">{{ $t('employers_title') }}</h2>
            <p class="mt-4 text-mist">{{ $t('employers_intro') }}</p>
            <a href="{{ $t('employers_primary_cta_href', '/contact') }}" class="mt-7 inline-flex items-center rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-white hover:text-navy transition">{{ $t('employers_primary_cta_label') }}</a>
            <p class="mt-8 text-xs uppercase tracking-wide text-mist">{{ $t('employers_sectors_label') }}</p>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach($employerSectors as $sector)
                    <span class="rounded-full bg-navy-soft px-3 py-1.5 text-sm">{{ $sector->title }}</span>
                @endforeach
            </div>
        </div>
        <div class="grid sm:grid-cols-2 gap-5">
            @foreach($employerPoints as $i => $p)
                <div data-animate style="--animate-delay: {{ 0.1 + ($i % 2) * 0.1 }}s" class="rounded-xl bg-navy-soft p-5">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/10 text-white"><x-app-icon :name="$p->icon" class="w-4 h-4" /></span>
                    <p class="mt-3 font-semibold text-sm">{{ $p->title }}</p>
                    <p class="mt-1 text-sm text-mist">{{ $p->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Testimonials --}}
<section id="testimonials" class="py-20 md:py-28 bg-blue-wash scroll-mt-24" x-data="testimonialCarousel({{ $testimonials->count() }})">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-14 items-center">
        <div data-animate>
            <x-eyebrow>{{ $t('testimonials_eyebrow') }}</x-eyebrow>
            <h2 class="text-4xl sm:text-5xl font-serif text-navy leading-tight">{{ $t('testimonials_title') }}</h2>

            @if($testimonials->count() > 1)
                <div class="mt-8 flex items-center gap-3">
                    <button type="button" @click="prev" aria-label="Previous testimonial" class="h-11 w-11 rounded-full border-2 border-brand-red-deep text-brand-red-deep flex items-center justify-center hover:bg-brand-red-deep hover:text-white transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button type="button" @click="next" aria-label="Next testimonial" class="h-11 w-11 rounded-full bg-brand-red-deep text-white flex items-center justify-center hover:bg-navy transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                    </button>
                    <div class="flex items-center gap-1.5 ml-2">
                        @foreach($testimonials as $i => $item)
                            <button type="button" @click="go({{ $i }})" aria-label="Show testimonial {{ $i + 1 }}" :class="active === {{ $i }} ? 'w-6 bg-navy' : 'w-1.5 bg-line-strong'" class="h-1.5 rounded-full transition-all"></button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="relative" data-animate style="--animate-delay: 0.15s">
            @foreach($testimonials as $i => $item)
                <div x-show="active === {{ $i }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0" class="rounded-2xl border border-line bg-white shadow-xl p-8">
                    @if($item->featured)
                        <span class="inline-flex items-center rounded-full bg-red-tint text-brand-red-deep text-xs font-semibold px-3 py-1">Placeholder — replace with a verified testimonial</span>
                    @endif
                    <span class="mt-4 block h-1 w-10 rounded-full bg-brand-red-deep"></span>
                    <p class="mt-4 font-serif text-xl text-navy leading-snug">&ldquo;{{ $item->body }}&rdquo;</p>
                    <div class="mt-6 flex items-center gap-3">
                        <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-navy text-white text-sm font-semibold">{{ \Illuminate\Support\Str::of($item->title)->explode(' ')->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}</span>
                        <div>
                            <p class="text-sm font-semibold text-navy">{{ $item->title }}</p>
                            <p class="text-xs text-slate-ink">{{ $item->subtitle }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Insights --}}
<section class="py-20 bg-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10 flex-wrap gap-4" data-animate>
            <div>
                <x-eyebrow>{{ $t('insights_eyebrow') }}</x-eyebrow>
                <h2 class="text-3xl font-serif text-navy">{{ $t('insights_title') }}</h2>
            </div>
        </div>
        <div class="grid md:grid-cols-4 gap-6">
            @foreach($insights as $i => $post)
                <div data-animate style="--animate-delay: {{ ($i % 4) * 0.08 }}s" class="rounded-2xl bg-white border border-line p-6">
                    <span class="text-xs font-semibold uppercase tracking-wide text-brand-red-deep">{{ $post->subtitle }}</span>
                    <h3 class="mt-2 font-semibold text-navy text-sm">{{ $post->title }}</h3>
                    <p class="mt-2 text-sm text-slate-ink">{{ $post->body }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Final CTA --}}
<section class="py-20 bg-gradient-to-br from-brand-red-deep to-navy text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <h2 class="text-3xl sm:text-4xl font-serif">{{ $t('final_cta_title') }}</h2>
        <p class="mt-4 text-mist">{{ $t('final_cta_intro') }}</p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ $t('final_cta_primary_href', '/contact') }}" class="inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-navy hover:bg-ice transition">{{ $t('final_cta_primary_label') }}</a>
            <a href="{{ $t('final_cta_secondary_href', '/jobs') }}" class="inline-flex items-center rounded-full border border-white/40 px-6 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">{{ $t('final_cta_secondary_label') }}</a>
        </div>
    </div>
</section>

@endsection
