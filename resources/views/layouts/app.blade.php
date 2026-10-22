<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteCompany['name'].' — Healthcare Staffing & Workforce Solutions')</title>
    <meta name="description" content="@yield('meta_description', $siteCompany['tagline'])">
    @if(($siteCompany['favicon'] ?? $siteCompany['logo']) ?? false)
        <link rel="icon" href="{{ \Illuminate\Support\Facades\Storage::url($siteCompany['favicon'] ?? $siteCompany['logo']) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-navy antialiased">

    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 focus:bg-white focus:px-4 focus:py-2 focus:rounded-lg focus:shadow">Skip to content</a>

    <header x-data="{ open: false }" class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-line">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 py-3">
                <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0">
                    @if($siteCompany['logo'] ?? false)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($siteCompany['logo']) }}" alt="{{ $siteCompany['name'] }}" class="h-10 w-auto">
                    @else
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-brand-blue text-white font-bold">U</span>
                        <span class="text-lg font-bold text-navy">{{ $siteCompany['name'] }}</span>
                    @endif
                </a>

                <nav class="hidden lg:flex items-center gap-7">
                    @foreach($siteNav as $item)
                        <a href="{{ $item->extra_text ?: '#' }}" class="text-sm font-medium text-slate-ink hover:text-brand-blue-deep transition">{{ $item->title }}</a>
                    @endforeach
                </nav>

                <div class="hidden lg:flex items-center gap-4">
                    @auth
                        @if(auth()->user()->isCandidate())
                            <a href="{{ route('account.edit') }}" class="text-sm font-medium text-slate-ink hover:text-brand-red-deep">My Account</a>
                        @else
                            <a href="{{ url('/admin') }}" class="text-sm font-medium text-slate-ink hover:text-brand-red-deep">Admin Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button class="text-sm font-medium text-slate-ink hover:text-brand-red-deep">Sign out</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="text-sm font-medium text-slate-ink hover:text-brand-red-deep">Create Profile</a>
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-ink hover:text-brand-red-deep">Candidate Sign In</a>
                    @endauth
                    <a href="{{ $siteNavCtaHref }}" class="inline-flex items-center rounded-full bg-brand-red-deep px-5 py-2.5 text-sm font-semibold text-white hover:bg-navy transition">{{ $siteNavCtaLabel }}</a>
                </div>

                <button @click="open = !open" class="lg:hidden inline-flex items-center justify-center rounded-lg p-2 text-navy hover:bg-ice" aria-label="Toggle menu">
                    <svg x-show="open" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
            </div>

            <div x-show="open" x-cloak x-transition class="lg:hidden pb-5 space-y-1 border-t border-line pt-3">
                @foreach($siteNav as $item)
                    <a href="{{ $item->extra_text ?: '#' }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-ink hover:bg-ice">{{ $item->title }}</a>
                @endforeach
                <div class="pt-3 flex flex-col gap-2 px-3">
                    @auth
                        @if(auth()->user()->isCandidate())
                            <a href="{{ route('account.edit') }}" class="text-sm font-medium text-slate-ink">My Account</a>
                        @else
                            <a href="{{ url('/admin') }}" class="text-sm font-medium text-slate-ink">Admin Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button class="text-left text-sm font-medium text-slate-ink">Sign out</button>
                        </form>
                    @else
                        <a href="{{ route('register') }}" class="text-sm font-medium text-slate-ink">Create Profile</a>
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-ink">Candidate Sign In</a>
                    @endauth
                    <a href="{{ $siteNavCtaHref }}" class="inline-flex justify-center rounded-full bg-brand-red-deep px-5 py-2.5 text-sm font-semibold text-white">{{ $siteNavCtaLabel }}</a>
                </div>
            </div>
        </div>
    </header>

    @if(session('status'))
        <div class="bg-teal-wash border-b border-line text-teal-deep text-sm text-center py-2 px-4">{{ session('status') }}</div>
    @endif

    <main id="main">
        @yield('content')
    </main>

    <footer class="bg-surface border-t border-line mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-2 md:grid-cols-6 gap-10">
                <div class="col-span-2">
                    <div class="flex items-center gap-2 mb-3">
                        @if($siteCompany['logo'] ?? false)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($siteCompany['logo']) }}" alt="{{ $siteCompany['name'] }}" class="h-9 w-auto">
                        @else
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-blue text-white font-bold text-sm">U</span>
                            <span class="font-bold text-navy">{{ $siteCompany['name'] }}</span>
                        @endif
                    </div>
                    <p class="text-sm text-slate-ink max-w-xs">{{ $siteCompany['tagline'] }}</p>
                    <div class="mt-4 space-y-1 text-sm text-slate-ink">
                        <a href="{{ $siteCompany['phone_href'] }}" class="block hover:text-brand-blue-deep">{{ $siteCompany['phone'] }}</a>
                        <a href="mailto:{{ $siteCompany['email'] }}" class="block hover:text-brand-blue-deep">{{ $siteCompany['email'] }}</a>
                        <span class="block">{{ $siteCompany['hq'] }}</span>
                    </div>
                </div>
                @foreach($siteFooterColumns as $col)
                    <div>
                        <h4 class="text-sm font-semibold text-navy mb-3">{{ $col->title }}</h4>
                        <ul class="space-y-2">
                            @foreach(($col->points ?? []) as $link)
                                @php($parts = explode('|', $link, 2))
                                <li><a href="{{ $parts[1] ?? '#' }}" class="text-sm text-slate-ink hover:text-brand-blue-deep">{{ $parts[0] ?? $link }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="mt-12 pt-6 border-t border-line flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-ink">
                <span>&copy; {{ date('Y') }} {{ $siteCompany['legal'] }}. {{ $siteFooterNote }}</span>
                <div class="flex items-center gap-4">
                    @if($siteCompany['social_linkedin'] ?? false)<a href="{{ $siteCompany['social_linkedin'] }}" class="hover:text-brand-blue-deep">LinkedIn</a>@endif
                    @if($siteCompany['social_facebook'] ?? false)<a href="{{ $siteCompany['social_facebook'] }}" class="hover:text-brand-blue-deep">Facebook</a>@endif
                    @if($siteCompany['social_twitter'] ?? false)<a href="{{ $siteCompany['social_twitter'] }}" class="hover:text-brand-blue-deep">X</a>@endif
                    @if($siteCompany['social_instagram'] ?? false)<a href="{{ $siteCompany['social_instagram'] }}" class="hover:text-brand-blue-deep">Instagram</a>@endif
                </div>
            </div>
        </div>
    </footer>

    @if($siteChatEnabled)
        @include('partials.chat-widget')
    @endif
</body>
</html>
