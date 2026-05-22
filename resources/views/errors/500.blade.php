@extends('layouts.app')
@section('title', 'Server Error')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <div class="mb-8">
            <span class="text-8xl font-bold bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">500</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Something Went Wrong</h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
            Our servers encountered an unexpected error. We're aware of the issue and working to fix it. Please try again in a few moments.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ config('site.url') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Go Home
            </a>
            <button onclick="location.reload()" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Try Again
            </button>
        </div>
        <p class="mt-8 text-sm text-gray-500">If this issue persists, please contact us at <a href="mailto:{{ config('site.contact.support_email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.support_email') }}</a></p>
    </div>
</div>
@endsection
