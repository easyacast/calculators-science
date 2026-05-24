@extends('layouts.app')
@section('title', 'Numerical Derivative Calculator')
@section('meta_description', 'Approximate the derivative of a function at a point.')
@section('canonical', config('site.url') . '/math/derivative-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Numerical Derivative Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Numerical Derivative Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Numerical Derivative Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Approximate the derivative of a function at a point.</p>
    <div x-data="derivativeCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Function f(x) (use x)</label>
                <input type="number" x-model.number="expr" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="x*x*x">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Point x₀</label>
                <input type="number" x-model.number="x0" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Step size h</label>
                <input type="number" x-model.number="h" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="0.0001">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Numerical Derivative Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The derivative measures the instantaneous rate of change. This calculator uses the central difference method for numerical approximation.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$f'(x) \approx \frac{f(x+h) - f(x-h)}{2h}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function derivativeCalculator() {
    return {
        expr: '', x0: '', h: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let x0=parseFloat(this.x0),h=parseFloat(this.h)||0.0001;try{let f=new Function("x","return "+this.expr);let fp=(f(x0+h)-f(x0-h))/(2*h);let fpp=(f(x0+h)-2*f(x0)+f(x0-h))/(h*h);this.result=fp;this.resultText="f'("+x0+") ≈ "+fp.toFixed(8);this.steps=[{title:"f(x₀)",text:f(x0).toFixed(8)},{title:"f'(x₀) ≈ (f(x₀+h)-f(x₀-h))/(2h)",text:fp.toFixed(8)},{title:"f''(x₀) ≈ ",text:fpp.toFixed(8)}];}catch(e){this.error="Invalid function expression";} }
    };
}
</script>
@endsection