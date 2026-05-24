@extends('layouts.app')
@section('title', 'Mach Number Calculator')
@section('meta_description', 'Free Mach Number Calculator. Determine subsonic, transonic, or supersonic flow with step-by-step solutions.')
@section('canonical', config('site.url') . '/physics/mach-number-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Mach Number Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Mach Number Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Mach Number Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the Mach number — ratio of object speed to speed of sound.</p>

    <div x-data="machNumberCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Object Speed (m/s)</label>
                <input type="number" x-model.number="objectSpeed" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="680">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Speed of Sound (m/s)</label>
                <input type="number" x-model.number="soundSpeed" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="343">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Mach Number</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The Mach number is the ratio of the speed of an object to the speed of sound in the surrounding medium. Named after physicist Ernst Mach.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center"><p class="formula-block">$$Ma = \frac{v}{c}$$</p></div>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
            <li>Ma &lt; 0.8 → Subsonic</li><li>0.8 &lt; Ma &lt; 1.2 → Transonic</li>
            <li>1.2 &lt; Ma &lt; 5 → Supersonic</li><li>Ma &gt; 5 → Hypersonic</li>
        </ul>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function machNumberCalculator() {
    return {
        objectSpeed: '', soundSpeed: '', result: null, resultText: '', steps: [], error: '',
        
        calculate() {
            let v = parseFloat(this.objectSpeed), c = parseFloat(this.soundSpeed);
            if (isNaN(v) || isNaN(c) || c === 0) { this.error = 'Please enter valid values'; return; }
            this.result = v / c;
            let regime = this.result < 0.8 ? 'Subsonic' : (this.result < 1.2 ? 'Transonic' : (this.result < 5 ? 'Supersonic' : 'Hypersonic'));
            this.resultText = 'Ma = ' + this.result.toFixed(4) + ' (' + regime + ')';
            this.steps = [
                {title: 'Given', text: 'Object speed = ' + v + ' m/s, Speed of sound = ' + c + ' m/s'},
                {title: 'Apply Ma = v/c', text: 'Ma = ' + v + ' / ' + c + ' = ' + this.result.toFixed(4)},
                {title: 'Classification', text: regime + ' flow'}
            ];
        }
    };
}
</script>
@endsection