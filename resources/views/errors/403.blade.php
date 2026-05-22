@extends('layouts.app')
@section('title', 'Access Denied')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        <div class="mb-8">
            <span class="text-8xl font-bold bg-gradient-to-r from-rose-500 to-pink-500 bg-clip-text text-transparent">403</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">Access Denied</h1>
        <p class="text-gray-600 mb-8 leading-relaxed">
            You don't have permission to access this page. If you believe this is an error, please contact our support team.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ config('site.url') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Go Home
            </a>
            <a href="mailto:{{ config('site.contact.support_email') }}" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
