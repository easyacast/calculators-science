@extends('layouts.app')
@section('title', 'Circular Velocity Calculator')
@section('meta_description', 'Calculate the velocity of an object in circular motion.')
@section('canonical', config('site.url') . '/physics/circular-velocity-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Circular Velocity Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Circular Velocity Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Circular Velocity Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the velocity of an object in circular motion.</p>

    <div x-data="circularVelocityCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Radius r (m)</label>
                <input type="number" x-model.number="r" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Period T (s)</label>
                <input type="number" x-model.number="T" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="2">
            </div>
        </div>

        <button @click="calculate()" class="px-6 py-2.5 bg-amber-600 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors">Calculate</button>

        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100">
            <p class="text-sm text-red-700" x-text="error"></p>
        </div>

        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200">
                <div class="text-xs font-medium text-amber-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                            <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Understanding Circular Velocity Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Circular velocity is the tangential speed of an object moving in a circle. It depends on the radius and the period of revolution.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$v = \frac{2\pi r}{T}$$</p></div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function circularVelocityCalculator() {
    return {
        r: '', T: '', result: null, resultText: '', steps: [], error: '',
        calculate() {
            this.error = '';
            this.result = null;
            let r=parseFloat(this.r),T=parseFloat(this.T);if(!r||!T||T===0){this.error="Enter valid values";return;}this.result=2*Math.PI*r/T;let omega=2*Math.PI/T;this.resultText="v = "+this.result.toFixed(4)+" m/s";this.steps=[{title:"Given",text:"r="+r+" m, T="+T+" s"},{title:"v = 2πr/T",text:"v = 2π×"+r+"/"+T+" = "+this.result.toFixed(4)+" m/s"},{title:"Angular velocity",text:"ω = 2π/T = "+omega.toFixed(4)+" rad/s"}];
        }
    };
}
</script>
@endsection