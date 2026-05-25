@extends('layouts.app')
@section('title', 'Boyle\'s Law Calculator')
@section('meta_description', 'Calculate pressure or volume using Boyle\'s law (constant temperature).')
@section('canonical', config('site.url') . '/chemistry/boyles-law-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Boyle\'s Law Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Boyle's Law Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Boyle's Law Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate pressure or volume using Boyle's law (constant temperature).</p>
    <div x-data="boylesLawCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Initial Pressure P₁ (atm)</label>
                <input type="number" x-model.number="P1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Initial Volume V₁ (L)</label>
                <input type="number" x-model.number="V1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Final Pressure P₂ (atm)</label>
                <input type="number" x-model.number="P2" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Final Volume V₂ (L)</label>
                <input type="number" x-model.number="V2" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="6">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Boyle's Law Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Boyle's law: at constant temperature, pressure and volume are inversely proportional. Doubling pressure halves volume.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$P_1V_1 = P_2V_2$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function boylesLawCalculator() {
    return {
        P1: '', V1: '', P2: '', V2: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let P1=this.P1?parseFloat(this.P1):null,V1=this.V1?parseFloat(this.V1):null,P2=this.P2?parseFloat(this.P2):null,V2=this.V2?parseFloat(this.V2):null;if(!P1&&!P2||!V1&&!V2){this.error="Need 3 of 4 values";return;}if(P2===null&&P1&&V1&&V2){this.result=P1*V1/V2;this.resultText="P₂ = "+this.result.toFixed(4)+" atm";}else if(V2===null&&P1&&V1&&P2){this.result=P1*V1/P2;this.resultText="V₂ = "+this.result.toFixed(4)+" L";}else if(P1===null&&P2&&V1&&V2){this.result=P2*V2/V1;this.resultText="P₁ = "+this.result.toFixed(4)+" atm";}else{this.result=P1*V1&&P2?P1*V1/P2:0;this.resultText="V₁ = "+this.result.toFixed(4)+" L";}this.steps=[{title:"Boyle's Law",text:"P₁V₁ = P₂V₂ (constant T)"},{title:"Result",text:this.resultText}]; }
    };
}
</script>
@endsection