@extends('layouts.app')
@section('title', 'Inverse Function Calculator')
@section('meta_description', 'Find the inverse of simple functions.')
@section('canonical', config('site.url') . '/math/inverse-function-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Inverse Function Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Inverse Function Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Inverse Function Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Find the inverse of simple functions.</p>
    <div x-data="inverseFunctionCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Value y</label>
                <input type="number" x-model.number="y" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="8">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Function type (linear/quadratic/exp)</label>
                <input type="number" x-model.number="func" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="linear">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coefficient a</label>
                <input type="number" x-model.number="a" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coefficient b</label>
                <input type="number" x-model.number="b" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="3">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Inverse Function Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">An inverse function reverses the input-output relationship. f⁻¹(f(x)) = x. A function must be one-to-one to have an inverse.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$f^{-1}(y) = x \text{ where } f(x) = y$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function inverseFunctionCalculator() {
    return {
        y: '', func: '', a: '', b: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let y=parseFloat(this.y),a=parseFloat(this.a)||1,b=parseFloat(this.b)||0;let func=String(this.func).toLowerCase();if(isNaN(y)){this.error="Enter y value";return;}if(func==="linear"){if(a===0){this.error="a cannot be 0";return;}this.result=(y-b)/a;this.resultText="f⁻¹("+y+") = "+this.result.toFixed(6);this.steps=[{title:"f(x) = "+a+"x + "+b,text:"Inverse: x = (y - "+b+")/"+a},{title:"f⁻¹("+y+")",text:this.result.toFixed(6)}];}else if(func==="exp"){this.result=Math.log(y)/Math.log(a);this.resultText="f⁻¹("+y+") = "+this.result.toFixed(6);this.steps=[{title:"f(x) = "+a+"^x",text:"Inverse: x = log_"+a+"(y)"},{title:"Result",text:this.result.toFixed(6)}];}else{this.error="Supported: linear, exp";} }
    };
}
</script>
@endsection