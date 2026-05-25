@extends('layouts.app')
@section('title', 'Roman to Arabic Converter')
@section('meta_description', 'Convert Roman numerals to Arabic numbers.')
@section('canonical', config('site.url') . '/unit-converter/roman-to-arabic-converter')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Roman to Arabic Converter","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/unit-converter" class="hover:text-indigo-600">Unit Converters</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Roman to Arabic Converter</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Roman to Arabic Converter</h1>
    <p class="text-lg text-gray-600 mb-8">Convert Roman numerals to Arabic numbers.</p>
    <div x-data="romanToArabicConverter()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Roman Numeral</label>
                <input type="number" x-model.number="roman" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="MCMXCIX">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-purple-600 text-white font-medium rounded-xl hover:bg-purple-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-purple-50 to-orange-50 rounded-xl p-5 border border-purple-200">
                <div class="text-xs font-medium text-purple-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Roman to Arabic Converter</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Roman numeral conversion: place smaller value before larger for subtraction (IV=4, IX=9, XL=40, XC=90, CD=400, CM=900).</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$MCMXCIX \rightarrow 1999$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function romanToArabicConverter() {
    return {
        roman: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let s=String(this.roman).toUpperCase().trim();if(!/^[IVXLCDM]+$/.test(s)){this.error="Enter valid Roman numeral";return;}let map={I:1,V:5,X:10,L:50,C:100,D:500,M:1000};let r=0;for(let i=0;i<s.length;i++){if(i+1<s.length&&map[s[i]]<map[s[i+1]]){r-=map[s[i]];}else{r+=map[s[i]];}}this.result=r;this.resultText=s+" = "+r;this.steps=[{title:"Conversion",text:s+" → "+r},{title:"Binary",text:r.toString(2)},{title:"Hex",text:"0x"+r.toString(16).toUpperCase()}]; }
    };
}
</script>
@endsection