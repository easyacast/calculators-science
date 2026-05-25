@extends('layouts.app')
@section('title', 'Heart Rate Zone Calculator')
@section('meta_description', 'Calculate target heart rate zones for exercise.')
@section('canonical', config('site.url') . '/health/heart-rate-zone-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Heart Rate Zone Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/health" class="hover:text-indigo-600">Health</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Heart Rate Zone Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Heart Rate Zone Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate target heart rate zones for exercise.</p>
    <div x-data="heartRateZoneCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                <input type="number" x-model.number="age" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="30">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Resting HR (bpm)</label>
                <input type="number" x-model.number="rest" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="60">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-rose-600 text-white font-medium rounded-xl hover:bg-rose-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-rose-50 to-orange-50 rounded-xl p-5 border border-rose-200">
                <div class="text-xs font-medium text-rose-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Heart Rate Zone Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Heart rate zones use the Karvonen formula. Max HR ≈ 220 - age. Zones guide exercise intensity for different goals.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$THR = (HR_{max} - HR_{rest}) \times \%intensity + HR_{rest}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function heartRateZoneCalculator() {
    return {
        age: '', rest: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let age=parseInt(this.age),rest=parseInt(this.rest)||60;if(!age){this.error="Enter age";return;}let max=220-age;this.result=max;this.resultText="Max HR: "+max+" bpm";let zones=[{name:"Recovery",lo:0.5,hi:0.6},{name:"Fat Burn",lo:0.6,hi:0.7},{name:"Aerobic",lo:0.7,hi:0.8},{name:"Anaerobic",lo:0.8,hi:0.9},{name:"VO2 Max",lo:0.9,hi:1.0}];this.steps=zones.map(z=>({title:z.name+" ("+Math.round(z.lo*100)+"-"+Math.round(z.hi*100)+"%)",text:Math.round((max-rest)*z.lo+rest)+"-"+Math.round((max-rest)*z.hi+rest)+" bpm"})); }
    };
}
</script>
@endsection