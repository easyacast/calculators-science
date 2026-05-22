@extends('layouts.app')
@section('title', 'Terms of Service')
@section('canonical', config('site.url') . '/terms-of-service')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Terms of Service</h1>
    <p class="text-sm text-gray-500 mb-6">Last updated: {{ date('F j, Y') }}</p>
    <div class="prose prose-gray max-w-none text-gray-600 space-y-4">
        <p>By using {{ config('site.name') }} ({{ config('site.url') }}), you agree to these Terms of Service.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-6">Use of Service</h2>
        <p>Our calculators and tools are provided for educational and informational purposes. While we strive for accuracy, we cannot guarantee that all calculations are error-free. Always verify critical calculations independently.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-6">Disclaimer</h2>
        <p>The tools and information on this website are provided "as is" without warranty of any kind. We are not responsible for any decisions made based on the calculations provided.</p>
        <h2 class="text-xl font-bold text-gray-900 mt-6">Contact</h2>
        <p>For questions about these terms, contact us at <a href="mailto:{{ config('site.contact.email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.email') }}</a>.</p>
    </div>
</div>
@endsection
