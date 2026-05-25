@extends('layouts.app')
@section('title', 'Terms of Service')
@section('meta_description', config('site.name') . ' Terms of Service — rules and guidelines for using our free scientific calculators, AI math solver, and educational tools.')
@section('canonical', config('site.url') . '/terms-of-service')
@section('robots', 'noindex, follow')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Terms of Service</h1>
    <p class="text-sm text-gray-500 mb-8">Last updated: {{ date('F j, Y') }}</p>

    <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">

        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 mb-8">
            <p class="text-sm text-indigo-800 font-medium">By accessing and using {{ config('site.name') }}, you agree to be bound by these Terms of Service. If you do not agree with any part of these terms, please do not use our website.</p>
        </div>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">1. Acceptance of Terms</h2>
        <p>By accessing {{ config('site.name') }} at <strong>{{ config('site.url') }}</strong>, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service and our <a href="{{ config('site.url') }}/privacy-policy" class="text-indigo-600 hover:underline">Privacy Policy</a>. These terms apply to all visitors, users, and others who access or use the website.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">2. Description of Service</h2>
        <p>{{ config('site.name') }} provides free online scientific calculators, educational tools, unit converters, and an AI-powered math solver. Our services include:</p>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li>Interactive calculators for Mathematics, Physics, Chemistry, Biology, Finance, Engineering, and Health</li>
            <li>Unit conversion tools for common measurements</li>
            <li>An AI Math Solver that provides step-by-step solutions to math problems</li>
            <li>Educational content including formulas, explanations, and examples</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">3. Use of Service</h2>
        <p class="mb-3">You agree to use {{ config('site.name') }} only for lawful purposes and in accordance with these Terms. You agree not to:</p>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li>Use our tools for any illegal or unauthorized purpose</li>
            <li>Attempt to gain unauthorized access to any part of the website, servers, or databases</li>
            <li>Use automated scripts or bots to access the website in a manner that overloads our servers</li>
            <li>Reproduce, duplicate, copy, or resell any part of the website without our express written permission</li>
            <li>Use the AI Math Solver to generate content that violates any laws or regulations</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">4. Accuracy Disclaimer</h2>
        <p>While we strive for accuracy in all our calculators and tools, {{ config('site.name') }} is provided for <strong>educational and informational purposes only</strong>. We make no guarantees about the completeness, reliability, or accuracy of any calculations or results.</p>
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 my-4">
            <p class="text-sm text-amber-800"><strong>Important:</strong> Do not rely solely on our tools for critical decisions in medical, financial, engineering, or legal matters. Always verify important calculations independently and consult qualified professionals when necessary.</p>
        </div>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">5. AI Math Solver</h2>
        <p>The AI Math Solver uses third-party artificial intelligence services to process and solve mathematical problems. Please be aware that:</p>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li>AI-generated solutions may occasionally contain errors or inaccuracies</li>
            <li>The AI may not be able to solve all types of mathematical problems</li>
            <li>Math problems you submit may be processed by third-party AI providers</li>
            <li>We do not permanently store your math queries or solutions</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">6. Intellectual Property</h2>
        <p>The {{ config('site.name') }} website, including its design, code, calculators, educational content, and branding, is owned by us and protected by intellectual property laws. You may use our tools for personal and educational purposes but may not:</p>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li>Copy, modify, or distribute our calculator code or designs</li>
            <li>Use our branding, logos, or content without written permission</li>
            <li>Frame or embed our tools on other websites without authorization</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">7. Limitation of Liability</h2>
        <p>To the fullest extent permitted by applicable law, {{ config('site.name') }} and its team shall not be liable for any indirect, incidental, special, consequential, or punitive damages, including but not limited to loss of profits, data, or other intangible losses, resulting from:</p>
        <ul class="list-disc list-inside space-y-1 mb-4">
            <li>Your use of or inability to use our services</li>
            <li>Any errors or inaccuracies in calculator results</li>
            <li>Unauthorized access to your data transmitted through our website</li>
            <li>Any interruption or cessation of our services</li>
        </ul>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">8. Advertising</h2>
        <p>{{ config('site.name') }} may display third-party advertisements to support the free operation of our services. We use Google AdSense and similar platforms, which may use cookies and tracking technologies. By using our website, you acknowledge the presence of these advertisements.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">9. External Links</h2>
        <p>Our website may contain links to third-party websites or services that are not owned or controlled by {{ config('site.name') }}. We have no control over, and assume no responsibility for, the content, privacy policies, or practices of any third-party websites.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">10. Modifications to Terms</h2>
        <p>We reserve the right to modify these Terms of Service at any time. Changes will be effective immediately upon posting to this page. Your continued use of {{ config('site.name') }} after any changes constitutes your acceptance of the new terms.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">11. Termination</h2>
        <p>We reserve the right to terminate or suspend access to our services immediately, without prior notice, for any reason, including breach of these Terms.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">12. Governing Law</h2>
        <p>These Terms shall be governed by and construed in accordance with the laws applicable in the jurisdiction where {{ config('site.name') }} operates, without regard to its conflict of law provisions.</p>

        <h2 class="text-xl font-bold text-gray-900 mt-8 mb-3">13. Contact Us</h2>
        <p>If you have any questions about these Terms of Service, please contact us:</p>
        <div class="bg-gray-50 rounded-xl p-4 mt-3 border border-gray-100">
            <p class="text-sm"><strong>Email:</strong> <a href="mailto:{{ config('site.contact.email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.email') }}</a></p>
            <p class="text-sm mt-1"><strong>Website:</strong> <a href="{{ config('site.url') }}" class="text-indigo-600 hover:underline">{{ config('site.url') }}</a></p>
        </div>
    </div>
</div>

@include('components.static-page-links', ['currentPage' => 'terms'])

@endsection
