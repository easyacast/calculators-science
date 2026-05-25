@extends('layouts.app')
@section('title', 'Point to Line Distance Calculator')
@section('meta_description', 'Calculate the perpendicular distance from a point to a line.')
@section('canonical', config('site.url') . '/coordinate-geometry/point-to-line-distance-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Point to Line Distance Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/coordinate-geometry" class="hover:text-indigo-600">Coordinate Geometry</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Point to Line Distance Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Point to Line Distance Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the perpendicular distance from a point to a line.</p>
    <div x-data="pointToLineDistanceCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">A (line: Ax+By+C=0)</label>
                <input type="number" x-model.number="A" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">B</label>
                <input type="number" x-model.number="B" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="4">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">C</label>
                <input type="number" x-model.number="C" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="-5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Point x₀</label>
                <input type="number" x-model.number="x0" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Point y₀</label>
                <input type="number" x-model.number="y0" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="3">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-cyan-600 text-white font-medium rounded-xl hover:bg-cyan-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-cyan-50 to-orange-50 rounded-xl p-5 border border-cyan-200">
                <div class="text-xs font-medium text-cyan-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-cyan-100 text-cyan-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Point to Line Distance Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The shortest distance from a point to a line is the perpendicular distance. Used in optimization and geometry.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$d = \frac{|Ax_0 + By_0 + C|}{\sqrt{A^2 + B^2}}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function pointToLineDistanceCalculator() {
    return {
        A: '', B: '', C: '', x0: '', y0: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let A=parseFloat(this.A),B=parseFloat(this.B),C=parseFloat(this.C),x0=parseFloat(this.x0),y0=parseFloat(this.y0);if([A,B,C,x0,y0].some(isNaN)){this.error="Enter values";return;}if(A===0&&B===0){this.error="A and B cannot both be 0";return;}this.result=Math.abs(A*x0+B*y0+C)/Math.sqrt(A*A+B*B);this.resultText="Distance = "+this.result.toFixed(6);this.steps=[{title:"|Ax₀+By₀+C|",text:Math.abs(A*x0+B*y0+C)},{title:"√(A²+B²)",text:Math.sqrt(A*A+B*B).toFixed(4)},{title:"Distance",text:this.result.toFixed(6)}]; }
    };
}
</script>
@endsection