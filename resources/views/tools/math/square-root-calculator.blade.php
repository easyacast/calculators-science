@extends('layouts.app')
@section('title', 'Square Root Calculator - Find √x Online')
@section('meta_description', 'Free square root calculator. Find the square root of any number with step-by-step explanation. Includes perfect square checker and Nth root calculator.')
@section('canonical', config('site.url') . '/math/square-root-calculator')
@section('schema')<script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Square Root Calculator","applicationCategory":"CalculatorApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}</script>@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6"><ol class="flex items-center gap-2 text-sm text-gray-500"><li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li><li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li><li><a href="{{ config('site.url') }}/math" class="hover:text-indigo-600">Mathematics</a></li><li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li><li class="text-gray-900 font-medium">Square Root Calculator</li></ol></nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Square Root Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Find the square root (or Nth root) of any number. Checks if the number is a perfect square and gives exact or decimal results.</p>

    <div x-data="sqrtCalc()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Number</label><input type="number" x-model.number="num" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="144"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Root (n)</label><input type="number" x-model.number="root" step="1" min="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2"></div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Calculate</button>
        <div x-show="result !== null" x-cloak class="mt-5 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-5 border border-indigo-100">
            <div class="text-xs font-medium text-indigo-500 uppercase tracking-wider mb-1">Result</div>
            <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            <div class="text-sm text-gray-600 mt-1" x-text="isPerfect ? 'This is a perfect square!' : 'This is not a perfect square.'"></div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">What is a Square Root?</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The square root of a number x is a value y such that $y^2 = x$. For example, $\sqrt{144} = 12$ because $12 \times 12 = 144$.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center"><p class="formula-block">$$\sqrt[n]{x} = x^{1/n}$$</p></div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Perfect Squares (1-20)</h2>
        <p class="text-gray-600 mb-6">1, 4, 9, 16, 25, 36, 49, 64, 81, 100, 121, 144, 169, 196, 225, 256, 289, 324, 361, 400.</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
function sqrtCalc() {
    return {
        num: 144, root: 2, result: null, resultText: '', isPerfect: false,
        calculate() {
            if (this.num < 0 && this.root % 2 === 0) { this.resultText = 'Cannot take even root of a negative number'; this.result = NaN; return; }
            this.result = Math.pow(Math.abs(this.num), 1 / this.root) * (this.num < 0 ? -1 : 1);
            this.resultText = `${this.root === 2 ? '√' : this.root + '√'}${this.num} = ${this.result.toFixed(10).replace(/\.?0+$/, '')}`;
            this.isPerfect = this.root === 2 && Number.isInteger(Math.sqrt(this.num));
        },
    };
}
</script>
@endsection
