@extends('layouts.app')

@section('title', 'Free Online Scientific Calculators & Tools')
@section('meta_description', config('site.seo.default_description'))
@section('canonical', config('site.url'))

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "{{ config('site.name') }} - Free Online Scientific Calculators",
    "description": "{{ config('site.description') }}",
    "url": "{{ config('site.url') }}"
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "MathSolver",
    "name": "{{ config('site.name') }} - AI Math Solver",
    "url": "{{ config('site.url') }}",
    "usageInfo": "{{ config('site.url') }}/terms-of-service",
    "description": "Solve any math problem with AI-powered step-by-step solutions, interactive graphs, and tutoring.",
    "potentialAction": [{
        "@type": "SolveMathAction",
        "target": "{{ config('site.url') }}/math/ai-math-solver?q={math_expression_string}",
        "mathExpression-input": "required name=math_expression_string",
        "eduQuestionType": ["Algebra", "Arithmetic", "Calculus", "Geometry", "Statistics", "Trigonometry"]
    }]
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {"@type": "Question", "name": "Is {{ config('site.name') }} really free?", "acceptedAnswer": {"@type": "Answer", "text": "Yes, 100% free. All calculators, converters, and the AI Math Solver are available at no cost with no sign-up required."}},
        {"@type": "Question", "name": "How accurate are the calculations?", "acceptedAnswer": {"@type": "Answer", "text": "Our calculators use verified mathematical formulas and are rigorously tested for educational purposes."}},
        {"@type": "Question", "name": "How does the AI Math Solver work?", "acceptedAnswer": {"@type": "Answer", "text": "Type any math problem in plain English or mathematical notation. Our AI analyzes the problem, solves it step by step, and provides an AI tutor for follow-up questions."}},
        {"@type": "Question", "name": "Do you store my calculations?", "acceptedAnswer": {"@type": "Answer", "text": "No. Standard calculator inputs are processed in your browser. AI Math Solver queries are processed but not permanently stored."}}
    ]
}
</script>
@endsection

@section('content')

{{-- Hero Section --}}
<section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl lg:text-5xl font-bold tracking-tight">
                Free Online Scientific Calculators & Tools
            </h1>
            <p class="mt-4 text-lg text-indigo-100 leading-relaxed">
                Solve math, physics, chemistry, biology, finance, and engineering problems with step-by-step explanations, interactive graphs, and AI-powered tutoring. Built for students, teachers, and professionals.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ config('site.url') }}/math/ai-math-solver"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-indigo-50 transition-colors shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Try AI Math Solver
                </a>
                <a href="#categories"
                   class="inline-flex items-center gap-2 px-6 py-3 border-2 border-white/30 text-white font-semibold rounded-xl hover:bg-white/10 transition-colors">
                    Browse All Tools
                </a>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto">
            <div class="text-center">
                <div class="text-2xl font-bold">50+</div>
                <div class="text-sm text-indigo-200">Calculators</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">8</div>
                <div class="text-sm text-indigo-200">Categories</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">100%</div>
                <div class="text-sm text-indigo-200">Free</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold">AI</div>
                <div class="text-sm text-indigo-200">Powered</div>
            </div>
        </div>
    </div>
</section>

{{-- AI Math Solver - Embedded on Homepage --}}
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10 mb-8">
    <div x-data="homeSolver()" class="bg-white rounded-2xl border border-gray-200 shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <h2 class="text-white font-bold text-lg">AI Math Solver</h2>
                    <p class="text-indigo-200 text-xs">Type any math problem and get step-by-step solutions instantly</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="flex gap-2 mb-3">
                <textarea
                    x-model="problem"
                    @keydown.ctrl.enter="solve()"
                    placeholder="Type your math problem... (e.g., Solve 2x^2 + 5x - 3 = 0)"
                    class="flex-1 h-20 p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                ></textarea>
            </div>

            {{-- Quick examples --}}
            <div class="flex flex-wrap gap-1.5 mb-4">
                <template x-for="ex in examples" :key="ex">
                    <button @click="problem = ex; solve()" class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs hover:bg-indigo-100 transition-colors" x-text="ex"></button>
                </template>
            </div>

            <div class="flex items-center gap-3">
                <button @click="solve()" :disabled="loading || !problem.trim()" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm">
                    <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    <span x-text="loading ? 'Solving...' : 'Solve'"></span>
                </button>
                <a href="{{ config('site.url') }}/math/ai-math-solver" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    Open full solver with graphs & tutor &rarr;
                </a>
            </div>

            {{-- Solution Display --}}
            <div x-show="solution" x-cloak class="mt-5 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-5 border border-indigo-100">
                <div class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-2">Solution</div>
                <div class="space-y-3">
                    <template x-for="(step, i) in steps" :key="i">
                        <div class="flex items-start gap-3">
                            <div class="w-6 h-6 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5" x-text="i + 1"></div>
                            <div>
                                <div class="font-medium text-gray-900 text-sm" x-text="step.title"></div>
                                <div class="text-gray-600 text-sm" x-text="step.text"></div>
                            </div>
                        </div>
                    </template>
                </div>
                <div x-show="answer" class="mt-4 pt-3 border-t border-indigo-200">
                    <span class="text-sm font-bold text-gray-900">Answer: </span>
                    <span class="text-sm text-indigo-700 font-semibold" x-text="answer"></span>
                </div>
            </div>

            {{-- Error Display --}}
            <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100">
                <p class="text-sm text-red-700" x-text="error"></p>
            </div>
        </div>
    </div>
</section>

{{-- Categories Grid --}}
<section id="categories" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Explore by Category</h2>
        <p class="mt-3 text-gray-600 max-w-xl mx-auto">Choose a category to find the right calculator or tool for your needs. Each tool includes detailed formulas, step-by-step examples, and visual explanations.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
        $iconMap = [
            'calculator' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>',
            'atom' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12m-1 0a1 1 0 102 0 1 1 0 10-2 0m-6.5-3c3 0 5.5 1.5 7.5 3s4.5 3 7.5 3M5 15c3 0 5.5-1.5 7.5-3s4.5-3 7.5-3"/>',
            'flask-conical' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3h6m-5 0v5.172a2 2 0 01-.586 1.414L5 14l1.5 2L9 21h6l2.5-5L19 14l-4.414-4.414A2 2 0 0114 8.172V3"/>',
            'dna' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 15s2-2 5-2 5 4 8 4 5-2 5-2M2 9s2 2 5 2 5-4 8-4 5 2 5 2"/>',
            'trending-up' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 7l-8.5 8.5-5-5L2 17"/>',
            'wrench' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/>',
            'arrow-left-right' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 3l-5 5 5 5m8-10l5 5-5 5M3 8h18"/>',
            'heart-pulse' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 12.572l-7.5 7.428-7.5-7.428A5 5 0 1112 6.006a5 5 0 017.5 6.572z"/>',
        ];
        $colorMap = [
            'indigo' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'hover' => 'hover:border-indigo-300', 'hoverBg' => 'group-hover:bg-indigo-100'],
            'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'hover' => 'hover:border-amber-300', 'hoverBg' => 'group-hover:bg-amber-100'],
            'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'hover' => 'hover:border-emerald-300', 'hoverBg' => 'group-hover:bg-emerald-100'],
            'rose' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'hover' => 'hover:border-rose-300', 'hoverBg' => 'group-hover:bg-rose-100'],
            'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'hover' => 'hover:border-green-300', 'hoverBg' => 'group-hover:bg-green-100'],
            'sky' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'hover' => 'hover:border-sky-300', 'hoverBg' => 'group-hover:bg-sky-100'],
            'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'hover' => 'hover:border-purple-300', 'hoverBg' => 'group-hover:bg-purple-100'],
            'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'hover' => 'hover:border-red-300', 'hoverBg' => 'group-hover:bg-red-100'],
        ];
        @endphp

        @foreach($categories as $slug => $cat)
        @php $colors = $colorMap[$cat['color']] ?? $colorMap['indigo']; @endphp
        <a href="{{ config('site.url') }}/{{ $slug }}" class="group block bg-white rounded-xl border border-gray-200 {{ $colors['hover'] }} hover:shadow-lg transition-all duration-200 p-6">
            <div class="p-3 rounded-lg {{ $colors['bg'] }} {{ $colors['hoverBg'] }} transition-colors w-fit mb-4">
                <svg class="w-6 h-6 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $iconMap[$cat['icon']] ?? $iconMap['calculator'] !!}</svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 group-hover:{{ $colors['text'] }} transition-colors">{{ $cat['name'] }}</h3>
            <p class="text-sm text-gray-500 mt-1.5 leading-relaxed">{{ $cat['description'] }}</p>
        </a>
        @endforeach
    </div>
</section>

@include('components.adsense', ['slot' => 'homepage-mid'])

{{-- Featured / Popular Tools --}}
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Popular Calculators & Tools</h2>
            <p class="mt-3 text-gray-600 max-w-xl mx-auto">Our most used tools with step-by-step solutions, interactive graphs, and detailed explanations.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($featuredTools as $tool)
            @include('components.tool-card', [
                'title' => $tool['title'],
                'description' => $tool['description'],
                'url' => $tool['url'],
                'category' => $tool['category'],
                'color' => $tool['color'],
                'featured' => $tool['featured'] ?? false,
            ])
            @endforeach
        </div>
    </div>
</section>

{{-- Why Choose Us Section --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Why Students and Professionals Trust Us</h2>
        <p class="mt-3 text-gray-600 max-w-xl mx-auto">Built by educators, engineers, and math enthusiasts who understand what learners actually need.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Step-by-Step Solutions</h3>
            <p class="text-gray-600 text-sm leading-relaxed">We don't just give you an answer — we show you exactly how to get there. Every calculator breaks down the problem into clear, numbered steps so you understand the process and can solve similar problems on your own.</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Interactive Graphs & Visuals</h3>
            <p class="text-gray-600 text-sm leading-relaxed">See your equations come alive with dynamic, interactive graphs. Visualizing mathematical relationships makes abstract concepts concrete — and our tools let you zoom, trace, and explore.</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Real Formulas & Examples</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Every tool displays the exact formula used, explains each variable, and includes practical real-world examples. Beautiful KaTeX rendering makes mathematical notation crisp and professional.</p>
        </div>
    </div>
</section>

@include('components.adsense', ['slot' => 'homepage-mid-2'])

{{-- Trust Badges --}}
<section class="bg-gray-50 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex items-center gap-3 justify-center">
                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">Verified Formulas</div>
                    <div class="text-xs text-gray-500">Peer-reviewed accuracy</div>
                </div>
            </div>
            <div class="flex items-center gap-3 justify-center">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">HTTPS Secured</div>
                    <div class="text-xs text-gray-500">SSL encrypted</div>
                </div>
            </div>
            <div class="flex items-center gap-3 justify-center">
                <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">No Sign-up</div>
                    <div class="text-xs text-gray-500">Use instantly, free</div>
                </div>
            </div>
            <div class="flex items-center gap-3 justify-center">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">Mobile Friendly</div>
                    <div class="text-xs text-gray-500">Works on all devices</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- User Testimonials --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">What Our Users Say</h2>
        <p class="mt-3 text-gray-600 max-w-xl mx-auto">Trusted by students, teachers, and professionals around the world.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Testimonial 1 --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-1 mb-3">
                @for($i = 0; $i < 5; $i++)
                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">"The step-by-step solutions saved me during finals. I was struggling with quadratic equations and this site broke it down so clearly that I finally understood the discriminant method. Highly recommend for any math student."</p>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm">S</div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">Sarah M.</div>
                    <div class="text-xs text-gray-500">University Student, Mathematics</div>
                </div>
            </div>
        </div>

        {{-- Testimonial 2 --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-1 mb-3">
                @for($i = 0; $i < 5; $i++)
                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">"I use the physics calculators almost daily for my AP Physics class. The Newton's force calculator is incredibly intuitive, and I love that it shows the formula with proper notation. It's like having a tutor available 24/7."</p>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold text-sm">J</div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">James T.</div>
                    <div class="text-xs text-gray-500">High School Student, AP Physics</div>
                </div>
            </div>
        </div>

        {{-- Testimonial 3 --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-1 mb-3">
                @for($i = 0; $i < 5; $i++)
                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">"As a financial advisor, I recommend the compound interest calculator to all my clients. It gives them a clear, visual understanding of how their investments grow over time. The year-by-year breakdown is especially helpful."</p>
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center font-bold text-sm">R</div>
                <div>
                    <div class="font-semibold text-gray-900 text-sm">Rachel K.</div>
                    <div class="text-xs text-gray-500">Certified Financial Planner</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 text-white py-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">How It Works</h2>
            <p class="mt-3 text-indigo-200 max-w-xl mx-auto">Get accurate results in seconds — no sign-up, no downloads, no hassle.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
                    <span class="text-2xl font-bold">1</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Choose a Tool</h3>
                <p class="text-indigo-200 text-sm leading-relaxed">Browse our 8 categories or search for the specific calculator you need. From algebra to thermodynamics, we've got you covered.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
                    <span class="text-2xl font-bold">2</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Enter Your Values</h3>
                <p class="text-indigo-200 text-sm leading-relaxed">Type your numbers, equations, or variables. Our intuitive interfaces make it easy to input even complex expressions.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
                    <span class="text-2xl font-bold">3</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Get Your Solution</h3>
                <p class="text-indigo-200 text-sm leading-relaxed">Receive instant results with step-by-step explanations, formulas, graphs, and educational context. Learn while you solve.</p>
            </div>
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900">Frequently Asked Questions</h2>
    </div>
    <div class="space-y-4" x-data="{ open: null }">
        @php
        $faqs = [
            ['q' => 'Is ' . config('site.name') . ' really free?', 'a' => 'Yes, 100% free. All of our calculators, converters, and the AI Math Solver are available at no cost, with no sign-up required. We sustain our platform through non-intrusive advertising.'],
            ['q' => 'How accurate are the calculations?', 'a' => 'Our calculators use verified mathematical formulas and are rigorously tested. However, they are designed for educational purposes. For critical professional, medical, or financial decisions, we always recommend verifying results independently.'],
            ['q' => 'Can I use it on my phone?', 'a' => 'Absolutely. ' . config('site.name') . ' is fully responsive and works on any device — smartphones, tablets, laptops, and desktops. All calculators are touch-friendly and optimized for smaller screens.'],
            ['q' => 'How does the AI Math Solver work?', 'a' => 'Type any math problem in plain English or mathematical notation. Our AI analyzes the problem, solves it step by step, generates interactive graphs when applicable, and provides an AI tutor for follow-up questions.'],
            ['q' => 'Do you store my calculations?', 'a' => 'No. Standard calculator inputs are processed entirely in your browser and never sent to our servers. AI Math Solver queries are sent to our AI provider for processing but are not permanently stored.'],
        ];
        @endphp
        @foreach($faqs as $i => $faq)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <button @click="open = open === {{ $i }} ? null : {{ $i }}" class="w-full flex items-center justify-between px-6 py-4 text-left">
                <span class="font-semibold text-gray-900 text-sm pr-4">{{ $faq['q'] }}</span>
                <svg :class="open === {{ $i }} ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 flex-shrink-0 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open === {{ $i }}" x-cloak x-collapse class="px-6 pb-4">
                <p class="text-gray-600 text-sm leading-relaxed">{{ $faq['a'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Complete Tool Index — ensures every tool gets a dofollow link from homepage --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-gray-900">All Calculators & Tools</h2>
        <p class="mt-3 text-gray-600 max-w-xl mx-auto">Browse our complete collection — every tool is free, includes step-by-step solutions, and works on any device.</p>
    </div>

    @php $allToolsForIndex = \App\Helpers\ToolRegistry::all(); @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach(config('site.categories') as $catSlug => $cat)
        <div>
            <h3 class="font-bold text-gray-900 mb-3">
                <a href="{{ config('site.url') }}/{{ $catSlug }}" class="hover:text-indigo-600 transition-colors">{{ $cat['name'] }}</a>
            </h3>
            <ul class="space-y-1.5">
                @foreach($allToolsForIndex[$catSlug] ?? [] as $toolSlug => $tool)
                <li>
                    <a href="{{ config('site.url') }}/{{ $catSlug }}/{{ $toolSlug }}" class="text-sm text-gray-600 hover:text-indigo-600 transition-colors">
                        {{ $tool['title'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</section>

{{-- Final CTA --}}
<section class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-3">Ready to Solve Your Next Problem?</h2>
        <p class="text-gray-600 mb-6">Join thousands of students and professionals who use {{ config('site.name') }} every day.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ config('site.url') }}/math/ai-math-solver" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Try AI Math Solver
            </a>
            <a href="#categories" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-white transition-colors">
                Browse All Tools
            </a>
        </div>
    </div>
</section>

@include('components.adsense', ['slot' => 'homepage-bottom'])

@endsection

@section('scripts')
<script>
function homeSolver() {
    return {
        problem: '',
        loading: false,
        solution: false,
        steps: [],
        answer: '',
        error: '',
        examples: ['2x^2 + 5x - 3 = 0', 'derivative of x^3 + 2x', 'integrate sin(x)dx', '15% of 240'],

        async solve() {
            if (!this.problem.trim()) return;
            this.loading = true;
            this.solution = false;
            this.error = '';
            this.steps = [];
            this.answer = '';

            try {
                const res = await fetch('/api/solve', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ problem: this.problem, mode: 'step-by-step' }),
                });

                const data = await res.json();
                if (data.steps && data.steps.length) {
                    this.steps = data.steps;
                    this.answer = data.answer || '';
                    this.solution = true;
                } else if (data.solution) {
                    this.steps = [{ title: 'Solution', text: data.solution }];
                    this.answer = data.answer || '';
                    this.solution = true;
                } else {
                    this.error = data.error || 'Could not solve. Try the full AI Math Solver for more complex problems.';
                }
            } catch (e) {
                this.error = 'Network error. Please try again.';
            }

            this.loading = false;
        },
    };
}
</script>
@endsection
