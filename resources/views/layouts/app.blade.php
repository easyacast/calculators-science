<!DOCTYPE html>
<html lang="{{ config('site.language', 'en') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Primary SEO Meta Tags --}}
    <title>@yield('title', config('site.seo.default_title')) {{ config('site.seo.title_separator') }} {{ config('site.name') }}</title>
    <meta name="description" content="@yield('meta_description', config('site.seo.default_description'))">
    <meta name="keywords" content="@yield('meta_keywords', config('site.seo.default_keywords'))">
    <meta name="author" content="{{ config('site.seo.author') }}">
    <meta name="robots" content="@yield('robots', config('site.seo.robots_default'))">
    <link rel="canonical" href="@yield('canonical', config('site.url'))">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="@yield('og_type', config('site.seo.og_type'))">
    <meta property="og:url" content="@yield('canonical', config('site.url'))">
    <meta property="og:title" content="@yield('title', config('site.seo.default_title'))">
    <meta property="og:description" content="@yield('meta_description', config('site.seo.default_description'))">
    <meta property="og:image" content="{{ config('site.url') }}@yield('og_image', config('site.seo.og_image'))">
    <meta property="og:locale" content="{{ config('site.locale') }}">
    <meta property="og:site_name" content="{{ config('site.name') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ config('site.seo.twitter_card') }}">
    @if(config('site.seo.twitter_handle'))
    <meta name="twitter:site" content="{{ config('site.seo.twitter_handle') }}">
    @endif
    <meta name="twitter:title" content="@yield('title', config('site.seo.default_title'))">
    <meta name="twitter:description" content="@yield('meta_description', config('site.seo.default_description'))">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- LLMs.txt Discovery --}}
    <link rel="help" href="{{ config('site.url') }}/llms.txt" type="text/plain" title="LLMs.txt">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ config('site.favicon') }}">

    {{-- Google Tag Manager --}}
    @if(config('site.analytics.gtm_id'))
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ config('site.analytics.gtm_id') }}');</script>
    @endif

    {{-- Google AdSense Auto Ads --}}
    @if(config('site.ads.show_ads') && config('site.ads.adsense_client_id'))
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ config('site.ads.adsense_client_id') }}" crossorigin="anonymous"></script>
    @endif

    {{-- KaTeX for Math Rendering --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/katex.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.11/dist/contrib/auto-render.min.js"
        onload="renderMathInElement(document.body, {delimiters: [{left: '$$', right: '$$', display: true},{left: '$', right: '$', display: false}]});"></script>

    {{-- Structured Data (JSON-LD) --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "{{ config('site.name') }}",
        "url": "{{ config('site.url') }}",
        "description": "{{ config('site.description') }}",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "{{ config('site.url') }}/search?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    @yield('schema')

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('head')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased" x-data="{ mobileMenuOpen: false, searchOpen: false }">

    {{-- Google Tag Manager (noscript) --}}
    @if(config('site.analytics.gtm_id'))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('site.analytics.gtm_id') }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    {{-- Skip Navigation Link (Accessibility) --}}
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:px-4 focus:py-2 focus:text-indigo-600">
        Skip to main content
    </a>

    @include('components.header')

    {{-- Main Content --}}
    <main id="main-content" class="min-h-[70vh]">
        @yield('content')
    </main>

    {{-- Floating Share Buttons (visible on tool/content pages) --}}
    @include('components.share-buttons')

    @include('components.footer')

    {{-- Back to Top Button --}}
    <button
        x-data="{ show: false }"
        x-on:scroll.window="show = window.scrollY > 300"
        x-show="show"
        x-transition
        x-cloak
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-40 p-3 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 transition-colors"
        aria-label="Back to top"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
    </button>

    @yield('scripts')
</body>
</html>
