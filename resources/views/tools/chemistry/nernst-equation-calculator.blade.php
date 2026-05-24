@extends('layouts.app')
@section('title', 'Nernst Equation Calculator')
@section('meta_description', 'Calculate cell potential under non-standard conditions.')
@section('canonical', config('site.url') . '/chemistry/nernst-equation-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Nernst Equation Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/chemistry" class="hover:text-indigo-600">Chemistry</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Nernst Equation Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Nernst Equation Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate cell potential under non-standard conditions.</p>
    <div x-data="nernstEquationCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Standard Cell Potential E° (V)</label>
                <input type="number" x-model.number="E0" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="1.10">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Electrons Transferred n</label>
                <input type="number" x-model.number="n" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reaction Quotient Q</label>
                <input type="number" x-model.number="Q" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="0.01">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-green-50 to-orange-50 rounded-xl p-5 border border-green-200">
                <div class="text-xs font-medium text-green-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Nernst Equation Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The Nernst equation adjusts standard cell potential for non-standard conditions. At equilibrium, E = 0 and Q = K.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$E = E^\circ - \frac{RT}{nF}\ln Q$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function nernstEquationCalculator() {
    return {
        E0: '', n: '', Q: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let E0=parseFloat(this.E0),n=parseFloat(this.n),Q=parseFloat(this.Q);if(isNaN(E0)||!n||!Q||Q<=0){this.error="Enter valid values";return;}let T=298;let R=8.314;let F=96485;this.result=E0-(R*T)/(n*F)*Math.log(Q);this.resultText="E = "+this.result.toFixed(4)+" V";this.steps=[{title:"Nernst equation",text:"E = E° - (RT/nF)lnQ"},{title:"At 298 K",text:"E = "+E0+" - (0.02569/"+n+")×ln("+Q+")"},{title:"E",text:this.result.toFixed(4)+" V"},{title:"Simplified form",text:"E = "+E0+" - "+(0.05916/n).toFixed(4)+"log("+Q+")"}]; }
    };
}
</script>
@endsection