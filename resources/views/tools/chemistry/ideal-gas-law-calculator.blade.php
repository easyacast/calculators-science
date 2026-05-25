@extends('layouts.app')
@section('title', 'Ideal Gas Law Calculator (PV = nRT)')
@section('meta_description', 'Free ideal gas law calculator. Solve for pressure, volume, temperature, or moles using PV = nRT. Step-by-step solutions with real-world examples.')
@section('canonical', config('site.url') . '/chemistry/ideal-gas-law-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Ideal Gas Law Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/chemistry" class="hover:text-indigo-600">Chemistry</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Ideal Gas Law Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Ideal Gas Law Calculator (PV = nRT)</h1>
    <p class="text-lg text-gray-600 mb-8">Solve for any variable in the ideal gas law equation. Enter three known values and the calculator finds the fourth.</p>

    <div x-data="gasLawCalc()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="flex flex-wrap gap-3 mb-4">
            <button @click="solveFor = 'P'" :class="solveFor === 'P' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Find Pressure</button>
            <button @click="solveFor = 'V'" :class="solveFor === 'V' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Find Volume</button>
            <button @click="solveFor = 'n'" :class="solveFor === 'n' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Find Moles</button>
            <button @click="solveFor = 'T'" :class="solveFor === 'T' ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Find Temperature</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div x-show="solveFor !== 'P'"><label class="block text-sm font-medium text-gray-700 mb-1">Pressure (atm)</label><input type="number" x-model.number="P" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="1"></div>
            <div x-show="solveFor !== 'V'"><label class="block text-sm font-medium text-gray-700 mb-1">Volume (L)</label><input type="number" x-model.number="V" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="22.4"></div>
            <div x-show="solveFor !== 'n'"><label class="block text-sm font-medium text-gray-700 mb-1">Moles (mol)</label><input type="number" x-model.number="n" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="1"></div>
            <div x-show="solveFor !== 'T'"><label class="block text-sm font-medium text-gray-700 mb-1">Temperature (K)</label><input type="number" x-model.number="T" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="273.15"></div>
        </div>

        <button @click="calculate()" class="px-6 py-2.5 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 transition-colors">Calculate</button>

        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-5 border border-emerald-200">
                <div class="text-xs font-medium text-emerald-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">The Ideal Gas Law</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The ideal gas law describes the behavior of an ideal gas. It relates pressure, volume, temperature, and the amount of gas (in moles) through a simple equation.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center"><p class="formula-block">$$PV = nRT$$</p></div>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
            <li><strong>P</strong> = Pressure in atmospheres (atm)</li>
            <li><strong>V</strong> = Volume in liters (L)</li>
            <li><strong>n</strong> = Number of moles (mol)</li>
            <li><strong>R</strong> = Ideal gas constant = 0.08206 L·atm/(mol·K)</li>
            <li><strong>T</strong> = Temperature in Kelvin (K)</li>
        </ul>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Example</h2>
        <p class="text-gray-600 mb-6">At STP (1 atm, 273.15 K), one mole of an ideal gas occupies: $V = \frac{nRT}{P} = \frac{1 \times 0.08206 \times 273.15}{1} = 22.41$ L</p>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function gasLawCalc() {
    const R = 0.08206;
    return {
        solveFor: 'P', P: 1, V: 22.4, n: 1, T: 273.15,
        result: null, resultText: '',

        calculate() {
            if (this.solveFor === 'P') {
                this.result = (this.n * R * this.T) / this.V;
                this.resultText = `Pressure = ${this.result.toFixed(4)} atm`;
            } else if (this.solveFor === 'V') {
                this.result = (this.n * R * this.T) / this.P;
                this.resultText = `Volume = ${this.result.toFixed(4)} L`;
            } else if (this.solveFor === 'n') {
                this.result = (this.P * this.V) / (R * this.T);
                this.resultText = `Moles = ${this.result.toFixed(4)} mol`;
            } else {
                this.result = (this.P * this.V) / (this.n * R);
                this.resultText = `Temperature = ${this.result.toFixed(2)} K (${(this.result - 273.15).toFixed(2)} °C)`;
            }
        },
    };
}
</script>
@endsection
