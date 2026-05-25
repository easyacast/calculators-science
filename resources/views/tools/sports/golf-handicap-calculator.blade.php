@extends('layouts.app')

@section('title', 'Golf Handicap Calculator - Free Online')
@section('meta_description', 'Free Calculate golf handicap index from recent scores. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/sports/golf-handicap-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Golf Handicap Calculator",
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
            <li class="text-gray-900 font-medium">Golf Handicap Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Golf Handicap Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate golf handicap index from recent scores.</p>

    <div x-data="golfHandicapCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Score 1</label>
                <input type="number" x-model.number="score1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="85">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Score 2</label>
                <input type="number" x-model.number="score2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="88">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Score 3</label>
                <input type="number" x-model.number="score3" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="82">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Course Rating</label>
                <input type="number" x-model.number="courseRating" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="72">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slope Rating</label>
                <input type="number" x-model.number="slopeRating" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="113">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Golf Handicap Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Calculate golf handicap index from recent scores. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Differential = (Score − Course Rating) × 113 / Slope</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function golfHandicapCalculator() {
    return {
        score1: 85,
        score2: 88,
        score3: 82,
        courseRating: 72,
        slopeRating: 113,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let scores = [this.score1, this.score2, this.score3];
let diffs = scores.map(s => (s - this.courseRating) * 113 / this.slopeRating);
let avg = diffs.reduce((a,b) => a+b) / diffs.length;
let handicap = (avg * 0.96).toFixed(1);
this.result = handicap;
this.steps = 'Differentials: ' + diffs.map(d => d.toFixed(1)).join(', ') + '\nAverage: ' + avg.toFixed(1) + '\nHandicap Index: ' + handicap;
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