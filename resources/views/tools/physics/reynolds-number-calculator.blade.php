@extends('layouts.app')
@section('title', 'Reynolds Number Calculator')
@section('meta_description', 'Free Reynolds Number Calculator. Determine flow regime (laminar/turbulent) with step-by-step solutions.')
@section('canonical', config('site.url') . '/physics/reynolds-number-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Reynolds Number Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Reynolds Number Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Reynolds Number Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate Reynolds number to determine laminar or turbulent flow in fluid mechanics.</p>

    <div x-data="reynoldsNumberCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fluid Density ρ (kg/m³)</label>
                <input type="number" x-model.number="density" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="1000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Flow Velocity v (m/s)</label>
                <input type="number" x-model.number="velocity" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Characteristic Length D (m)</label>
                <input type="number" x-model.number="diameter" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="0.05">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dynamic Viscosity μ (Pa·s)</label>
                <input type="number" x-model.number="viscosity" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="0.001">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Reynolds Number</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The Reynolds number is a dimensionless quantity used to predict flow patterns. It represents the ratio of inertial forces to viscous forces within a fluid.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center"><p class="formula-block">$$Re = \frac{\rho v D}{\mu}$$</p></div>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
            <li><strong>ρ</strong> = Fluid density (kg/m³)</li>
            <li><strong>v</strong> = Flow velocity (m/s)</li>
            <li><strong>D</strong> = Characteristic length/diameter (m)</li>
            <li><strong>μ</strong> = Dynamic viscosity (Pa·s)</li>
        </ul>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Flow Regimes</h2>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
            <li>Re &lt; 2,300 → Laminar flow (smooth, orderly)</li>
            <li>2,300 &lt; Re &lt; 4,000 → Transitional flow</li>
            <li>Re &gt; 4,000 → Turbulent flow (chaotic, mixing)</li>
        </ul>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function reynoldsNumberCalculator() {
    return {
        density: '', velocity: '', diameter: '', viscosity: '', result: null, resultText: '', steps: [], error: '',
        
        calculate() {
            let rho = parseFloat(this.density), v = parseFloat(this.velocity);
            let D = parseFloat(this.diameter), mu = parseFloat(this.viscosity);
            if (!rho || !v || !D || !mu) { this.error = 'Please fill all fields'; return; }
            if (mu === 0) { this.error = 'Viscosity cannot be zero'; return; }
            this.result = (rho * v * D) / mu;
            let regime = this.result < 2300 ? 'Laminar' : (this.result < 4000 ? 'Transitional' : 'Turbulent');
            this.resultText = 'Re = ' + this.result.toFixed(2) + ' (' + regime + ' flow)';
            this.steps = [
                {title: 'Given values', text: 'ρ = ' + rho + ' kg/m³, v = ' + v + ' m/s, D = ' + D + ' m, μ = ' + mu + ' Pa·s'},
                {title: 'Apply formula Re = ρvD/μ', text: 'Re = (' + rho + ' × ' + v + ' × ' + D + ') / ' + mu + ' = ' + this.result.toFixed(2)},
                {title: 'Flow regime', text: regime + ' (Re < 2300: Laminar, 2300-4000: Transitional, > 4000: Turbulent)'}
            ];
        }
    };
}
</script>
@endsection