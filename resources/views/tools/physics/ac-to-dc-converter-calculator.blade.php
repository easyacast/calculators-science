@extends('layouts.app')
@section('title', 'AC to DC Converter Calculator')
@section('meta_description', 'Convert AC voltage to DC voltage for different rectifier configurations.')
@section('canonical', config('site.url') . '/physics/ac-to-dc-converter-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"AC to DC Converter Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">AC to DC Converter Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">AC to DC Converter Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Convert AC voltage to DC voltage for different rectifier configurations.</p>

    <div x-data="acToDcConverterCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">AC RMS Voltage (V)</label>
                <input type="number" x-model.number="vac" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="220">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rectifier Type (1=half,2=full)</label>
                <input type="number" x-model.number="rectType" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="2">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Understanding AC to DC Converter Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">AC to DC conversion uses rectifiers. Half-wave rectifiers output Vpeak/π. Full-wave (bridge) rectifiers output 2Vpeak/π (unfiltered average).</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$V_{DC} = V_{peak} \times \text{factor}$$</p></div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function acToDcConverterCalculator() {
    return {
        vac: '', rectType: '', result: null, resultText: '', steps: [], error: '',
        calculate() {
            this.error = '';
            this.result = null;
            let vac=parseFloat(this.vac),rt=parseInt(this.rectType);if(!vac){this.error="Enter valid voltage";return;}let vpeak=vac*Math.sqrt(2);let vdc=rt===1?vpeak/Math.PI:2*vpeak/Math.PI;this.result=vdc;this.resultText="DC Output ≈ "+this.result.toFixed(2)+" V";this.steps=[{title:"Peak voltage",text:"Vpeak = "+vac+" × √2 = "+vpeak.toFixed(2)+" V"},{title:"DC output ("+(rt===1?"half":"full")+"-wave)",text:"Vdc = "+(rt===1?"Vpeak/π":"2Vpeak/π")+" = "+this.result.toFixed(2)+" V"}];
        }
    };
}
</script>
@endsection