@extends('layouts.app')

@section('title', 'Length Converter - Convert Between Length Units')
@section('meta_description', 'Free online length converter. Convert between meters, feet, inches, centimeters, kilometers, miles, yards, and more length units instantly.')
@section('canonical', config('site.url') . '/unit-converter/length-converter')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Length Converter",
    "applicationCategory": "UtilityApplication",
    "operatingSystem": "Web",
    "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }
}
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
            <li class="text-gray-900 font-medium">Length Converter</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Length Converter</h1>
    <p class="text-lg text-gray-600 mb-8">Convert between different units of length instantly. Supports meters, feet, inches, centimeters, kilometers, miles, yards, and more.</p>

    <div x-data="lengthConverter()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                <input type="number" x-model.number="value" @input="convert()" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
                <select x-model="fromUnit" @change="convert()" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <template x-for="u in units" :key="u.key"><option :value="u.key" x-text="u.label"></option></template>
                </select>
            </div>
        </div>

        <div x-show="results.length > 0" x-cloak class="mt-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Conversion Results</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <template x-for="r in results" :key="r.unit">
                    <div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-2.5 border border-gray-100">
                        <span class="text-sm text-gray-600" x-text="r.label"></span>
                        <span class="font-mono text-sm font-semibold text-gray-900" x-text="r.value"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Common Length Conversions</h2>
        <div class="overflow-x-auto mb-6">
            <table class="w-full text-sm text-gray-600">
                <thead><tr class="border-b border-gray-200"><th class="text-left py-2">From</th><th class="text-left py-2">To</th><th class="text-left py-2">Multiply by</th></tr></thead>
                <tbody>
                    <tr class="border-b border-gray-100"><td class="py-2">1 meter</td><td>feet</td><td>3.28084</td></tr>
                    <tr class="border-b border-gray-100"><td class="py-2">1 inch</td><td>centimeters</td><td>2.54</td></tr>
                    <tr class="border-b border-gray-100"><td class="py-2">1 mile</td><td>kilometers</td><td>1.60934</td></tr>
                    <tr class="border-b border-gray-100"><td class="py-2">1 yard</td><td>meters</td><td>0.9144</td></tr>
                    <tr><td class="py-2">1 foot</td><td>centimeters</td><td>30.48</td></tr>
                </tbody>
            </table>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Related Tools</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ config('site.url') }}/unit-converter/weight-converter" class="block bg-white border border-gray-200 hover:border-purple-300 rounded-lg p-4"><h3 class="font-semibold text-gray-900 text-sm">Weight Converter</h3></a>
            <a href="{{ config('site.url') }}/unit-converter/temperature-converter" class="block bg-white border border-gray-200 hover:border-purple-300 rounded-lg p-4"><h3 class="font-semibold text-gray-900 text-sm">Temperature Converter</h3></a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function lengthConverter() {
    return {
        value: 1, fromUnit: 'm', results: [],
        units: [
            { key: 'mm', label: 'Millimeters (mm)', toM: 0.001 },
            { key: 'cm', label: 'Centimeters (cm)', toM: 0.01 },
            { key: 'm', label: 'Meters (m)', toM: 1 },
            { key: 'km', label: 'Kilometers (km)', toM: 1000 },
            { key: 'in', label: 'Inches (in)', toM: 0.0254 },
            { key: 'ft', label: 'Feet (ft)', toM: 0.3048 },
            { key: 'yd', label: 'Yards (yd)', toM: 0.9144 },
            { key: 'mi', label: 'Miles (mi)', toM: 1609.344 },
        ],

        convert() {
            const from = this.units.find(u => u.key === this.fromUnit);
            if (!from) return;
            const meters = this.value * from.toM;
            this.results = this.units.filter(u => u.key !== this.fromUnit).map(u => ({
                unit: u.key,
                label: u.label,
                value: (meters / u.toM).toFixed(6).replace(/\.?0+$/, ''),
            }));
        },

        init() { this.convert(); },
    };
}
</script>
@endsection
