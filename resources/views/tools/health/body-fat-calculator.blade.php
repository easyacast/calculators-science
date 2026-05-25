@extends('layouts.app')

@section('title', 'Body Fat Percentage Calculator - Free Online')
@section('meta_description', 'Free Estimate body fat percentage using the U.S. Navy method. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/health/body-fat-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Body Fat Percentage Calculator",
    "applicationCategory": "HealthApplication",
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
            <li><a href="{{ config('site.url') }}/health" class="hover:text-indigo-600">Health</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Body Fat Percentage Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Body Fat Percentage Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Estimate body fat percentage using the U.S. Navy method.</p>

    <div x-data="bodyFatCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Waist (inches)</label>
                <input type="number" x-model.number="waist" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="34">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Neck (inches)</label>
                <input type="number" x-model.number="neck" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="15">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Height (inches)</label>
                <input type="number" x-model.number="height" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="70">
            </div>
        </div>

        <button @click="calculate()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Calculate</button>

        <div x-show="calculated" x-cloak class="mt-6">
            <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-200 text-center mb-4">
                <div class="text-xs text-indigo-600 font-medium uppercase mb-1">Result</div>
                <div class="text-2xl font-bold text-gray-900" x-text="result"></div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <h3 class="font-semibold text-gray-900 text-sm mb-2">Step-by-Step Solution</h3>
                <pre class="text-sm text-gray-700 whitespace-pre-wrap" x-text="steps"></pre>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Body Fat Percentage Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Estimate body fat percentage using the U.S. Navy method. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">BF% = 86.010 × log10(waist − neck) − 70.041 × log10(height) + 36.76</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function bodyFatCalculator() {
    return {
        waist: 34,
        neck: 15,
        height: 70,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let bf = 86.010 * Math.log10(this.waist - this.neck) - 70.041 * Math.log10(this.height) + 36.76;
this.result = bf.toFixed(1);
this.steps = 'Body Fat = 86.010 × log(' + (this.waist-this.neck) + ') − 70.041 × log(' + this.height + ') + 36.76 = ' + this.result + '%';
                this.calculated = true;
            } catch(e) {
                this.result = 'Error: Please check your inputs';
                this.steps = e.message;
                this.calculated = true;
            }
        },
    };
}
</script>
@endsection