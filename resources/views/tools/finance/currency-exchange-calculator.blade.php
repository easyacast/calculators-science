@extends('layouts.app')
@section('title', 'Currency Exchange Calculator')
@section('meta_description', 'Calculate currency conversion at a given rate.')
@section('canonical', config('site.url') . '/finance/currency-exchange-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Currency Exchange Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Currency Exchange Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Currency Exchange Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate currency conversion at a given rate.</p>
    <div x-data="currencyExchangeCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                <input type="number" x-model.number="amount" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Exchange Rate</label>
                <input type="number" x-model.number="rate" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="0.85">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Currency</label>
                <input type="number" x-model.number="from" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="USD">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To Currency</label>
                <input type="number" x-model.number="to" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="EUR">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-emerald-50 to-orange-50 rounded-xl p-5 border border-emerald-200">
                <div class="text-xs font-medium text-emerald-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Currency Exchange Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Exchange rates fluctuate constantly. Banks and services add markup. Use mid-market rate for fair comparison.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$amount_{to} = amount_{from} \times rate$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function currencyExchangeCalculator() {
    return {
        amount: '', rate: '', from: '', to: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let amt=parseFloat(this.amount),rate=parseFloat(this.rate);if(!amt||!rate){this.error="Enter values";return;}this.result=amt*rate;this.resultText=amt+" "+this.from+" = "+this.result.toFixed(2)+" "+this.to;this.steps=[{title:"Amount",text:amt+" "+this.from},{title:"Rate",text:"1 "+this.from+" = "+rate+" "+this.to},{title:"Result",text:this.result.toFixed(2)+" "+this.to},{title:"Inverse",text:"1 "+this.to+" = "+(1/rate).toFixed(4)+" "+this.from}]; }
    };
}
</script>
@endsection