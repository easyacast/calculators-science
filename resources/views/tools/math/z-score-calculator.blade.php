@extends('layouts.app')
@section('title', 'Z-Score Calculator')
@section('meta_description', 'Calculate the z-score (standard score) of a data point.')
@section('canonical', config('site.url') . '/math/z-score-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Z-Score Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Z-Score Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Z-Score Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the z-score (standard score) of a data point.</p>
    <div x-data="zScoreCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Data Point x</label>
                <input type="number" x-model.number="x" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="85">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mean μ</label>
                <input type="number" x-model.number="mu" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="75">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Z-Score Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">A z-score tells how many standard deviations a value is from the mean. z = 0 means at the mean, z = ±2 means unusual.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$z = \frac{x - \mu}{\sigma}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function zScoreCalculator() {
    return {
        x: '', mu: '', sigma: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let x=parseFloat(this.x),mu=parseFloat(this.mu),sigma=parseFloat(this.sigma);if(isNaN(x)||isNaN(mu)||!sigma||sigma===0){this.error="Enter valid values (σ≠0)";return;}this.result=(x-mu)/sigma;this.resultText="z = "+this.result.toFixed(4);this.steps=[{title:"Given",text:"x="+x+", μ="+mu+", σ="+sigma},{title:"z = (x-μ)/σ",text:"("+x+"-"+mu+")/"+sigma+" = "+this.result.toFixed(4)},{title:"Interpretation",text:Math.abs(this.result).toFixed(2)+" standard deviations "+(this.result>=0?"above":"below")+" the mean"}]; }
    };
}
</script>
@endsection