@extends('layouts.app')
@section('title', 'Number Sequence Calculator')
@section('meta_description', 'Identify and extend number sequences.')
@section('canonical', config('site.url') . '/math/number-sequence-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Number Sequence Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Number Sequence Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Number Sequence Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Identify and extend number sequences.</p>
    <div x-data="numberSequenceCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sequence (comma-separated)</label>
                <input type="number" x-model.number="seq" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2,5,8,11,14">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Number Sequence Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Common sequences include arithmetic (constant difference), geometric (constant ratio), and quadratic (constant second difference).</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$a_n = a_1 + (n-1)d \text{ or } a_n = a_1 \cdot r^{n-1}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function numberSequenceCalculator() {
    return {
        seq: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let nums=String(this.seq).split(",").map(Number).filter(n=>!isNaN(n));if(nums.length<3){this.error="Enter at least 3 numbers";return;}let diffs=[];for(let i=1;i<nums.length;i++)diffs.push(nums[i]-nums[i-1]);let isArith=diffs.every(d=>Math.abs(d-diffs[0])<1e-10);let ratios=[];for(let i=1;i<nums.length;i++)ratios.push(nums[i]/nums[i-1]);let isGeom=nums[0]!==0&&ratios.every(r=>Math.abs(r-ratios[0])<1e-10);if(isArith){let d=diffs[0];let next=nums[nums.length-1]+d;this.result=next;this.resultText="Arithmetic sequence (d="+d+"), next: "+next;this.steps=[{title:"Common difference",text:"d = "+d},{title:"Next 3 terms",text:[1,2,3].map(i=>nums[nums.length-1]+i*d).join(", ")}];}else if(isGeom){let r=ratios[0];let next=nums[nums.length-1]*r;this.result=next;this.resultText="Geometric sequence (r="+r.toFixed(4)+"), next: "+next.toFixed(4);this.steps=[{title:"Common ratio",text:"r = "+r.toFixed(6)},{title:"Next 3 terms",text:[1,2,3].map(i=>(nums[nums.length-1]*Math.pow(r,i)).toFixed(4)).join(", ")}];}else{let secondDiffs=[];for(let i=1;i<diffs.length;i++)secondDiffs.push(diffs[i]-diffs[i-1]);this.result=0;this.resultText="Not a simple arithmetic or geometric sequence";this.steps=[{title:"First differences",text:diffs.join(", ")},{title:"Second differences",text:secondDiffs.join(", ")}];} }
    };
}
</script>
@endsection