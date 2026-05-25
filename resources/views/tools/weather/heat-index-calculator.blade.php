@extends('layouts.app')
@section('title', 'Heat Index Calculator')
@section('meta_description', 'Calculate the apparent temperature (feels like) from temperature and humidity.')
@section('canonical', config('site.url') . '/weather/heat-index-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Heat Index Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Heat Index Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Heat Index Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the apparent temperature (feels like) from temperature and humidity.</p>
    <div x-data="heatIndexCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Temperature (°F)</label>
                <input type="number" x-model.number="T" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="95">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Relative Humidity (%)</label>
                <input type="number" x-model.number="rh" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500" placeholder="65">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Heat Index Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Heat index combines temperature and humidity to show how hot it actually feels. High humidity reduces sweat evaporation.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$HI = f(T, RH)$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function heatIndexCalculator() {
    return {
        T: '', rh: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let T=parseFloat(this.T),rh=parseFloat(this.rh);if(isNaN(T)||isNaN(rh)){this.error="Enter values";return;}let HI=-42.379+2.04901523*T+10.14333127*rh-0.22475541*T*rh-6.83783e-3*T*T-5.481717e-2*rh*rh+1.22874e-3*T*T*rh+8.5282e-4*T*rh*rh-1.99e-6*T*T*rh*rh;this.result=HI;let C=(HI-32)*5/9;let danger=HI<80?"Comfortable":HI<90?"Caution":HI<105?"Danger":"Extreme Danger";this.resultText="Heat Index: "+HI.toFixed(1)+"°F ("+C.toFixed(1)+"°C) - "+danger;this.steps=[{title:"Temperature",text:T+"°F"},{title:"Humidity",text:rh+"%"},{title:"Heat Index",text:HI.toFixed(1)+"°F"},{title:"Danger level",text:danger}]; }
    };
}
</script>
@endsection