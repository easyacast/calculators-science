@extends('layouts.app')
@section('title', 'Shoe Size Converter')
@section('meta_description', 'Convert between US, UK, and EU shoe sizes.')
@section('canonical', config('site.url') . '/unit-converter/shoe-size-converter')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Shoe Size Converter","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Shoe Size Converter</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Shoe Size Converter</h1>
    <p class="text-lg text-gray-600 mb-8">Convert between US, UK, and EU shoe sizes.</p>
    <div x-data="shoeSizeConverter()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
                <input type="number" x-model.number="size" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="10">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From (us_m/us_w/uk/eu)</label>
                <input type="number" x-model.number="from" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="us_m">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Shoe Size Converter</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Shoe sizes vary by region. US Men 10 ≈ UK 9.5 ≈ EU 43. Women's US sizes are typically 1.5 larger than men's.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$EU = US_{men} \times 1.27 + 33$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function shoeSizeConverter() {
    return {
        size: '', from: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let s=parseFloat(this.size),f=String(this.from).toLowerCase();if(isNaN(s)){this.error="Enter size";return;}let us_m,us_w,uk,eu;if(f==="us_m"){us_m=s;us_w=s+1.5;uk=s-0.5;eu=s+33;}else if(f==="us_w"){us_w=s;us_m=s-1.5;uk=s-2;eu=s+31.5;}else if(f==="uk"){uk=s;us_m=s+0.5;us_w=s+2;eu=s+33.5;}else{eu=s;us_m=s-33;us_w=s-31.5;uk=s-33.5;}this.result=eu;this.resultText="EU "+eu.toFixed(1);this.steps=[{title:"US Men",text:us_m.toFixed(1)},{title:"US Women",text:us_w.toFixed(1)},{title:"UK",text:uk.toFixed(1)},{title:"EU",text:eu.toFixed(1)}]; }
    };
}
</script>
@endsection