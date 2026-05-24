@extends('layouts.app')
@section('title', 'Savings Goal Calculator')
@section('meta_description', 'Calculate how long to reach a savings goal with regular deposits.')
@section('canonical', config('site.url') . '/finance/savings-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Savings Goal Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Savings Goal Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Savings Goal Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate how long to reach a savings goal with regular deposits.</p>
    <div x-data="savingsCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Savings Goal</label>
                <input type="number" x-model.number="goal" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="50000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Deposit</label>
                <input type="number" x-model.number="monthly" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Annual Return (%)</label>
                <input type="number" x-model.number="rate" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="5">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Savings Goal Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Regular saving with compound returns accelerates wealth building. The earlier you start, the more compound interest helps.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$FV = PMT \times \frac{(1+r)^n - 1}{r}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function savingsCalculator() {
    return {
        goal: '', monthly: '', rate: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let goal=parseFloat(this.goal),pmt=parseFloat(this.monthly),rate=parseFloat(this.rate)/100/12;if(!goal||!pmt||isNaN(rate)){this.error="Enter values";return;}if(rate===0){this.result=goal/pmt;this.resultText=Math.ceil(this.result)+" months";this.steps=[{title:"Months",text:Math.ceil(this.result)},{title:"Years",text:(this.result/12).toFixed(1)}];return;}let n=Math.log(goal*rate/pmt+1)/Math.log(1+rate);this.result=n;let months=Math.ceil(n);let years=(n/12).toFixed(1);this.resultText=months+" months ("+years+" years)";this.steps=[{title:"Months to goal",text:months},{title:"Years",text:years},{title:"Total deposited",text:"$"+(pmt*months).toLocaleString()},{title:"Interest earned",text:"$"+(goal-pmt*months).toFixed(2)}]; }
    };
}
</script>
@endsection