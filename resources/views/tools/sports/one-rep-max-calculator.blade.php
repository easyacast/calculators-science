@extends('layouts.app')
@section('title', 'One Rep Max (1RM) Calculator')
@section('meta_description', 'Estimate your 1RM from submaximal lifts.')
@section('canonical', config('site.url') . '/sports/one-rep-max-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"One Rep Max (1RM) Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">One Rep Max (1RM) Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">One Rep Max (1RM) Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Estimate your 1RM from submaximal lifts.</p>
    <div x-data="oneRepMaxCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Weight Lifted</label>
                <input type="number" x-model.number="weight" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="100">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Reps Performed</label>
                <input type="number" x-model.number="reps" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="8">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About One Rep Max (1RM) Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">1RM is the maximum weight you can lift once. Use submaximal estimates (5-10 reps) for safety.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$1RM = w \times (1 + \frac{r}{30})$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function oneRepMaxCalculator() {
    return {
        weight: '', reps: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let w=parseFloat(this.weight),r=parseInt(this.reps);if(!w||!r||r<1){this.error="Enter values";return;}let epley=w*(1+r/30);let brzycki=w*(36/(37-r));let lander=100*w/(101.3-2.67123*r);this.result=Math.round(epley);this.resultText="Estimated 1RM ≈ "+Math.round(epley);this.steps=[{title:"Epley formula",text:Math.round(epley)},{title:"Brzycki formula",text:Math.round(brzycki)},{title:"Training loads:",text:""},{title:"85% (5 reps)",text:Math.round(epley*0.85)},{title:"75% (10 reps)",text:Math.round(epley*0.75)},{title:"65% (15 reps)",text:Math.round(epley*0.65)}]; }
    };
}
</script>
@endsection