@extends('layouts.app')

@section('title', 'Cash Back vs Low Rate Calculator - Free Online')
@section('meta_description', 'Free Compare cash back offer vs low interest rate. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/finance/cash-back-vs-low-rate-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Cash Back vs Low Rate Calculator",
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
            <li class="text-gray-900 font-medium">Cash Back vs Low Rate Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Cash Back vs Low Rate Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Compare cash back offer vs low interest rate.</p>

    <div x-data="cashBackVsLowRateCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Loan Amount ($)</label>
                <input type="number" x-model.number="loanAmount" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="30000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cash Back ($)</label>
                <input type="number" x-model.number="cashBack" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Normal Rate (%)</label>
                <input type="number" x-model.number="normalRate" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="4.9">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Low Rate (%)</label>
                <input type="number" x-model.number="lowRate" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1.9">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Term (months)</label>
                <input type="number" x-model.number="months" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="60">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Cash Back vs Low Rate Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Compare cash back offer vs low interest rate. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Compare total cost of each option</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function cashBackVsLowRateCalculator() {
    return {
        loanAmount: 30000,
        cashBack: 2000,
        normalRate: 4.9,
        lowRate: 1.9,
        months: 60,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let r1 = this.normalRate/100/12, r2 = this.lowRate/100/12;
let n = this.months;
let adj = this.loanAmount - this.cashBack;
let pay1 = adj * r1 * Math.pow(1+r1,n) / (Math.pow(1+r1,n)-1);
let pay2 = this.loanAmount * r2 * Math.pow(1+r2,n) / (Math.pow(1+r2,n)-1);
let total1 = pay1 * n, total2 = pay2 * n;
let better = total1 < total2 ? 'Cash Back' : 'Low Rate';
this.result = better + ' saves $' + Math.abs(total1-total2).toFixed(2);
this.steps = 'Cash back total: $' + total1.toFixed(2) + ' ($' + pay1.toFixed(2) + '/mo)\nLow rate total: $' + total2.toFixed(2) + ' ($' + pay2.toFixed(2) + '/mo)\nBetter option: ' + better;
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