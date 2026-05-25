@extends('layouts.app')

@section('title', 'Currency Trading Profit Calculator - Free Online')
@section('meta_description', 'Free Calculate forex trading profit/loss. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/investing/currency-profit-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Currency Trading Profit Calculator",
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
            <li><a href="{{ config('site.url') }}/investing" class="hover:text-indigo-600">Investing</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Currency Trading Profit Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Currency Trading Profit Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate forex trading profit/loss.</p>

    <div x-data="currencyProfitCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lot Size (units)</label>
                <input type="number" x-model.number="lotSize" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="100000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Entry Price</label>
                <input type="number" x-model.number="entryPrice" step="0.0001" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1.1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Exit Price</label>
                <input type="number" x-model.number="exitPrice" step="0.0001" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1.105">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pip Value ($)</label>
                <input type="number" x-model.number="pipValue" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Currency Trading Profit Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Calculate forex trading profit/loss. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Profit = Pips × Pip Value</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function currencyProfitCalculator() {
    return {
        lotSize: 100000,
        entryPrice: 1.1,
        exitPrice: 1.105,
        pipValue: 10,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let pips = (this.exitPrice - this.entryPrice) * 10000;
let profit = pips * this.pipValue;
this.result = '$' + profit.toFixed(2) + ' (' + pips.toFixed(1) + ' pips)';
this.steps = 'Entry: ' + this.entryPrice + '\nExit: ' + this.exitPrice + '\nPips: ' + pips.toFixed(1) + '\nProfit: ' + this.result;
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