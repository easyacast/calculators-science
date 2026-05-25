@extends('layouts.app')

@section('title', 'Wilks Score Calculator - Free Online')
@section('meta_description', 'Free Calculate Wilks coefficient for powerlifting comparison. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/sports/wilks-score-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Wilks Score Calculator",
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
            <li class="text-gray-900 font-medium">Wilks Score Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Wilks Score Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate Wilks coefficient for powerlifting comparison.</p>

    <div x-data="wilksScoreCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Powerlifting Total (kg)</label>
                <input type="number" x-model.number="total" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Body Weight (kg)</label>
                <input type="number" x-model.number="bodyWeight" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="80">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Male (1) / Female (0)</label>
                <input type="number" x-model.number="isMale" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Wilks Score Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Calculate Wilks coefficient for powerlifting comparison. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Wilks = Total × Coefficient(bodyweight)</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function wilksScoreCalculator() {
    return {
        total: 500,
        bodyWeight: 80,
        isMale: 1,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let bw = this.bodyWeight;
let coeff;
if (this.isMale) { let a=-216.0475144,b=16.2606339,c=-0.002388645,d=-0.00113732,e=7.01863e-6,f=-1.291e-8; coeff=500/(a+b*bw+c*bw*bw+d*bw*bw*bw+e*Math.pow(bw,4)+f*Math.pow(bw,5)); }
else { let a=594.31747775582,b=-27.23842536447,c=0.82112226871,d=-0.00930733913,e=4.731582e-5,f=-9.054e-8; coeff=500/(a+b*bw+c*bw*bw+d*bw*bw*bw+e*Math.pow(bw,4)+f*Math.pow(bw,5)); }
let wilks = (this.total * coeff).toFixed(2);
this.result = wilks;
this.steps = 'Wilks Score: ' + wilks + '\nCoefficient: ' + coeff.toFixed(4);
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