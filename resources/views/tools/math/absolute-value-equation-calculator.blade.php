@extends('layouts.app')
@section('title', 'Absolute Value Equation Solver')
@section('meta_description', 'Solve equations of the form |ax + b| = c.')
@section('canonical', config('site.url') . '/math/absolute-value-equation-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Absolute Value Equation Solver","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Absolute Value Equation Solver</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Absolute Value Equation Solver</h1>
    <p class="text-lg text-gray-600 mb-8">Solve equations of the form |ax + b| = c.</p>
    <div x-data="absoluteValueEquationCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coefficient a</label>
                <input type="number" x-model.number="a" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Constant b</label>
                <input type="number" x-model.number="b" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Right side c</label>
                <input type="number" x-model.number="c" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="5">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Absolute Value Equation Solver</h2>
        <p class="text-gray-600 leading-relaxed mb-4">To solve |f(x)| = c, solve both f(x) = c and f(x) = -c. If c < 0, there is no solution.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$|ax + b| = c \Rightarrow ax + b = \pm c$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function absoluteValueEquationCalculator() {
    return {
        a: '', b: '', c: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let a=parseFloat(this.a),b=parseFloat(this.b),c=parseFloat(this.c);if(!a||isNaN(b)||isNaN(c)){this.error="Enter valid values (a≠0)";return;}if(c<0){this.error="No solution (absolute value cannot be negative)";return;}let x1=(c-b)/a,x2=(-c-b)/a;this.result=x1;if(c===0){this.resultText="x = "+x1.toFixed(4)+" (one solution)";this.steps=[{title:"Solution",text:"x = "+(-b)+"/"+a+" = "+x1.toFixed(4)}];}else{this.resultText="x₁ = "+x1.toFixed(4)+", x₂ = "+x2.toFixed(4);this.steps=[{title:"Case 1: ax+b = c",text:a+"x+"+b+" = "+c+" → x = "+x1.toFixed(4)},{title:"Case 2: ax+b = -c",text:a+"x+"+b+" = "+(-c)+" → x = "+x2.toFixed(4)}];} }
    };
}
</script>
@endsection