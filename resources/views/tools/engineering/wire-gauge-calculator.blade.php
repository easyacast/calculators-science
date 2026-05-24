@extends('layouts.app')
@section('title', 'Wire Gauge Calculator')
@section('meta_description', 'Calculate wire resistance and current capacity by AWG.')
@section('canonical', config('site.url') . '/engineering/wire-gauge-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Wire Gauge Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/engineering" class="hover:text-indigo-600">Engineering</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Wire Gauge Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Wire Gauge Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate wire resistance and current capacity by AWG.</p>
    <div x-data="wireGaugeCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">AWG Size</label>
                <input type="number" x-model.number="awg" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-500" placeholder="12">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Length (meters)</label>
                <input type="number" x-model.number="length" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-500" placeholder="30">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-slate-600 text-white font-medium rounded-xl hover:bg-slate-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-slate-50 to-orange-50 rounded-xl p-5 border border-slate-200">
                <div class="text-xs font-medium text-slate-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Wire Gauge Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">AWG: lower number = thicker wire. AWG 12 is common for 20A circuits. Resistance depends on length and cross-section.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$R = \frac{\rho L}{A}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function wireGaugeCalculator() {
    return {
        awg: '', length: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let awg=parseInt(this.awg),len=parseFloat(this.length);if(isNaN(awg)||!len){this.error="Enter values";return;}let dia=0.127*Math.pow(92,(36-awg)/39);let area=Math.PI*(dia/2)**2;let rho=1.68e-8;this.result=rho*len/(area*1e-6);let amps=[null,null,null,null,null,null,null,null,40,35,30,25,20,15,null,null,null,null,null,null];let maxA=amps[awg]||"N/A";this.resultText="R = "+this.result.toFixed(4)+" Ω";this.steps=[{title:"Diameter",text:dia.toFixed(3)+" mm"},{title:"Resistance",text:this.result.toFixed(4)+" Ω"},{title:"Max current (typical)",text:maxA+" A"},{title:"Voltage drop at 10A",text:(this.result*10).toFixed(2)+" V"}]; }
    };
}
</script>
@endsection