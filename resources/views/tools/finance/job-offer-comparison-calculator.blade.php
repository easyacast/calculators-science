@extends('layouts.app')

@section('title', 'Job Offer Comparison Calculator - Free Online')
@section('meta_description', 'Free Compare multiple job offers with total compensation. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/finance/job-offer-comparison-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Job Offer Comparison Calculator",
    "applicationCategory": "FinanceApplication",
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
            <li><a href="{{ config('site.url') }}/finance" class="hover:text-indigo-600">Finance</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Job Offer Comparison Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Job Offer Comparison Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Compare multiple job offers with total compensation.</p>

    <div x-data="jobOfferComparisonCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Offer 1 Salary ($)</label>
                <input type="number" x-model.number="salary1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="80000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Offer 1 Bonus ($)</label>
                <input type="number" x-model.number="bonus1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="5000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Offer 1 Benefits Value ($)</label>
                <input type="number" x-model.number="benefits1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="15000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Offer 2 Salary ($)</label>
                <input type="number" x-model.number="salary2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="90000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Offer 2 Bonus ($)</label>
                <input type="number" x-model.number="bonus2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Offer 2 Benefits Value ($)</label>
                <input type="number" x-model.number="benefits2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10000">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Job Offer Comparison Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Compare multiple job offers with total compensation. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Total Comp = Salary + Bonus + Benefits</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function jobOfferComparisonCalculator() {
    return {
        salary1: 80000,
        bonus1: 5000,
        benefits1: 15000,
        salary2: 90000,
        bonus2: 0,
        benefits2: 10000,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let total1 = this.salary1 + this.bonus1 + this.benefits1;
let total2 = this.salary2 + this.bonus2 + this.benefits2;
let better = total1 > total2 ? 'Offer 1' : 'Offer 2';
this.result = better + ' by $' + Math.abs(total1-total2).toLocaleString();
this.steps = 'Offer 1: $' + total1.toLocaleString() + '\nOffer 2: $' + total2.toLocaleString() + '\n' + better + ' is better';
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