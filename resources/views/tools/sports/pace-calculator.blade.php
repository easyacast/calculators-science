@extends('layouts.app')
@section('title', 'Running Pace Calculator')
@section('meta_description', 'Calculate pace, speed, or time for running.')
@section('canonical', config('site.url') . '/sports/pace-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Running Pace Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/sports" class="hover:text-indigo-600">Sports & Fitness</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Running Pace Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Running Pace Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate pace, speed, or time for running.</p>
    <div x-data="paceCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Distance (km)</label>
                <input type="number" x-model.number="dist" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hours</label>
                <input type="number" x-model.number="hours" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Minutes</label>
                <input type="number" x-model.number="mins" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="25">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Seconds</label>
                <input type="number" x-model.number="secs" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="0">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-orange-600 text-white font-medium rounded-xl hover:bg-orange-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-orange-50 to-orange-50 rounded-xl p-5 border border-orange-200">
                <div class="text-xs font-medium text-orange-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Running Pace Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Running pace = time/distance. Elite marathon pace: ~2:55/km. Recreational 5K pace: ~5:00-7:00/km.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$pace = \frac{time}{distance}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function paceCalculator() {
    return {
        dist: '', hours: '', mins: '', secs: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let d=parseFloat(this.dist),h=parseInt(this.hours)||0,m=parseInt(this.mins)||0,s=parseInt(this.secs)||0;if(!d){this.error="Enter distance";return;}let totalS=h*3600+m*60+s;if(!totalS){this.error="Enter time";return;}let paceS=totalS/d;let paceM=Math.floor(paceS/60);let paceR=Math.round(paceS%60);let speedKmh=d/(totalS/3600);this.result=speedKmh;this.resultText="Pace: "+paceM+":"+String(paceR).padStart(2,"0")+"/km";this.steps=[{title:"Pace",text:paceM+":"+String(paceR).padStart(2,"0")+" min/km"},{title:"Speed",text:speedKmh.toFixed(2)+" km/h"},{title:"Mile pace",text:Math.floor(paceS*1.60934/60)+":"+String(Math.round(paceS*1.60934%60)).padStart(2,"0")+" min/mi"}]; }
    };
}
</script>
@endsection