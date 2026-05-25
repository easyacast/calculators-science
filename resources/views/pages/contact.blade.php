@extends('layouts.app')
@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with the ' . config('site.name') . ' team. Report issues, suggest new calculators, request features, or ask questions about our tools.')
@section('canonical', config('site.url') . '/contact')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact {{ config('site.name') }}",
    "url": "{{ config('site.url') }}/contact",
    "description": "Get in touch with the {{ config('site.name') }} team."
}
</script>
@endsection

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold tracking-tight mb-4">Contact Us</h1>
        <p class="text-lg text-indigo-100 max-w-2xl mx-auto leading-relaxed">
            Have a question, suggestion, or found a bug? We'd love to hear from you. Our team typically responds within 24 hours.
        </p>
    </div>
</section>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid md:grid-cols-2 gap-8">

        {{-- General Inquiries --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900 mb-2">General Inquiries</h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                For questions about our calculators, suggestions for new tools, partnership opportunities, or general feedback.
            </p>
            <a href="mailto:{{ config('site.contact.email') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                {{ config('site.contact.email') }}
            </a>
        </div>

        {{-- Technical Support --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900 mb-2">Technical Support</h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                Found a bug, incorrect calculation, or experiencing technical issues? Let us know so we can fix it promptly.
            </p>
            <a href="mailto:{{ config('site.contact.support_email') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-800 font-semibold text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                {{ config('site.contact.support_email') }}
            </a>
        </div>
    </div>

    {{-- What to Include --}}
    <div class="mt-12 bg-gray-50 rounded-2xl border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">How to Reach Us Effectively</h2>
        <div class="grid sm:grid-cols-3 gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold">1</div>
                    <h3 class="font-semibold text-gray-900 text-sm">Bug Reports</h3>
                </div>
                <p class="text-gray-600 text-xs leading-relaxed">Include which calculator you were using, the inputs you entered, the result you got, and what you expected. Screenshots help us fix issues faster.</p>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold">2</div>
                    <h3 class="font-semibold text-gray-900 text-sm">Tool Suggestions</h3>
                </div>
                <p class="text-gray-600 text-xs leading-relaxed">Tell us which calculator or converter you'd like to see, what subject area it belongs to, and how you'd use it. We prioritize based on community demand.</p>
            </div>
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-6 h-6 bg-indigo-600 text-white rounded-full flex items-center justify-center text-xs font-bold">3</div>
                    <h3 class="font-semibold text-gray-900 text-sm">General Feedback</h3>
                </div>
                <p class="text-gray-600 text-xs leading-relaxed">Let us know what's working well, what could be improved, or how {{ config('site.name') }} has helped you with your studies or work. We read every message.</p>
            </div>
        </div>
    </div>

    {{-- Social Links --}}
    @php
        $hasSocial = config('site.social.facebook') || config('site.social.twitter') || config('site.social.youtube') || config('site.social.instagram') || config('site.social.linkedin');
    @endphp
    @if($hasSocial)
    <div class="mt-12 text-center">
        <h2 class="text-xl font-bold text-gray-900 mb-3">Follow Us</h2>
        <p class="text-gray-600 text-sm mb-6">Stay updated with new tools, tips, and educational content.</p>
        <div class="flex items-center justify-center gap-4">
            @if(config('site.social.facebook'))
            <a href="{{ config('site.social.facebook') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-blue-600 hover:text-white transition-all" aria-label="Facebook">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            @endif
            @if(config('site.social.twitter'))
            <a href="{{ config('site.social.twitter') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-black hover:text-white transition-all" aria-label="Twitter">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            @endif
            @if(config('site.social.youtube'))
            <a href="{{ config('site.social.youtube') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-red-600 hover:text-white transition-all" aria-label="YouTube">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
            @endif
            @if(config('site.social.instagram'))
            <a href="{{ config('site.social.instagram') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-pink-600 hover:text-white transition-all" aria-label="Instagram">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
            </a>
            @endif
            @if(config('site.social.linkedin'))
            <a href="{{ config('site.social.linkedin') }}" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-blue-700 hover:text-white transition-all" aria-label="LinkedIn">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </a>
            @endif
        </div>
    </div>
    @endif
</div>

@include('components.static-page-links', ['currentPage' => 'contact'])

@endsection
