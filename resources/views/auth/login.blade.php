@extends('layouts.app')

@section('title', 'Sign in')

@section('content')
<section class="bg-blue-wash py-20">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-serif text-navy text-center mb-8">Candidate Sign In</h1>

        @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-wash text-brand-red-deep text-sm p-3">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        @php($inputClass = 'w-full rounded-lg border border-line-strong bg-white px-3.5 py-2.5 text-sm text-navy placeholder:text-slate-ink/60 focus:outline-none focus:ring-2 focus:ring-brand-red-deep/25 focus:border-brand-red-deep transition')

        <form method="POST" action="{{ route('login.store') }}" class="rounded-2xl bg-white border border-line p-6 space-y-4 shadow-sm">
            @csrf
            <input type="email" name="email" placeholder="Email address" required value="{{ old('email') }}" class="{{ $inputClass }}">
            <input type="password" name="password" placeholder="Password" required class="{{ $inputClass }}">
            <label class="flex items-center gap-2.5 text-sm text-slate-ink">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-line-strong text-brand-red-deep focus:ring-brand-red-deep">
                <span>Remember me</span>
            </label>
            <button class="w-full rounded-full bg-brand-red-deep px-6 py-3 text-sm font-semibold text-white hover:bg-navy transition shadow-sm">Sign in</button>
        </form>
        <p class="text-center text-sm text-slate-ink mt-5">New here? <a href="{{ route('register') }}" class="text-brand-red-deep font-medium hover:underline">Create a candidate profile</a></p>
    </div>
</section>
@endsection
