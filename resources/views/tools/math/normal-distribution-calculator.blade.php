@extends('layouts.app')
@section('title', 'Normal Distribution Calculator')
@section('meta_description', 'Calculate probabilities for the normal distribution using z-scores.')
@section('canonical', config('site.url') . '/math/normal-distribution-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Normal Distribution Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Normal Distribution Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Normal Distribution Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate probabilities for the normal distribution using z-scores.</p>
    <div x-data="normalDistributionCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Value x</label>
                <input type="number" x-model.number="x" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="85">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mean μ</label>
                <input type="number" x-model.number="mu" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="70">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Std Dev σ</label>
                <input type="number" x-model.number="sigma" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Normal Distribution Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The normal distribution is the bell curve. About 68% of data falls within 1σ, 95% within 2σ, 99.7% within 3σ of the mean.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$P(X \leq x) = \Phi\left(\frac{x-\mu}{\sigma}\right)$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function normalDistributionCalculator() {
    return {
        x: '', mu: '', sigma: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let x=parseFloat(this.x),mu=parseFloat(this.mu),sigma=parseFloat(this.sigma);if(isNaN(x)||isNaN(mu)||!sigma||sigma<=0){this.error="Enter valid values";return;}let z=(x-mu)/sigma;function normCDF(z){let t=1/(1+0.2316419*Math.abs(z));let d=0.3989422804*Math.exp(-z*z/2);let p=d*t*(0.3193815+t*(-0.3565638+t*(1.781478+t*(-1.821256+t*1.330274))));return z>0?1-p:p;}let p=normCDF(z);this.result=p;this.resultText="P(X ≤ "+x+") = "+p.toFixed(6);this.steps=[{title:"Z-score",text:"z = ("+x+"-"+mu+")/"+sigma+" = "+z.toFixed(4)},{title:"P(X ≤ x)",text:p.toFixed(6)+" = "+(p*100).toFixed(2)+"%"},{title:"P(X > x)",text:(1-p).toFixed(6)}]; }
    };
}
</script>
@endsection