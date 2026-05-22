@extends('layouts.app')
@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with the ' . config('site.name') . ' team. Report issues, suggest new tools, or ask questions.')
@section('canonical', config('site.url') . '/contact')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Contact Us</h1>
    <p class="text-gray-600 mb-8">We would love to hear from you. Whether you have a suggestion for a new tool, found a bug, or just want to say hello, please reach out.</p>
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="space-y-4">
            <div class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg><a href="mailto:{{ config('site.contact.email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.email') }}</a></div>
            <div class="flex items-center gap-3"><svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg><a href="mailto:{{ config('site.contact.support_email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.support_email') }}</a></div>
        </div>
    </div>
</div>
@endsection
