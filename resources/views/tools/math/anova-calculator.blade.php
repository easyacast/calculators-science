@extends('layouts.app')
@section('title', 'One-Way ANOVA Calculator')
@section('meta_description', 'Perform one-way ANOVA on multiple groups.')
@section('canonical', config('site.url') . '/math/anova-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"One-Way ANOVA Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">One-Way ANOVA Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">One-Way ANOVA Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Perform one-way ANOVA on multiple groups.</p>
    <div x-data="anovaCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Group 1 (comma-separated)</label>
                <input type="number" x-model.number="g1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10,12,14,11">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Group 2 (comma-separated)</label>
                <input type="number" x-model.number="g2" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="15,17,16,18">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Group 3 (comma-separated)</label>
                <input type="number" x-model.number="g3" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="20,22,21,19">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About One-Way ANOVA Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">ANOVA (Analysis of Variance) tests whether means of three or more groups are significantly different. F > critical value suggests significant differences.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$F = \frac{MS_{between}}{MS_{within}}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function anovaCalculator() {
    return {
        g1: '', g2: '', g3: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let groups=[String(this.g1).split(",").map(Number),String(this.g2).split(",").map(Number),String(this.g3).split(",").map(Number)].filter(g=>g.length>0&&!g.some(isNaN));if(groups.length<2){this.error="Need at least 2 groups";return;}let k=groups.length;let N=groups.reduce((s,g)=>s+g.length,0);let grandMean=groups.flat().reduce((a,b)=>a+b)/N;let SSB=groups.reduce((s,g)=>s+g.length*(g.reduce((a,b)=>a+b)/g.length-grandMean)**2,0);let SSW=groups.reduce((s,g)=>{let m=g.reduce((a,b)=>a+b)/g.length;return s+g.reduce((ss,x)=>ss+(x-m)**2,0);},0);let dfB=k-1,dfW=N-k;let MSB=SSB/dfB,MSW=SSW/dfW;let F=MSB/MSW;this.result=F;this.resultText="F = "+F.toFixed(4);this.steps=[{title:"Grand mean",text:grandMean.toFixed(4)},{title:"SSbetween",text:SSB.toFixed(4)},{title:"SSwithin",text:SSW.toFixed(4)},{title:"F = MSB/MSW",text:MSB.toFixed(4)+"/"+MSW.toFixed(4)+" = "+F.toFixed(4)},{title:"df",text:"("+dfB+", "+dfW+")"}]; }
    };
}
</script>
@endsection