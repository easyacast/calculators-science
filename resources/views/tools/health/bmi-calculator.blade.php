@extends('layouts.app')

@section('title', 'BMI Calculator - Body Mass Index')
@section('meta_description', 'Free BMI Calculator. Calculate your Body Mass Index using height and weight. Understand BMI categories, health risks, and what your BMI means with detailed explanations.')
@section('canonical', config('site.url') . '/health/bmi-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "BMI Calculator",
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
            <li><a href="{{ config('site.url') }}/health" class="hover:text-indigo-600">Health & Fitness</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">BMI Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">BMI Calculator (Body Mass Index)</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate your Body Mass Index to understand your weight category. Enter your height and weight to get your BMI with a detailed health assessment.</p>

    <div x-data="bmiCalc()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="flex gap-3 mb-4">
            <button @click="unit = 'metric'" :class="unit === 'metric' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Metric (kg/cm)</button>
            <button @click="unit = 'imperial'" :class="unit === 'imperial' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Imperial (lbs/in)</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" x-text="unit === 'metric' ? 'Height (cm)' : 'Height (inches)'">Height</label>
                <input type="number" x-model.number="height" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" :placeholder="unit === 'metric' ? '175' : '70'">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1" x-text="unit === 'metric' ? 'Weight (kg)' : 'Weight (lbs)'">Weight</label>
                <input type="number" x-model.number="weight" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" :placeholder="unit === 'metric' ? '70' : '154'">
            </div>
        </div>

        <button @click="calculate()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Calculate BMI</button>

        <div x-show="bmi !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r rounded-xl p-5 border" :class="categoryColor">
                <div class="text-xs font-medium uppercase tracking-wider mb-1" :class="categoryTextColor">Your BMI</div>
                <div class="text-3xl font-bold text-gray-900" x-text="bmi.toFixed(1)"></div>
                <div class="text-lg font-semibold mt-1" :class="categoryTextColor" x-text="category"></div>
            </div>

            {{-- BMI Scale --}}
            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>Underweight</span><span>Normal</span><span>Overweight</span><span>Obese</span>
                </div>
                <div class="w-full h-3 rounded-full bg-gradient-to-r from-blue-400 via-green-400 via-yellow-400 to-red-500 relative">
                    <div class="absolute w-3 h-5 bg-gray-900 rounded -top-1 transform -translate-x-1/2" :style="`left: ${Math.min(Math.max((bmi - 15) / 25 * 100, 0), 100)}%`"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-400 mt-1">
                    <span>15</span><span>18.5</span><span>25</span><span>30</span><span>40</span>
                </div>
            </div>

            <div class="mt-4 text-sm text-gray-600">
                <p x-text="explanation"></p>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">What is BMI?</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Body Mass Index (BMI) is a simple measurement using your height and weight to work out if your weight is healthy. It was developed by Belgian mathematician Adolphe Quetelet in the 1830s as a quick screening tool for population health studies.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">BMI Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block">$$BMI = \frac{\text{weight (kg)}}{\text{height (m)}^2}$$</p>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">BMI Categories</h2>
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-sm text-gray-600">
                <thead><tr class="border-b border-gray-200"><th class="text-left py-2">Category</th><th class="text-left py-2">BMI Range</th></tr></thead>
                <tbody>
                    <tr class="border-b border-gray-100"><td class="py-2">Underweight</td><td>Below 18.5</td></tr>
                    <tr class="border-b border-gray-100"><td class="py-2">Normal weight</td><td>18.5 - 24.9</td></tr>
                    <tr class="border-b border-gray-100"><td class="py-2">Overweight</td><td>25.0 - 29.9</td></tr>
                    <tr><td class="py-2">Obese</td><td>30.0 and above</td></tr>
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Related Tools</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ config('site.url') }}/math/percentage-calculator" class="block bg-white border border-gray-200 hover:border-indigo-300 rounded-lg p-4"><h3 class="font-semibold text-gray-900 text-sm">Percentage Calculator</h3></a>
            <a href="{{ config('site.url') }}/unit-converter/weight-converter" class="block bg-white border border-gray-200 hover:border-indigo-300 rounded-lg p-4"><h3 class="font-semibold text-gray-900 text-sm">Weight Converter</h3></a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function bmiCalc() {
    return {
        unit: 'metric', height: 175, weight: 70, bmi: null, category: '', explanation: '',
        categoryColor: '', categoryTextColor: '',

        calculate() {
            let h, w;
            if (this.unit === 'metric') { h = this.height / 100; w = this.weight; }
            else { h = this.height * 0.0254; w = this.weight * 0.453592; }

            if (h <= 0 || w <= 0) return;
            this.bmi = w / (h * h);

            if (this.bmi < 18.5) {
                this.category = 'Underweight';
                this.categoryColor = 'from-blue-50 to-blue-100 border-blue-200';
                this.categoryTextColor = 'text-blue-600';
                this.explanation = 'Your BMI indicates you are underweight. Consider consulting a healthcare provider about nutrition and healthy weight gain strategies.';
            } else if (this.bmi < 25) {
                this.category = 'Normal Weight';
                this.categoryColor = 'from-green-50 to-green-100 border-green-200';
                this.categoryTextColor = 'text-green-600';
                this.explanation = 'Your BMI is in the healthy range. Maintain your weight with a balanced diet and regular physical activity.';
            } else if (this.bmi < 30) {
                this.category = 'Overweight';
                this.categoryColor = 'from-yellow-50 to-yellow-100 border-yellow-200';
                this.categoryTextColor = 'text-yellow-700';
                this.explanation = 'Your BMI indicates you are overweight. Consider incorporating more physical activity and a balanced diet.';
            } else {
                this.category = 'Obese';
                this.categoryColor = 'from-red-50 to-red-100 border-red-200';
                this.categoryTextColor = 'text-red-600';
                this.explanation = 'Your BMI indicates obesity. We recommend consulting a healthcare provider for personalized health guidance.';
            }
        },
    };
}
</script>
@endsection
