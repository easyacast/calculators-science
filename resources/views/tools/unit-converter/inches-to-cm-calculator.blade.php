@extends('layouts.app')

@section('title', 'Inches To Cm Calculator - Free Online')
@section('meta_description', 'Free online inches to cm calculator. Step-by-step solutions included.')
@section('canonical', config('site.url') . '/unit-converter/inches-to-cm-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Inches To Cm Calculator",
    "applicationCategory": "UtilitiesApplication",
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
            <li><a href="{{ config('site.url') }}/unit-converter" class="hover:text-indigo-600">Unit Converter</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Inches To Cm Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Inches To Cm Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Free online inches to cm calculator.</p>

    <div x-data="calcInchesToCm()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Value (inches)</label>
                <input type="number" x-model.number="value" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter value">
            </div>
        </div>
        <button @click="convert()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Convert</button>
        <div x-show="calculated" x-cloak class="mt-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200 text-center">
                    <div class="text-xs text-blue-600 font-medium uppercase mb-1">From (inches)</div>
                    <div class="text-2xl font-bold text-gray-900" x-text="value"></div>
                </div>
                <div class="bg-green-50 rounded-xl p-4 border border-green-200 text-center">
                    <div class="text-xs text-green-600 font-medium uppercase mb-1">To (cm)</div>
                    <div class="text-2xl font-bold text-gray-900" x-text="result"></div>
                </div>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Inches To Cm Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Free online inches to cm calculator. This tool provides instant results with clear explanations.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Inches to Centimeters</h2>
        <p class="text-gray-600 leading-relaxed mb-6">Convert between inches and cm instantly. Enter a value and click Convert to see the result.</p>


        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function calcInchesToCm() {
    return {
        value: 1,
        result: '',
        calculated: false,
        convert() {
            this.result = (this.value *2.54).toFixed(6);
            this.calculated = true;
        },
    };
}
</script>
@endsection