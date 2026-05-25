@extends('layouts.app')
@section('title', 'Compound Interest Calculator')
@section('meta_description', 'Calculate compound interest with different compounding frequencies.')
@section('canonical', config('site.url') . '/math/compound-interest-formula-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Compound Interest Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/math" class="hover:text-indigo-600">Mathematics</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Compound Interest Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Compound Interest Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate compound interest with different compounding frequencies.</p>
    <div x-data="compoundInterestFormulaCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Principal P</label>
                <input type="number" x-model.number="P" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Annual Rate r (decimal)</label>
                <input type="number" x-model.number="r" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="0.05">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Compounds per Year</label>
                <input type="number" x-model.number="n" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="12">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Years</label>
                <input type="number" x-model.number="t" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-indigo-50 to-orange-50 rounded-xl p-5 border border-indigo-200">
                <div class="text-xs font-medium text-indigo-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Compound Interest Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Compound interest earns interest on interest. More frequent compounding yields higher returns. Continuous compounding uses A = Pe^(rt).</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$A = P\left(1 + \frac{r}{n}\right)^{nt}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function compoundInterestFormulaCalculator() {
    return {
        P: '', r: '', n: '', t: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let P=parseFloat(this.P),r=parseFloat(this.r),n=parseFloat(this.n),t=parseFloat(this.t);if(!P||isNaN(r)||!n||!t){this.error="Enter valid values";return;}this.result=P*Math.pow(1+r/n,n*t);let interest=this.result-P;let cont=P*Math.exp(r*t);this.resultText="A = "+this.result.toFixed(2);this.steps=[{title:"Formula",text:"A = P(1+r/n)^(nt)"},{title:"Final amount",text:this.result.toFixed(2)},{title:"Interest earned",text:interest.toFixed(2)},{title:"Continuous compounding",text:cont.toFixed(2)}]; }
    };
}
</script>
@endsection