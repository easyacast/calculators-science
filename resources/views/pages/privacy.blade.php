@extends('layouts.app')
@section('title', 'Privacy Policy')
@section('canonical', config('site.url') . '/privacy-policy')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Privacy Policy</h1>
    <p class="text-sm text-gray-500 mb-6">Last updated: {{ date('F j, Y') }}</p>
    <div class="prose prose-gray max-w-none text-gray-600 space-y-4">
        <p>{{ config('site.name') }} ("we", "us", or "our") operates the website at {{ config('site.url') }}. This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-6">Information We Collect</h2>
        <p>We do not require user registration. We may collect anonymous usage data through Google Analytics to understand how visitors interact with our tools. No personally identifiable information is stored on our servers.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-6">Cookies</h2>
        <p>We use cookies for analytics and advertising purposes (Google Analytics, Google AdSense). You can disable cookies in your browser settings.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-6">Third-Party Services</h2>
        <p>Our website may use third-party services such as Google Analytics, Google AdSense, and Groq AI API. These services have their own privacy policies.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-6">Contact</h2>
        <p>For privacy-related inquiries, contact us at <a href="mailto:{{ config('site.contact.email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.email') }}</a>.</p>
    </div>
</div>
@endsection
