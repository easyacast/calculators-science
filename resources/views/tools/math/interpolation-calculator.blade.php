@extends('layouts.app')
@section('title', 'Linear Interpolation Calculator')
@section('meta_description', 'Interpolate between two known data points.')
@section('canonical', config('site.url') . '/math/interpolation-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Linear Interpolation Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Linear Interpolation Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Linear Interpolation Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Interpolate between two known data points.</p>
    <div x-data="interpolationCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">x₁</label>
                <input type="number" x-model.number="x1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">y₁</label>
                <input type="number" x-model.number="y1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">x₂</label>
                <input type="number" x-model.number="x2" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="30">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">y₂</label>
                <input type="number" x-model.number="y2" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="60">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Target x</label>
                <input type="number" x-model.number="x" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="20">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Linear Interpolation Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Linear interpolation estimates a value between two known points by assuming a straight-line relationship.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$y = y_1 + \frac{(x - x_1)(y_2 - y_1)}{x_2 - x_1}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function interpolationCalculator() {
    return {
        x1: '', y1: '', x2: '', y2: '', x: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let x1=parseFloat(this.x1),y1=parseFloat(this.y1),x2=parseFloat(this.x2),y2=parseFloat(this.y2),x=parseFloat(this.x);if([x1,y1,x2,y2,x].some(isNaN)){this.error="Enter all values";return;}if(x2===x1){this.error="x₁ and x₂ must differ";return;}this.result=y1+(x-x1)*(y2-y1)/(x2-x1);this.resultText="y("+x+") = "+this.result.toFixed(6);this.steps=[{title:"Points",text:"("+x1+","+y1+") and ("+x2+","+y2+")"},{title:"Slope",text:((y2-y1)/(x2-x1)).toFixed(6)},{title:"y("+x+")",text:this.result.toFixed(6)}]; }
    };
}
</script>
@endsection