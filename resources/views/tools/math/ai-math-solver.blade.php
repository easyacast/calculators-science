@extends('layouts.app')

@section('title', 'AI Math Solver - Step by Step Solutions with Graphs')
@section('meta_description', 'Solve any math problem instantly with our free AI Math Solver. Get step-by-step solutions, interactive graphs, and AI tutoring for algebra, calculus, trigonometry, and more.')
@section('canonical', config('site.url') . '/math/ai-math-solver')
@section('meta_keywords', 'ai math solver, math problem solver, step by step math, equation solver, algebra solver, calculus solver, math graph, math tutor')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "MathSolver",
    "name": "AI Math Solver",
    "url": "{{ config('site.url') }}/math/ai-math-solver",
    "usageInfo": "{{ config('site.url') }}/terms-of-service",
    "mathExpression": ["2x+3=7", "x^2-5x+6=0", "d/dx(x^3+2x)", "∫sin(x)dx"],
    "description": "AI-powered math solver with step-by-step solutions, interactive graphing, and tutoring.",
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
    "@type": "SoftwareApplication",
    "name": "AI Math Solver",
    "applicationCategory": "EducationalApplication",
    "operatingSystem": "Web",
    "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
    "description": "AI-powered math solver with step-by-step solutions, interactive graphing, and tutoring."
}
</script>
@endsection

@section('head')
@vite(['resources/css/ai-math-solver.css', 'resources/js/ai-math-solver-workspace.js'])
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/math" class="hover:text-indigo-600">Mathematics</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">AI Math Solver</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">AI Math Solver</h1>
    <p class="text-lg text-gray-600 mb-8">Type any math problem or upload an image. Get step-by-step solutions, interactive graphs, and AI tutoring instantly.</p>

    @include('components.ai-math-solver-workspace')

    {{-- Crawlable HTML for search engines (hidden visually when JS workspace is active) --}}
    @if(!empty($solution))
        <div class="sr-only" aria-hidden="true">
            @include('components.ai-math-solver-static-result', ['solution' => $solution, 'problem' => $solverQuery])
        </div>
    @endif

    <noscript>
        <form method="GET" action="{{ config('site.url') }}/math/ai-math-solver" class="mt-8 bg-white border border-gray-200 rounded-2xl p-5 shadow-sm">
            <label for="solver-q-noscript" class="block text-sm font-semibold text-gray-800 mb-2">Enter a math problem</label>
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" id="solver-q-noscript" name="q" value="{{ $solverQuery ?? '' }}" placeholder="e.g. Solve 2x^2 + 5x - 3 = 0" class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl text-sm">
                <input type="hidden" name="mode" value="{{ $solverMode ?? 'step-by-step' }}">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl text-sm">Get Solution</button>
            </div>
        </form>
        @if(!empty($solution))
            @include('components.ai-math-solver-static-result', ['solution' => $solution, 'problem' => $solverQuery])
        @endif
    </noscript>

    @include('components.adsense', ['slot' => 'tool-below'])

    <div class="mt-16 max-w-4xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">What is the AI Math Solver?</h2>
        <p class="text-gray-600 leading-relaxed mb-6">
            The AI Math Solver helps you solve mathematical problems of all kinds with clear, step-by-step solutions, interactive graphs, and an AI tutor for follow-up questions.
        </p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">How Does It Work?</h2>
        <ol class="list-decimal list-inside text-gray-600 space-y-2 mb-6">
            <li><strong>Enter your problem</strong> using the text editor, scientific keyboard, or photo upload.</li>
            <li><strong>Choose a solving mode</strong>: Step-by-Step, Conceptual, or Graph.</li>
            <li><strong>Click Solve</strong> for a complete solution with every step explained.</li>
            <li><strong>Open the AI Tutor tab</strong> to ask follow-up questions.</li>
        </ol>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
