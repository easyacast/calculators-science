@extends('layouts.app')

@section('title', 'Favicongenerator Calculator - Free Online')
@section('meta_description', 'Free online favicongenerator calculator. Step-by-step solutions included.')
@section('canonical', config('site.url') . '/tech-tools/favicongenerator-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Favicongenerator Calculator",
    "applicationCategory": "DeveloperApplication",
    "operatingSystem": "Web",
    "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }
}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/tech-tools" class="hover:text-indigo-600">Tech Tools</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Favicongenerator Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Favicongenerator Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Free online favicongenerator calculator.</p>

    <div x-data="calcFavicongenerator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Input</label>
                <input type="text" x-model="input" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter value...">
            </div>
        </div>
        <button @click="process()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Process</button>
        <div x-show="result" x-cloak class="mt-6">
            <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-200 text-center mb-4">
                <div class="text-xs text-indigo-600 font-medium uppercase mb-1">Result</div>
                <div class="text-lg font-bold text-gray-900" x-text="result"></div>
            </div>
            <div x-show="details" class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <pre class="text-sm text-gray-700 whitespace-pre-wrap" x-text="details"></pre>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Favicongenerator Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Free online favicongenerator calculator. This tool provides instant results with clear explanations.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">How to Use</h2>
        <p class="text-gray-600 leading-relaxed mb-6">Enter your input and click Process to see the results. This tool is designed for developers and technical users.</p>


        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function calcFavicongenerator() {
    return {
        input: '',
        result: '',
        details: '',
        process() {
            if (!this.input) { this.result = 'Please enter a value'; return; }
            this.result = 'Processed: ' + this.input;
            this.details = 'Input length: ' + this.input.length + ' characters';
        },
    };
}
</script>
@endsection