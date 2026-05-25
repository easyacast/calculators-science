@extends('layouts.app')

@section('title', 'Strength Standards Calculator - Free Online')
@section('meta_description', 'Free Compare your lifts to strength standards. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/sports/strength-standards-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Strength Standards Calculator",
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
            <li><a href="{{ config('site.url') }}/sports" class="hover:text-indigo-600">Sports</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Strength Standards Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Strength Standards Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Compare your lifts to strength standards.</p>

    <div x-data="strengthStandardsCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Body Weight (lbs)</label>
                <input type="number" x-model.number="bodyWeight" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="180">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bench Press (lbs)</label>
                <input type="number" x-model.number="bench" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="225">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Squat (lbs)</label>
                <input type="number" x-model.number="squat" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="315">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deadlift (lbs)</label>
                <input type="number" x-model.number="deadlift" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="405">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Strength Standards Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Compare your lifts to strength standards. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Ratios relative to body weight</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function strengthStandardsCalculator() {
    return {
        bodyWeight: 180,
        bench: 225,
        squat: 315,
        deadlift: 405,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let bRatio = (this.bench / this.bodyWeight).toFixed(2);
let sRatio = (this.squat / this.bodyWeight).toFixed(2);
let dRatio = (this.deadlift / this.bodyWeight).toFixed(2);
let total = this.bench + this.squat + this.deadlift;
this.result = total + ' lbs total';
this.steps = 'Bench: ' + bRatio + 'x BW\nSquat: ' + sRatio + 'x BW\nDeadlift: ' + dRatio + 'x BW\nTotal: ' + total + ' lbs (' + (total/this.bodyWeight).toFixed(2) + 'x BW)';
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