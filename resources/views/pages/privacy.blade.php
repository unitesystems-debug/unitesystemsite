@extends('layouts.app')

@section('title', 'Privacy Policy')
@section('meta_description', 'How Unite Systems collects, uses and protects your information.')

@section('content')

<section class="bg-blue-wash py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-navy">Privacy Policy</h1>
        <p class="mt-3 text-sm text-slate-ink">Effective date: {{ $t('effective_date', '—') }}</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose-content text-slate-ink">{!! $t('body') !!}</div>

        <div class="mt-10 rounded-2xl bg-surface border border-line p-6">
            <h3 class="font-semibold text-navy mb-1">Questions about this policy?</h3>
            <p class="text-sm text-slate-ink">Contact us at <a href="mailto:{{ $siteCompany['email'] }}" class="text-brand-blue-deep font-medium">{{ $siteCompany['email'] }}</a> or {{ $siteCompany['phone'] }}.</p>
        </div>
    </div>
</section>

@endsection
