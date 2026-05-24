@extends('layouts.app')
@section('title', 'Taylor Series Calculator')
@section('meta_description', 'Approximate a function using its Taylor series expansion.')
@section('canonical', config('site.url') . '/math/taylor-series-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Taylor Series Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Taylor Series Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Taylor Series Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Approximate a function using its Taylor series expansion.</p>
    <div x-data="taylorSeriesCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Function (sin/cos/exp/ln)</label>
                <input type="number" x-model.number="func" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="sin">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Value x</label>
                <input type="number" x-model.number="x" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Number of Terms</label>
                <input type="number" x-model.number="n" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Taylor Series Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">A Taylor series approximates a function as an infinite sum of terms. More terms give better accuracy.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$f(x) \approx \sum_{n=0}^{N} \frac{f^{(n)}(a)}{n!}(x-a)^n$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function taylorSeriesCalculator() {
    return {
        func: '', x: '', n: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let x=parseFloat(this.x),n=parseInt(this.n)||10;let func=String(this.func).toLowerCase();let approx=0;this.steps=[];if(func==="sin"){for(let k=0;k<n;k++){let term=Math.pow(-1,k)*Math.pow(x,2*k+1);let fact=1;for(let j=1;j<=2*k+1;j++)fact*=j;term/=fact;approx+=term;this.steps.push({title:"Term "+k,text:"x^"+(2*k+1)+"/"+(2*k+1)+"! = "+term.toFixed(10)});}this.result=approx;this.resultText="sin("+x+") ≈ "+approx.toFixed(10)+" (actual: "+Math.sin(x).toFixed(10)+")";}else if(func==="cos"){for(let k=0;k<n;k++){let term=Math.pow(-1,k)*Math.pow(x,2*k);let fact=1;for(let j=1;j<=2*k;j++)fact*=j;term/=fact;approx+=term;this.steps.push({title:"Term "+k,text:term.toFixed(10)});}this.result=approx;this.resultText="cos("+x+") ≈ "+approx.toFixed(10)+" (actual: "+Math.cos(x).toFixed(10)+")";}else if(func==="exp"){for(let k=0;k<n;k++){let term=Math.pow(x,k);let fact=1;for(let j=1;j<=k;j++)fact*=j;term/=fact;approx+=term;}this.result=approx;this.resultText="e^"+x+" ≈ "+approx.toFixed(10)+" (actual: "+Math.exp(x).toFixed(10)+")";this.steps=[{title:"Taylor series for e^x",text:approx.toFixed(10)}];}else{this.error="Use sin, cos, exp, or ln";} }
    };
}
</script>
@endsection