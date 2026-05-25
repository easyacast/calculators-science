@extends('layouts.app')
@section('title', 'Ideal Gas Law Calculator (Physics)')
@section('meta_description', 'Calculate pressure, volume, temperature, or amount using PV = nRT.')
@section('canonical', config('site.url') . '/physics/ideal-gas-law-physics-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Ideal Gas Law Calculator (Physics)","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/physics" class="hover:text-indigo-600">Physics</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Ideal Gas Law Calculator (Physics)</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Ideal Gas Law Calculator (Physics)</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate pressure, volume, temperature, or amount using PV = nRT.</p>
    <div x-data="idealGasLawPhysicsCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pressure P (Pa)</label>
                <input type="number" x-model.number="P" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="101325">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Volume V (m³)</label>
                <input type="number" x-model.number="V" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="0.0224">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Amount n (mol)</label>
                <input type="number" x-model.number="n" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Temperature T (K)</label>
                <input type="number" x-model.number="T" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="273.15">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-amber-600 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200">
                <div class="text-xs font-medium text-amber-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Understanding Ideal Gas Law Calculator (Physics)</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The ideal gas law relates pressure, volume, temperature, and amount of gas. It is an equation of state for an ideal gas.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$PV = nRT$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function idealGasLawPhysicsCalculator() {
    return {
        P: '', V: '', n: '', T: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let P=this.P?parseFloat(this.P):null,V=this.V?parseFloat(this.V):null,n=this.n?parseFloat(this.n):null,T=this.T?parseFloat(this.T):null;let R=8.314;let cnt=(P!==null?1:0)+(V!==null?1:0)+(n!==null?1:0)+(T!==null?1:0);if(cnt<3){this.error="Enter at least 3 values";return;}if(P===null){this.result=n*R*T/V;this.resultText="P = "+this.result.toFixed(2)+" Pa";}else if(V===null){this.result=n*R*T/P;this.resultText="V = "+this.result.toFixed(6)+" m³";}else if(n===null){this.result=P*V/(R*T);this.resultText="n = "+this.result.toFixed(6)+" mol";}else{this.result=P*V/(n*R);this.resultText="T = "+this.result.toFixed(2)+" K";}this.steps=[{title:"PV = nRT",text:"R = 8.314 J/(mol·K)"},{title:"Result",text:this.resultText}]; }
    };
}
</script>
@endsection