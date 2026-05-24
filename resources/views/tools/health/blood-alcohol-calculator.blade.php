@extends('layouts.app')
@section('title', 'Blood Alcohol Calculator')
@section('meta_description', 'Estimate BAC using the Widmark formula.')
@section('canonical', config('site.url') . '/health/blood-alcohol-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Blood Alcohol Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/health" class="hover:text-indigo-600">Health</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Blood Alcohol Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Blood Alcohol Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Estimate BAC using the Widmark formula.</p>
    <div x-data="bloodAlcoholCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Number of Standard Drinks</label>
                <input type="number" x-model.number="drinks" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                <input type="number" x-model.number="weight" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="70">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hours Since First Drink</label>
                <input type="number" x-model.number="hours" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gender (1=male, 2=female)</label>
                <input type="number" x-model.number="gender" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="1">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-rose-600 text-white font-medium rounded-xl hover:bg-rose-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-rose-50 to-orange-50 rounded-xl p-5 border border-rose-200">
                <div class="text-xs font-medium text-rose-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Blood Alcohol Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">BAC estimates are approximations. One standard drink = 14g of pure alcohol. The body metabolizes ~0.015% per hour.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$BAC = \frac{A \times 5.14}{W \times r} - 0.015 \times H$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function bloodAlcoholCalculator() {
    return {
        drinks: '', weight: '', hours: '', gender: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let drinks=parseFloat(this.drinks),w=parseFloat(this.weight),hours=parseFloat(this.hours),g=parseInt(this.gender);if(!drinks||!w){this.error="Enter values";return;}let r=g===2?0.55:0.68;let wlb=w*2.20462;let bac=(drinks*14*5.14)/(wlb*r)-0.015*(hours||0);if(bac<0)bac=0;this.result=bac;let level=bac<0.02?"Sober":bac<0.05?"Slight impairment":bac<0.08?"Impaired":"Legally intoxicated";this.resultText="BAC ≈ "+bac.toFixed(3)+"% ("+level+")";this.steps=[{title:"BAC",text:bac.toFixed(3)+"%"},{title:"Status",text:level},{title:"Legal limit",text:"0.08% in most US states"},{title:"Time to 0",text:(bac/0.015).toFixed(1)+" hours"}]; }
    };
}
</script>
@endsection