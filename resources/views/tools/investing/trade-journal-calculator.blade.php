@extends('layouts.app')

@section('title', 'Trade Journal Calculator - Free Online')
@section('meta_description', 'Free Track and analyze trading performance. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/investing/trade-journal-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Trade Journal Calculator",
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
            <li class="text-gray-900 font-medium">Trade Journal Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Trade Journal Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Track and analyze trading performance.</p>

    <div x-data="tradeJournalCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Number of Wins</label>
                <input type="number" x-model.number="wins" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="60">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Number of Losses</label>
                <input type="number" x-model.number="losses" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="40">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Average Win ($)</label>
                <input type="number" x-model.number="avgWin" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="200">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Average Loss ($)</label>
                <input type="number" x-model.number="avgLoss" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="100">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Trade Journal Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Track and analyze trading performance. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Win Rate, Profit Factor, Expected Value</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function tradeJournalCalculator() {
    return {
        wins: 60,
        losses: 40,
        avgWin: 200,
        avgLoss: 100,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let winRate = (this.wins / (this.wins + this.losses) * 100).toFixed(1);
let totalWins = this.wins * this.avgWin;
let totalLosses = this.losses * this.avgLoss;
let profitFactor = (totalWins / totalLosses).toFixed(2);
let ev = ((this.wins * this.avgWin - this.losses * this.avgLoss) / (this.wins + this.losses)).toFixed(2);
this.result = 'Win rate: ' + winRate + '%';
this.steps = 'Win rate: ' + winRate + '%\nProfit factor: ' + profitFactor + '\nExpected value: $' + ev + '/trade\nNet P/L: $' + (totalWins-totalLosses).toLocaleString();
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