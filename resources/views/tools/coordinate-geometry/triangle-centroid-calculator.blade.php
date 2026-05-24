@extends('layouts.app')
@section('title', 'Triangle Centroid Calculator')
@section('meta_description', 'Find the centroid of a triangle.')
@section('canonical', config('site.url') . '/coordinate-geometry/triangle-centroid-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Triangle Centroid Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Triangle Centroid Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Triangle Centroid Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Find the centroid of a triangle.</p>
    <div x-data="triangleCentroidCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">x₁</label>
                <input type="number" x-model.number="x1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">y₁</label>
                <input type="number" x-model.number="y1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">x₂</label>
                <input type="number" x-model.number="x2" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="6">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">y₂</label>
                <input type="number" x-model.number="y2" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">x₃</label>
                <input type="number" x-model.number="x3" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">y₃</label>
                <input type="number" x-model.number="y3" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="4">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Triangle Centroid Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The centroid is the intersection of medians — the average of all three vertices. It is the center of mass for a uniform triangle.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$G = \left(\frac{x_1+x_2+x_3}{3}, \frac{y_1+y_2+y_3}{3}\right)$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function triangleCentroidCalculator() {
    return {
        x1: '', y1: '', x2: '', y2: '', x3: '', y3: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let x1=parseFloat(this.x1),y1=parseFloat(this.y1),x2=parseFloat(this.x2),y2=parseFloat(this.y2),x3=parseFloat(this.x3),y3=parseFloat(this.y3);if([x1,y1,x2,y2,x3,y3].some(isNaN)){this.error="Enter all coordinates";return;}let gx=(x1+x2+x3)/3,gy=(y1+y2+y3)/3;let area=Math.abs(x1*(y2-y3)+x2*(y3-y1)+x3*(y1-y2))/2;this.result=area;this.resultText="Centroid: ("+gx.toFixed(4)+", "+gy.toFixed(4)+")";this.steps=[{title:"Centroid",text:"("+gx.toFixed(4)+", "+gy.toFixed(4)+")"},{title:"Area",text:area.toFixed(4)+" sq units"},{title:"Perimeter",text:(Math.sqrt((x2-x1)**2+(y2-y1)**2)+Math.sqrt((x3-x2)**2+(y3-y2)**2)+Math.sqrt((x1-x3)**2+(y1-y3)**2)).toFixed(4)}]; }
    };
}
</script>
@endsection