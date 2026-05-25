@extends('layouts.app')
@section('title', 'Law of Cosines Calculator')
@section('meta_description', 'Find the third side of a triangle using the Law of Cosines.')
@section('canonical', config('site.url') . '/math/law-of-cosines-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Law of Cosines Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Law of Cosines Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Law of Cosines Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Find the third side of a triangle using the Law of Cosines.</p>
    <div x-data="lawOfCosinesCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Side a</label>
                <input type="number" x-model.number="a" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Side b</label>
                <input type="number" x-model.number="b" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="7">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Angle C (degrees)</label>
                <input type="number" x-model.number="C" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="60">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Law of Cosines Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The Law of Cosines generalizes the Pythagorean theorem to any triangle. When C = 90°, it reduces to a² + b² = c².</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$c^2 = a^2 + b^2 - 2ab\cos C$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function lawOfCosinesCalculator() {
    return {
        a: '', b: '', C: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let a=parseFloat(this.a),b=parseFloat(this.b),C=parseFloat(this.C);if(!a||!b||isNaN(C)){this.error="Enter valid values";return;}let Cr=C*Math.PI/180;let c2=a*a+b*b-2*a*b*Math.cos(Cr);if(c2<0){this.error="Invalid triangle";return;}let c=Math.sqrt(c2);let A=Math.acos((b*b+c*c-a*a)/(2*b*c))*180/Math.PI;let B=180-A-C;this.result=c;this.resultText="c = "+c.toFixed(4);this.steps=[{title:"c² = a²+b²-2ab·cosC",text:a+"²+"+b+"²-2×"+a+"×"+b+"×cos("+C+"°) = "+c2.toFixed(4)},{title:"c",text:c.toFixed(4)},{title:"Angle A",text:A.toFixed(2)+"°"},{title:"Angle B",text:B.toFixed(2)+"°"}]; }
    };
}
</script>
@endsection