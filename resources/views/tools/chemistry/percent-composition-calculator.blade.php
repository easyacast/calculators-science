@extends('layouts.app')
@section('title', 'Percent Composition Calculator')
@section('meta_description', 'Calculate the percent composition of elements in a compound.')
@section('canonical', config('site.url') . '/chemistry/percent-composition-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Percent Composition Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Percent Composition Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Percent Composition Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the percent composition of elements in a compound.</p>
    <div x-data="percentCompositionCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Formula</label>
                <input type="number" x-model.number="formula" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="H2O">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Percent Composition Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Percent composition shows what fraction of a compound's mass comes from each element.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$\% = \frac{n \times M_{element}}{M_{compound}} \times 100$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function percentCompositionCalculator() {
    return {
        formula: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let f=String(this.formula).trim();let masses={H:1.008,C:12.011,N:14.007,O:15.999,S:32.065,Na:22.99,Cl:35.453,Ca:40.078,Fe:55.845,P:30.974,K:39.098,Mg:24.305};let elements={};let total=0;let regex=/([A-Z][a-z]?)(\d*)/g,m;while((m=regex.exec(f))!==null){if(!m[1])continue;let el=m[1],n=parseInt(m[2])||1;if(!masses[el]){this.error="Unknown element: "+el;return;}elements[el]=(elements[el]||0)+masses[el]*n;total+=masses[el]*n;}if(!total){this.error="Enter formula";return;}this.result=total;this.resultText="Molar mass: "+total.toFixed(3)+" g/mol";this.steps=Object.entries(elements).map(([el,mass])=>({title:el,text:mass.toFixed(3)+" g/mol = "+(mass/total*100).toFixed(2)+"%"})); }
    };
}
</script>
@endsection