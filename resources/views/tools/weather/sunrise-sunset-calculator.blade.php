@extends('layouts.app')

@section('title', 'Sunrise &amp; Sunset Calculator - Free Online')
@section('meta_description', 'Free Estimate sunrise and sunset times for a location. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/weather/sunrise-sunset-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Sunrise &amp; Sunset Calculator",
    "applicationCategory": "WeatherApplication",
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
            <li><a href="{{ config('site.url') }}/weather" class="hover:text-indigo-600">Weather</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Sunrise &amp; Sunset Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Sunrise &amp; Sunset Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Estimate sunrise and sunset times for a location.</p>

    <div x-data="sunriseSunsetCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                <input type="number" x-model.number="latitude" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="40.7">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Day of Year (1-365)</label>
                <input type="number" x-model.number="dayOfYear" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="172">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Sunrise &amp; Sunset Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Estimate sunrise and sunset times for a location. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Approximate sunrise/sunset from latitude and solar declination</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function sunriseSunsetCalculator() {
    return {
        latitude: 40.7,
        dayOfYear: 172,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let dec = 23.45 * Math.sin(2 * Math.PI * (284 + this.dayOfYear) / 365);
let ha = Math.acos(-Math.tan(this.latitude * Math.PI/180) * Math.tan(dec * Math.PI/180)) * 180 / Math.PI;
let daylight = (2 * ha / 15).toFixed(1);
let sunrise = 12 - ha/15;
let sunset = 12 + ha/15;
this.result = daylight + ' hours of daylight';
this.steps = 'Sunrise: ' + Math.floor(sunrise) + ':' + String(Math.round((sunrise%1)*60)).padStart(2,'0') + '\nSunset: ' + Math.floor(sunset) + ':' + String(Math.round((sunset%1)*60)).padStart(2,'0') + '\nDaylight: ' + daylight + ' hours';
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