@extends('layouts.app')
@section('title', 'Interquartile Range (IQR) Calculator')
@section('meta_description', 'Calculate Q1, Q3, and IQR of a dataset.')
@section('canonical', config('site.url') . '/math/interquartile-range-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Interquartile Range (IQR) Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Interquartile Range (IQR) Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Interquartile Range (IQR) Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate Q1, Q3, and IQR of a dataset.</p>
    <div x-data="interquartileRangeCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Numbers (comma-separated)</label>
                <input type="number" x-model.number="data" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2,4,6,8,10,12,14">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Interquartile Range (IQR) Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The IQR measures the spread of the middle 50% of data. Values beyond 1.5×IQR from the quartiles are considered outliers.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$IQR = Q_3 - Q_1$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function interquartileRangeCalculator() {
    return {
        data: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let nums=String(this.data).split(",").map(Number).filter(n=>!isNaN(n)).sort((a,b)=>a-b);if(nums.length<4){this.error="Need at least 4 values";return;}function quartile(arr,q){let pos=(arr.length-1)*q;let base=Math.floor(pos);let frac=pos-base;return arr[base]+(arr[base+1]!==undefined?(arr[base+1]-arr[base])*frac:0);}let Q1=quartile(nums,0.25),Q2=quartile(nums,0.5),Q3=quartile(nums,0.75);this.result=Q3-Q1;this.resultText="IQR = "+this.result.toFixed(4);this.steps=[{title:"Q1 (25th percentile)",text:Q1.toFixed(4)},{title:"Q2 (median)",text:Q2.toFixed(4)},{title:"Q3 (75th percentile)",text:Q3.toFixed(4)},{title:"IQR = Q3 - Q1",text:this.result.toFixed(4)},{title:"Outlier bounds",text:(Q1-1.5*this.result).toFixed(2)+" to "+(Q3+1.5*this.result).toFixed(2)}]; }
    };
}
</script>
@endsection