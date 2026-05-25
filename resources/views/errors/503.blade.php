@extends('layouts.app')
@section('title', 'Under Maintenance')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <div class="mb-8">
            <span class="text-8xl font-bold bg-gradient-to-r from-amber-500 to-yellow-500 bg-clip-text text-transparent">503</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">We'll Be Right Back</h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
            {{ config('site.name') }} is currently undergoing scheduled maintenance to bring you a better experience. We'll be back online shortly.
        </p>
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-8">
            <div class="flex items-center gap-3 justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-amber-800 font-medium text-sm">We're usually back within a few minutes. Refresh the page to check.</p>
            </div>
        </div>
        <button onclick="location.reload()" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Refresh Page
        </button>
    </div>
</div>
@endsection
