@extends('layouts.app')
@section('title', 'Quadratic Formula Calculator')
@section('meta_description', 'Solve quadratic equations ax² + bx + c = 0 using the quadratic formula.')
@section('canonical', config('site.url') . '/math/quadratic-formula-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Quadratic Formula Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Quadratic Formula Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Quadratic Formula Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Solve quadratic equations ax² + bx + c = 0 using the quadratic formula.</p>
    <div x-data="quadraticFormulaCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coefficient a</label>
                <input type="number" x-model.number="a" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coefficient b</label>
                <input type="number" x-model.number="b" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="-5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coefficient c</label>
                <input type="number" x-model.number="c" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="6">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Quadratic Formula Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The quadratic formula gives the roots of any quadratic equation. The discriminant determines the nature of the roots.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$x = \frac{-b \pm \sqrt{b^2-4ac}}{2a}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function quadraticFormulaCalculator() {
    return {
        a: '', b: '', c: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let a=parseFloat(this.a),b=parseFloat(this.b),c=parseFloat(this.c);if(!a){this.error="a cannot be 0";return;}let disc=b*b-4*a*c;let steps=[{title:"Discriminant",text:"Δ = b²-4ac = "+b+"²-4×"+a+"×"+c+" = "+disc}];if(disc>0){let x1=(-b+Math.sqrt(disc))/(2*a),x2=(-b-Math.sqrt(disc))/(2*a);this.result=x1;this.resultText="x₁ = "+x1.toFixed(6)+", x₂ = "+x2.toFixed(6);steps.push({title:"Two real roots",text:"x₁ = "+x1.toFixed(6)+", x₂ = "+x2.toFixed(6)});}else if(disc===0){let x1=-b/(2*a);this.result=x1;this.resultText="x = "+x1.toFixed(6)+" (repeated root)";steps.push({title:"One repeated root",text:"x = "+x1.toFixed(6)});}else{let re=-b/(2*a),im=Math.sqrt(-disc)/(2*a);this.result=re;this.resultText="x = "+re.toFixed(4)+" ± "+im.toFixed(4)+"i";steps.push({title:"Complex roots",text:re.toFixed(4)+" ± "+im.toFixed(4)+"i"});}this.steps=steps; }
    };
}
</script>
@endsection