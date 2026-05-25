@extends('layouts.app')
@section('title', 'Gamma Function Calculator')
@section('meta_description', 'Calculate the gamma function Γ(n).')
@section('canonical', config('site.url') . '/math/gamma-function-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Gamma Function Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Gamma Function Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Gamma Function Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the gamma function Γ(n).</p>
    <div x-data="gammaFunctionCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Value n</label>
                <input type="number" x-model.number="n" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="5.5">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Gamma Function Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The gamma function extends factorials to real numbers: Γ(n) = (n-1)! for positive integers. Γ(1/2) = √π.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$\Gamma(n) = (n-1)!$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function gammaFunctionCalculator() {
    return {
        n: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let n=parseFloat(this.n);if(isNaN(n)||n<=0){this.error="Enter positive number";return;}function gamma(z){if(z<0.5)return Math.PI/(Math.sin(Math.PI*z)*gamma(1-z));z-=1;let g=7;let C=[0.99999999999980993,676.5203681218851,-1259.1392167224028,771.32342877765313,-176.61502916214059,12.507343278686905,-0.13857109526572012,9.9843695780195716e-6,1.5056327351493116e-7];let x=C[0];for(let i=1;i<g+2;i++)x+=C[i]/(z+i);let t=z+g+0.5;return Math.sqrt(2*Math.PI)*Math.pow(t,z+0.5)*Math.exp(-t)*x;}let val=gamma(n);this.result=val;this.resultText="Γ("+n+") = "+val.toFixed(8);this.steps=[{title:"Γ("+n+")",text:val.toFixed(10)},{title:"For integers",text:"Γ(n) = (n-1)!"},{title:"Γ(0.5)",text:"= √π ≈ "+gamma(0.5).toFixed(8)}]; }
    };
}
</script>
@endsection