@extends('layouts.app')
@section('title', 'Ohm\'s Law Calculator')
@section('meta_description', 'Calculate voltage, current, or resistance.')
@section('canonical', config('site.url') . '/engineering/ohms-law-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Ohm\'s Law Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Ohm's Law Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Ohm's Law Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate voltage, current, or resistance.</p>
    <div x-data="ohmsLawCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Voltage V (V)</label>
                <input type="number" x-model.number="V" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-500" placeholder="">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current I (A)</label>
                <input type="number" x-model.number="I" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Resistance R (Ω)</label>
                <input type="number" x-model.number="R" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-slate-500" placeholder="5">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Ohm's Law Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Ohm's law: V = IR. Power P = VI = I²R = V²/R. Fundamental to all electrical circuits.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$V = IR$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function ohmsLawCalculator() {
    return {
        V: '', I: '', R: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let V=this.V?parseFloat(this.V):null,I=this.I?parseFloat(this.I):null,R=this.R?parseFloat(this.R):null;let cnt=(V!==null?1:0)+(I!==null?1:0)+(R!==null?1:0);if(cnt<2){this.error="Enter at least 2 values";return;}if(V===null){this.result=I*R;this.resultText="V = "+this.result.toFixed(4)+" V";}else if(I===null){if(R===0){this.error="R cannot be 0";return;}this.result=V/R;this.resultText="I = "+this.result.toFixed(4)+" A";}else{if(I===0){this.error="I cannot be 0";return;}this.result=V/I;this.resultText="R = "+this.result.toFixed(4)+" Ω";}let power=(V||this.result)*(I||this.result);this.steps=[{title:"V = IR",text:this.resultText},{title:"Power P = VI",text:power.toFixed(4)+" W"}]; }
    };
}
</script>
@endsection