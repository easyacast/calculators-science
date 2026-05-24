@extends('layouts.app')
@section('title', 'Terminal Velocity Calculator')
@section('meta_description', 'Calculate terminal velocity of a falling object.')
@section('canonical', config('site.url') . '/physics/terminal-velocity-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Terminal Velocity Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Terminal Velocity Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Terminal Velocity Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate terminal velocity of a falling object.</p>
    <div x-data="terminalVelocityCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mass m (kg)</label>
                <input type="number" x-model.number="m" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="80">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cross-section Area A (m²)</label>
                <input type="number" x-model.number="A" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="0.7">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Drag Coefficient Cd</label>
                <input type="number" x-model.number="Cd" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="1.0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Air Density ρ (kg/m³)</label>
                <input type="number" x-model.number="rho" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="1.225">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-amber-600 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-200">
                <div class="text-xs font-medium text-amber-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Understanding Terminal Velocity Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Terminal velocity is reached when drag force equals gravitational force. A skydiver in spread position reaches about 55 m/s (200 km/h).</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$v_t = \sqrt{\frac{2mg}{\rho A C_d}}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function terminalVelocityCalculator() {
    return {
        m: '', A: '', Cd: '', rho: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let m=parseFloat(this.m),A=parseFloat(this.A),Cd=parseFloat(this.Cd),rho=parseFloat(this.rho);if(!m||!A||!Cd||!rho){this.error="Enter valid values";return;}this.result=Math.sqrt(2*m*9.81/(rho*A*Cd));this.resultText="vt = "+this.result.toFixed(2)+" m/s ("+(this.result*3.6).toFixed(2)+" km/h)";this.steps=[{title:"Given",text:"m="+m+"kg, A="+A+"m², Cd="+Cd+", ρ="+rho+"kg/m³"},{title:"vt = √(2mg/(ρACd))",text:"vt = "+this.result.toFixed(2)+" m/s"}]; }
    };
}
</script>
@endsection