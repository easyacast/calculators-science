@extends('layouts.app')
@section('title', 'Temperature Converter - Celsius, Fahrenheit, Kelvin')
@section('meta_description', 'Free temperature converter. Convert between Celsius, Fahrenheit, and Kelvin instantly with formulas and step-by-step explanations.')
@section('canonical', config('site.url') . '/unit-converter/temperature-converter')
@section('schema')<script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Temperature Converter","applicationCategory":"UtilityApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}</script>@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6"><ol class="flex items-center gap-2 text-sm text-gray-500"><li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li><li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li><li><a href="{{ config('site.url') }}/unit-converter" class="hover:text-indigo-600">Unit Converters</a></li><li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li><li class="text-gray-900 font-medium">Temperature Converter</li></ol></nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Temperature Converter</h1>
    <p class="text-lg text-gray-600 mb-8">Convert between Celsius, Fahrenheit, and Kelvin temperature scales. Enter a value in any field and all others update instantly.</p>

    <div x-data="tempConv()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Celsius (°C)</label><input type="number" x-model="celsius" @input="fromC()" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Fahrenheit (°F)</label><input type="number" x-model="fahrenheit" @input="fromF()" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Kelvin (K)</label><input type="number" x-model="kelvin" @input="fromK()" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500"></div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Temperature Conversion Formulas</h2>
        <div class="space-y-3 mb-6">
            <div class="bg-gray-50 rounded-lg p-3 text-center"><p class="formula-block">$$°F = °C \times \frac{9}{5} + 32$$</p></div>
            <div class="bg-gray-50 rounded-lg p-3 text-center"><p class="formula-block">$$K = °C + 273.15$$</p></div>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Key Reference Points</h2>
        <table class="w-full text-sm text-gray-600 mb-6"><thead><tr class="border-b"><th class="text-left py-2">Event</th><th class="py-2">°C</th><th class="py-2">°F</th><th class="py-2">K</th></tr></thead><tbody><tr class="border-b border-gray-100"><td class="py-2">Water freezes</td><td class="text-center">0</td><td class="text-center">32</td><td class="text-center">273.15</td></tr><tr class="border-b border-gray-100"><td class="py-2">Body temperature</td><td class="text-center">37</td><td class="text-center">98.6</td><td class="text-center">310.15</td></tr><tr><td class="py-2">Water boils</td><td class="text-center">100</td><td class="text-center">212</td><td class="text-center">373.15</td></tr></tbody></table>
    </div>
</div>
@endsection

@section('scripts')
<script>
function tempConv() {
    return {
        celsius: 0, fahrenheit: 32, kelvin: 273.15,
        fromC() { this.fahrenheit = (parseFloat(this.celsius) * 9/5 + 32).toFixed(2); this.kelvin = (parseFloat(this.celsius) + 273.15).toFixed(2); },
        fromF() { this.celsius = ((parseFloat(this.fahrenheit) - 32) * 5/9).toFixed(2); this.kelvin = (parseFloat(this.celsius) + 273.15).toFixed(2); },
        fromK() { this.celsius = (parseFloat(this.kelvin) - 273.15).toFixed(2); this.fahrenheit = (parseFloat(this.celsius) * 9/5 + 32).toFixed(2); },
    };
}
</script>
@endsection
