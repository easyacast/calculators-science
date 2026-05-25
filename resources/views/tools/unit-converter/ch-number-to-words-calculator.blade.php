@extends('layouts.app')

@section('title', 'Ch Number To Words Calculator - Free Online')
@section('meta_description', 'Free online ch number to words calculator. Step-by-step solutions included.')
@section('canonical', config('site.url') . '/unit-converter/ch-number-to-words-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Ch Number To Words Calculator",
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
            <li class="text-gray-900 font-medium">Ch Number To Words Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Ch Number To Words Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Free online ch number to words calculator.</p>

    <div x-data="calcChNumberToWords()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Value (number)</label>
                <input type="number" x-model.number="value" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter value">
            </div>
        </div>
        <button @click="convert()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Convert</button>
        <div x-show="calculated" x-cloak class="mt-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200 text-center">
                    <div class="text-xs text-blue-600 font-medium uppercase mb-1">From (number)</div>
                    <div class="text-2xl font-bold text-gray-900" x-text="value"></div>
                </div>
                <div class="bg-green-50 rounded-xl p-4 border border-green-200 text-center">
                    <div class="text-xs text-green-600 font-medium uppercase mb-1">To (words)</div>
                    <div class="text-2xl font-bold text-gray-900" x-text="result"></div>
                </div>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Ch Number To Words Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Free online ch number to words calculator. This tool provides instant results with clear explanations.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Number to Words</h2>
        <p class="text-gray-600 leading-relaxed mb-6">Convert between number and words instantly. Enter a value and click Convert to see the result.</p>


        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function calcChNumberToWords() {
    return {
        value: 1,
        result: '',
        calculated: false,
        numberToWords(n) { const o=['','one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen'];const t=['','','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety'];if(n<20)return o[n];if(n<100)return t[Math.floor(n/10)]+' '+o[n%10];if(n<1000)return o[Math.floor(n/100)]+' hundred '+this.numberToWords(n%100);return Math.floor(n/1000)+' thousand '+this.numberToWords(n%1000); },
        convert() {
            this.result = this.numberToWords(this.value);
            this.calculated = true;
        },
    };
}
</script>
@endsection