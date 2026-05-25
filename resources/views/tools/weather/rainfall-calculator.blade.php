@extends('layouts.app')
@section('title', 'Rainfall Volume Calculator')
@section('meta_description', 'Calculate water volume from rainfall depth and area.')
@section('canonical', config('site.url') . '/weather/rainfall-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Rainfall Volume Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/weather" class="hover:text-indigo-600">Weather</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Rainfall Volume Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Rainfall Volume Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate water volume from rainfall depth and area.</p>
    <div x-data="rainfallCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rainfall (mm)</label>
                <input type="number" x-model.number="depth" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="25">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Area (m²)</label>
                <input type="number" x-model.number="area" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="100">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-sky-600 text-white font-medium rounded-xl hover:bg-sky-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-sky-50 to-orange-50 rounded-xl p-5 border border-sky-200">
                <div class="text-xs font-medium text-sky-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Rainfall Volume Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Rainfall volume = depth × area. 1mm of rain on 1m² = 1 liter of water.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$V = depth \times area$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function rainfallCalculator() {
    return {
        depth: '', area: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let d=parseFloat(this.depth),a=parseFloat(this.area);if(!d||!a){this.error="Enter values";return;}this.result=d*a/1000;let liters=this.result*1000;this.resultText=liters.toFixed(1)+" liters ("+this.result.toFixed(4)+" m³)";this.steps=[{title:"Volume",text:this.result.toFixed(4)+" m³"},{title:"In liters",text:liters.toFixed(1)+" L"},{title:"In gallons",text:(liters*0.264172).toFixed(1)+" gal"}]; }
    };
}
</script>
@endsection