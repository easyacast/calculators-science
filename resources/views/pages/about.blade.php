@extends('layouts.app')
@section('title', 'About Us')
@section('meta_description', 'Learn about ' . config('site.name') . ' — a trusted platform for free scientific calculators, math solvers, and educational tools used by millions of students and professionals.')
@section('canonical', config('site.url') . '/about')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "About {{ config('site.name') }}",
    "url": "{{ config('site.url') }}/about",
    "description": "Learn about {{ config('site.name') }} — a trusted platform for free scientific calculators and educational tools."
}
</script>
@endsection

@section('content')
@php
    $aboutAllTools = \App\Helpers\ToolRegistry::all();
    $aboutTotalTools = 0;
    $aboutCategoryCount = 0;
    foreach (config('site.categories') as $slug => $cat) {
        $tc = count(($aboutAllTools[$slug] ?? [])['tools'] ?? []);
        if ($tc > 0) { $aboutTotalTools += $tc; $aboutCategoryCount++; }
    }
@endphp

{{-- Hero Section --}}
<section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold tracking-tight mb-4">About {{ config('site.name') }}</h1>
        <p class="text-lg text-indigo-100 max-w-2xl mx-auto leading-relaxed">
            We're on a mission to make scientific calculations accessible, understandable, and free for everyone — from high school students to research professionals.
        </p>
    </div>
</section>

{{-- Our Story --}}
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Story</h2>
            <p class="text-gray-600 leading-relaxed mb-4">
                {{ config('site.name') }} was born from a simple frustration: finding reliable, free online calculators that actually explain the math behind the answer. Too many tools just give you a number without helping you understand the process.
            </p>
            <p class="text-gray-600 leading-relaxed mb-4">
                We set out to build something different — a platform where every calculation comes with step-by-step explanations, real formulas rendered beautifully, interactive graphs you can explore, and educational content that helps you learn, not just solve.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Today, {{ config('site.name') }} covers Mathematics, Physics, Chemistry, Biology, Finance, Engineering, Health, and Unit Conversion — with new tools added regularly based on community feedback.
            </p>
        </div>
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8 border border-indigo-100">
            <div class="grid grid-cols-2 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-indigo-600">{{ number_format($aboutTotalTools) }}+</div>
                    <div class="text-sm text-gray-600 mt-1">Calculators & Tools</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-indigo-600">{{ $aboutCategoryCount }}</div>
                    <div class="text-sm text-gray-600 mt-1">Scientific Categories</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-indigo-600">100%</div>
                    <div class="text-sm text-gray-600 mt-1">Free Forever</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-indigo-600">AI</div>
                    <div class="text-sm text-gray-600 mt-1">Powered Solver</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Our Mission & Values --}}
<section class="bg-white py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">What We Stand For</h2>
            <p class="mt-3 text-gray-600 max-w-xl mx-auto">Our core values guide every tool we build and every feature we design.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Education First</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    We don't just give you the answer — we show you how to get there. Every tool includes step-by-step breakdowns, formula explanations, and real-world examples so you actually learn the concept.
                </p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Accuracy & Trust</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Scientific calculations demand precision. Our tools are built on verified mathematical formulas, rigorously tested, and continuously reviewed. When it matters, you can trust our results.
                </p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Free & Accessible</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Quality education tools shouldn't be behind a paywall. {{ config('site.name') }} is completely free — no sign-ups, no subscriptions, no limits. Access any calculator from any device, anywhere.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- What We Offer --}}
<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">What We Offer</h2>
    <div class="grid sm:grid-cols-2 gap-6">
        @foreach(config('site.categories') as $slug => $cat)
        <a href="{{ config('site.url') }}/{{ $slug }}" class="group flex items-start gap-4 p-5 bg-white rounded-xl border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all">
            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-100 transition-colors">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $cat['name'] }}</h3>
                <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $cat['description'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</section>

{{-- Contact CTA --}}
<section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
        <h2 class="text-2xl font-bold mb-3">Have a Suggestion or Found a Bug?</h2>
        <p class="text-indigo-100 mb-6">We're always improving. Your feedback helps us build better tools for everyone.</p>
        <a href="mailto:{{ config('site.contact.email') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-indigo-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            {{ config('site.contact.email') }}
        </a>
    </div>
</section>

@include('components.static-page-links', ['currentPage' => 'about'])

@endsection
