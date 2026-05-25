@extends('layouts.app')
@section('title', 'Page Not Found')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <div class="mb-8">
            <span class="text-8xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">404</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Page Not Found</h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
            The page you're looking for doesn't exist or has been moved. Don't worry — our calculators and tools are still here for you.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ config('site.url') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Go Home
            </a>
            <a href="{{ config('site.url') }}/math/ai-math-solver" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Try AI Math Solver
            </a>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-200">
            <p class="text-sm text-gray-500 mb-4">Popular tools you might be looking for:</p>
            <div class="flex flex-wrap justify-center gap-2">
                <a href="{{ config('site.url') }}/math/quadratic-equation-calculator" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm hover:bg-indigo-100 transition-colors">Quadratic Solver</a>
                <a href="{{ config('site.url') }}/math/percentage-calculator" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm hover:bg-indigo-100 transition-colors">Percentage Calculator</a>
                <a href="{{ config('site.url') }}/health/bmi-calculator" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm hover:bg-indigo-100 transition-colors">BMI Calculator</a>
                <a href="{{ config('site.url') }}/unit-converter/temperature-converter" class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg text-sm hover:bg-indigo-100 transition-colors">Temperature Converter</a>
            </div>
        </div>
    </div>
</div>
@endsection
