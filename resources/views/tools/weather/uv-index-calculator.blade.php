@extends('layouts.app')
@section('title', 'UV Index Risk Calculator')
@section('meta_description', 'Determine sun safety based on UV index.')
@section('canonical', config('site.url') . '/weather/uv-index-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"UV Index Risk Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">UV Index Risk Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">UV Index Risk Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Determine sun safety based on UV index.</p>
    <div x-data="uvIndexCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">UV Index</label>
                <input type="number" x-model.number="uv" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="7">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About UV Index Risk Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">UV index measures solar UV radiation intensity. Higher = more risk. Always use sunscreen when UV ≥ 3.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$UV\text{ index categories}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function uvIndexCalculator() {
    return {
        uv: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let uv=parseFloat(this.uv);if(isNaN(uv)||uv<0){this.error="Enter UV index (0+)";return;}let cat=uv<3?"Low":uv<6?"Moderate":uv<8?"High":uv<11?"Very High":"Extreme";let time=uv<3?"No protection needed":uv<6?"30+ min to burn":uv<8?"20 min to burn":uv<11?"15 min to burn":"<10 min to burn";this.result=uv;this.resultText="UV "+uv+" ("+cat+")";this.steps=[{title:"Category",text:cat},{title:"Burn time (fair skin)",text:time},{title:"SPF recommendation",text:uv<3?"Optional":uv<6?"SPF 30+":uv<8?"SPF 30-50":"SPF 50+"},{title:"Protection",text:uv>=3?"Seek shade, sunscreen, hat, sunglasses":"Minimal needed"}]; }
    };
}
</script>
@endsection