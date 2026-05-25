@extends('layouts.app')
@section('title', 'Empirical Formula Calculator')
@section('meta_description', 'Determine the empirical formula from percent composition.')
@section('canonical', config('site.url') . '/chemistry/empirical-formula-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Empirical Formula Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Empirical Formula Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Empirical Formula Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Determine the empirical formula from percent composition.</p>
    <div x-data="empiricalFormulaCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Carbon %</label>
                <input type="number" x-model.number="C" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="40.0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hydrogen %</label>
                <input type="number" x-model.number="H" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="6.7">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Oxygen %</label>
                <input type="number" x-model.number="O" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="53.3">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Empirical Formula Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The empirical formula gives the simplest whole-number ratio of atoms. Convert % to grams, then to moles, then find the ratio.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$Divide moles by smallest to get ratio$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function empiricalFormulaCalculator() {
    return {
        C: '', H: '', O: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let C=parseFloat(this.C)||0,H=parseFloat(this.H)||0,O=parseFloat(this.O)||0;if(C+H+O<1){this.error="Enter percentages";return;}let molC=C/12.011,molH=H/1.008,molO=O/15.999;let min=Math.min(...[molC,molH,molO].filter(x=>x>0));if(min===0){this.error="Invalid percentages";return;}let rC=Math.round(molC/min),rH=Math.round(molH/min),rO=Math.round(molO/min);let formula="";if(rC>0)formula+="C"+(rC>1?rC:"");if(rH>0)formula+="H"+(rH>1?rH:"");if(rO>0)formula+="O"+(rO>1?rO:"");this.result=1;this.resultText="Empirical formula: "+formula;this.steps=[{title:"Moles",text:"C:"+molC.toFixed(4)+", H:"+molH.toFixed(4)+", O:"+molO.toFixed(4)},{title:"Ratios (÷ smallest)",text:"C:"+rC+", H:"+rH+", O:"+rO},{title:"Formula",text:formula}]; }
    };
}
</script>
@endsection