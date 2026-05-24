@extends('layouts.app')
@section('title', 'Regression Slope Calculator')
@section('meta_description', 'Calculate the slope and intercept of the regression line.')
@section('canonical', config('site.url') . '/math/regression-slope-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Regression Slope Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Regression Slope Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Regression Slope Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the slope and intercept of the regression line.</p>
    <div x-data="regressionSlopeCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">X values (comma-separated)</label>
                <input type="number" x-model.number="xdata" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1,2,3,4,5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Y values (comma-separated)</label>
                <input type="number" x-model.number="ydata" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2,4,5,4,5">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Regression Slope Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The regression line minimizes the sum of squared residuals. R² measures how well the line fits the data (0 to 1).</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$m = \frac{n\sum xy - \sum x \sum y}{n\sum x^2 - (\sum x)^2}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function regressionSlopeCalculator() {
    return {
        xdata: '', ydata: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let X=String(this.xdata).split(",").map(Number);let Y=String(this.ydata).split(",").map(Number);if(X.length!==Y.length||X.length<2){this.error="Equal-length arrays";return;}let n=X.length;let sx=X.reduce((a,b)=>a+b),sy=Y.reduce((a,b)=>a+b);let sxy=X.reduce((s,x,i)=>s+x*Y[i],0);let sxx=X.reduce((s,x)=>s+x*x,0);let m=(n*sxy-sx*sy)/(n*sxx-sx*sx);let b2=sy/n-m*sx/n;this.result=m;this.resultText="y = "+m.toFixed(4)+"x + "+b2.toFixed(4);this.steps=[{title:"Slope m",text:m.toFixed(6)},{title:"Intercept b",text:b2.toFixed(6)},{title:"R²",text:(function(){let mx=sx/n,my=sy/n;let ss_tot=Y.reduce((s,y)=>s+(y-my)**2,0);let ss_res=Y.reduce((s,y,i)=>s+(y-m*X[i]-b2)**2,0);return(1-ss_res/ss_tot).toFixed(6);})()}]; }
    };
}
</script>
@endsection