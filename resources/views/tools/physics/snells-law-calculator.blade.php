@extends('layouts.app')
@section('title', 'Snell\'s Law Calculator')
@section('meta_description', 'Calculate the angle of refraction using Snell\'s Law.')
@section('canonical', config('site.url') . '/physics/snells-law-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Snell\'s Law Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/physics" class="hover:text-indigo-600">Physics</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Snell's Law Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Snell's Law Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the angle of refraction using Snell's Law.</p>
    <div x-data="snellsLawCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Refractive Index n₁</label>
                <input type="number" x-model.number="n1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Angle of Incidence θ₁ (°)</label>
                <input type="number" x-model.number="theta1" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="30">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Refractive Index n₂</label>
                <input type="number" x-model.number="n2" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="1.5">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-amber-600 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200">
                <div class="text-xs font-medium text-amber-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Understanding Snell's Law Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Snell's Law describes how light bends when passing between media with different refractive indices. When the refracted angle reaches 90°, total internal reflection occurs.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$n_1 \sin\theta_1 = n_2 \sin\theta_2$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function snellsLawCalculator() {
    return {
        n1: '', theta1: '', n2: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let n1=parseFloat(this.n1),t1=parseFloat(this.theta1),n2=parseFloat(this.n2);if(!n1||isNaN(t1)||!n2){this.error="Enter valid values";return;}let sin2=n1*Math.sin(t1*Math.PI/180)/n2;if(Math.abs(sin2)>1){this.error="Total internal reflection (no refracted ray)";return;}this.result=Math.asin(sin2)*180/Math.PI;let crit=n2<n1?Math.asin(n2/n1)*180/Math.PI:null;this.resultText="θ₂ = "+this.result.toFixed(4)+"°";this.steps=[{title:"Given",text:"n₁="+n1+", θ₁="+t1+"°, n₂="+n2},{title:"sinθ₂ = n₁sinθ₁/n₂",text:"sinθ₂ = "+sin2.toFixed(6)},{title:"θ₂",text:this.result.toFixed(4)+"°"}];if(crit)this.steps.push({title:"Critical angle",text:crit.toFixed(4)+"°"}); }
    };
}
</script>
@endsection