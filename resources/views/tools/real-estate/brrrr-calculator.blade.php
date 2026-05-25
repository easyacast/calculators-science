@extends('layouts.app')

@section('title', 'BRRRR Calculator - Free Online')
@section('meta_description', 'Free Analyze Buy-Rehab-Rent-Refinance-Repeat deals. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/real-estate/brrrr-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "BRRRR Calculator",
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
            <li><a href="{{ config('site.url') }}/real-estate" class="hover:text-indigo-600">Real Estate</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">BRRRR Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">BRRRR Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Analyze Buy-Rehab-Rent-Refinance-Repeat deals.</p>

    <div x-data="brrrrCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Price ($)</label>
                <input type="number" x-model.number="purchasePrice" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="100000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rehab Cost ($)</label>
                <input type="number" x-model.number="rehabCost" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="30000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">After Repair Value ($)</label>
                <input type="number" x-model.number="arv" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="180000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Refinance LTV (%)</label>
                <input type="number" x-model.number="refinanceLTV" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="75">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Rent ($)</label>
                <input type="number" x-model.number="monthlyRent" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1500">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About BRRRR Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Analyze Buy-Rehab-Rent-Refinance-Repeat deals. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Cash left in deal after refinance</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function brrrrCalculator() {
    return {
        purchasePrice: 100000,
        rehabCost: 30000,
        arv: 180000,
        refinanceLTV: 75,
        monthlyRent: 1500,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let totalInvested = this.purchasePrice + this.rehabCost;
let refinanceAmount = this.arv * this.refinanceLTV / 100;
let cashLeft = totalInvested - refinanceAmount;
this.result = '$' + Math.max(0, cashLeft).toLocaleString() + ' left in deal';
this.steps = 'Total invested: $' + totalInvested.toLocaleString() + '\nRefinance at: $' + refinanceAmount.toLocaleString() + '\nCash left: $' + cashLeft.toLocaleString() + '\nMonthly rent: $' + this.monthlyRent;
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