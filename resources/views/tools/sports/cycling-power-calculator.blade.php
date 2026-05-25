@extends('layouts.app')

@section('title', 'Cycling Power Calculator - Free Online')
@section('meta_description', 'Free Calculate cycling power output. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/sports/cycling-power-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Cycling Power Calculator",
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
            <li class="text-gray-900 font-medium">Cycling Power Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Cycling Power Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate cycling power output.</p>

    <div x-data="cyclingPowerCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rider + Bike Weight (kg)</label>
                <input type="number" x-model.number="weight" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="80">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Speed (km/h)</label>
                <input type="number" x-model.number="speed" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="30">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gradient (%)</label>
                <input type="number" x-model.number="gradient" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="0">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Cycling Power Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Calculate cycling power output. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">P = (Crr × m × g + 0.5 × Cd × A × ρ × v² + m × g × sin(θ)) × v</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function cyclingPowerCalculator() {
    return {
        weight: 80,
        speed: 30,
        gradient: 0,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let v = this.speed / 3.6;
let crr = 0.005;
let cdA = 0.4;
let rho = 1.225;
let g = 9.81;
let theta = Math.atan(this.gradient / 100);
let p = (crr * this.weight * g + 0.5 * cdA * rho * v * v + this.weight * g * Math.sin(theta)) * v;
this.result = p.toFixed(0) + ' watts';
this.steps = 'Rolling resistance: ' + (crr * this.weight * g * v).toFixed(0) + 'W\nAero drag: ' + (0.5 * cdA * rho * v * v * v).toFixed(0) + 'W\nGravity: ' + (this.weight * g * Math.sin(theta) * v).toFixed(0) + 'W\nTotal: ' + this.result;
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