@extends('layouts.app')
@section('title', 'Privacy Policy')
@section('meta_description', config('site.name') . ' Privacy Policy — how we collect, use, and protect your data when you use our free scientific calculators and tools.')
@section('canonical', config('site.url') . '/privacy-policy')
@section('robots', 'noindex, follow')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Privacy Policy</h1>
    <p class="text-sm text-gray-500 mb-8">Last updated: {{ date('F j, Y') }}</p>

    <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">

        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 mb-8">
            <p class="text-sm text-indigo-800 font-medium">Your privacy matters to us. {{ config('site.name') }} is designed to be used without creating an account. We collect minimal data and never sell your personal information.</p>
        </div>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">1. Who We Are</h2>
        <p>{{ config('site.name') }} operates the website at <strong>{{ config('site.url') }}</strong>. In this policy, "we," "us," and "our" refer to {{ config('site.name') }}. "You" refers to you, the visitor or user of our website.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">2. Information We Collect</h2>
        <p>We are committed to collecting only the minimum data necessary to provide and improve our services.</p>

        <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-2">Information You Provide</h3>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li><strong>Calculator Inputs:</strong> Numbers and equations you enter into our calculators are processed entirely in your browser. They are not stored on our servers.</li>
            <li><strong>AI Math Solver Queries:</strong> When you use the AI Math Solver, your math problem is sent to our server and forwarded to a third-party AI provider (Groq) for processing. We do not permanently store your queries.</li>
            <li><strong>Contact Emails:</strong> If you contact us via email, we retain your message and email address to respond to your inquiry.</li>
        </ul>

        <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-2">Information Collected Automatically</h3>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li><strong>Analytics Data:</strong> We may use Google Analytics to collect anonymous usage data such as pages visited, time on site, browser type, and device type. This data does not personally identify you.</li>
            <li><strong>Cookies:</strong> We use essential cookies for site functionality and may use analytics and advertising cookies from third-party services.</li>
            <li><strong>Log Files:</strong> Our web server automatically logs IP addresses, browser types, referring URLs, and pages accessed. These logs are used for security monitoring and are automatically deleted after 30 days.</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">3. How We Use Your Information</h2>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li>To provide and maintain our calculator tools and services</li>
            <li>To improve our website based on usage patterns and feedback</li>
            <li>To respond to your inquiries when you contact us</li>
            <li>To detect, prevent, and address technical issues and abuse</li>
            <li>To display relevant advertisements (if enabled)</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">4. Third-Party Services</h2>
        <p class="mb-4">We may use the following third-party services, each governed by their own privacy policies:</p>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li><strong>Google Analytics:</strong> Website traffic analysis — <a href="https://policies.google.com/privacy" class="text-indigo-600 hover:underline" target="_blank" rel="noopener">Google Privacy Policy</a></li>
            <li><strong>Google AdSense:</strong> Advertising display (when enabled) — <a href="https://policies.google.com/technologies/ads" class="text-indigo-600 hover:underline" target="_blank" rel="noopener">Google Ads Policy</a></li>
            <li><strong>Groq API:</strong> AI Math Solver processing — <a href="https://groq.com/privacy-policy/" class="text-indigo-600 hover:underline" target="_blank" rel="noopener">Groq Privacy Policy</a></li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">5. Cookies</h2>
        <p class="mb-4">Cookies are small data files stored on your device. We use:</p>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li><strong>Essential Cookies:</strong> Required for basic site functionality (e.g., CSRF protection). These cannot be disabled.</li>
            <li><strong>Analytics Cookies:</strong> Help us understand how visitors use our site. You can opt out via your browser settings or Google's <a href="https://tools.google.com/dlpage/gaoptout" class="text-indigo-600 hover:underline" target="_blank" rel="noopener">opt-out tool</a>.</li>
            <li><strong>Advertising Cookies:</strong> Used by Google AdSense to display relevant ads (when enabled). You can manage ad preferences at <a href="https://adssettings.google.com/" class="text-indigo-600 hover:underline" target="_blank" rel="noopener">Google Ad Settings</a>.</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">6. Data Security</h2>
        <p>We implement industry-standard security measures to protect your information, including HTTPS encryption, CSRF protection, and regular security updates. However, no method of transmission over the Internet is 100% secure, and we cannot guarantee absolute security.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">7. Children's Privacy</h2>
        <p>Our services are designed for general audiences, including students. We do not knowingly collect personal information from children under 13. Our calculators can be used without providing any personal information.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">8. Your Rights</h2>
        <p class="mb-4">Depending on your location, you may have the right to:</p>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li>Access the personal data we hold about you</li>
            <li>Request correction or deletion of your data</li>
            <li>Object to or restrict processing of your data</li>
            <li>Withdraw consent for optional data collection (e.g., analytics cookies)</li>
        </ul>
        <p>To exercise any of these rights, contact us at <a href="mailto:{{ config('site.contact.email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.email') }}</a>.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">9. Changes to This Policy</h2>
        <p>We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated "Last updated" date. We encourage you to review this page periodically.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">10. Contact Us</h2>
        <p>If you have any questions or concerns about this Privacy Policy, please contact us:</p>
        <div class="bg-gray-50 rounded-xl p-4 mt-3 border border-gray-100">
            <p class="text-sm"><strong>Email:</strong> <a href="mailto:{{ config('site.contact.email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.email') }}</a></p>
            <p class="text-sm mt-1"><strong>Website:</strong> <a href="{{ config('site.url') }}" class="text-indigo-600 hover:underline">{{ config('site.url') }}</a></p>
        </div>
    </div>
</div>
@endsection
