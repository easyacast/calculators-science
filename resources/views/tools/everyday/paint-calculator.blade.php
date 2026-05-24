@extends('layouts.app')
@section('title', 'Paint Calculator')
@section('meta_description', 'Calculate paint needed for a room.')
@section('canonical', config('site.url') . '/everyday/paint-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Paint Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/everyday" class="hover:text-indigo-600">Everyday Tools</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Paint Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Paint Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate paint needed for a room.</p>
    <div x-data="paintCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Room Length (ft)</label>
                <input type="number" x-model.number="length" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" placeholder="15">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Room Width (ft)</label>
                <input type="number" x-model.number="width" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" placeholder="12">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Wall Height (ft)</label>
                <input type="number" x-model.number="height" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" placeholder="8">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Coverage (sq ft/gallon)</label>
                <input type="number" x-model.number="coverage" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" placeholder="350">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-violet-600 text-white font-medium rounded-xl hover:bg-violet-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-violet-50 to-orange-50 rounded-xl p-5 border border-violet-200">
                <div class="text-xs font-medium text-violet-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-violet-100 text-violet-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Paint Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Calculate paint for 4 walls. Subtract ~10% for windows and doors. Most rooms need 2 coats.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$gallons = \frac{total\text{ area}}{coverage}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function paintCalculator() {
    return {
        length: '', width: '', height: '', coverage: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let l=parseFloat(this.length),w=parseFloat(this.width),h=parseFloat(this.height),cov=parseFloat(this.coverage)||350;if(!l||!w||!h){this.error="Enter dimensions";return;}let wallArea=2*(l+w)*h;let adjusted=wallArea*0.9;this.result=adjusted/cov;this.resultText=Math.ceil(this.result)+" gallons needed";this.steps=[{title:"Wall area",text:wallArea.toFixed(1)+" sq ft"},{title:"After windows/doors (−10%)",text:adjusted.toFixed(1)+" sq ft"},{title:"Gallons needed",text:this.result.toFixed(2)},{title:"For 2 coats",text:Math.ceil(this.result*2)+" gallons"}]; }
    };
}
</script>
@endsection