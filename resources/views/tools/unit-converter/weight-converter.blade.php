@extends('layouts.app')
@section('title', 'Weight Converter - Convert Between Mass Units')
@section('meta_description', 'Free weight converter. Convert between kilograms, pounds, ounces, grams, stones, and more mass units instantly.')
@section('canonical', config('site.url') . '/unit-converter/weight-converter')
@section('schema')<script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Weight Converter","applicationCategory":"UtilityApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}</script>@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6"><ol class="flex items-center gap-2 text-sm text-gray-500"><li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li><li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li><li><a href="{{ config('site.url') }}/unit-converter" class="hover:text-indigo-600">Unit Converters</a></li><li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li><li class="text-gray-900 font-medium">Weight Converter</li></ol></nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Weight / Mass Converter</h1>
    <p class="text-lg text-gray-600 mb-8">Convert between different units of weight and mass including kilograms, pounds, ounces, grams, and stones.</p>

    <div x-data="weightConv()" x-init="convert()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Value</label><input type="number" x-model.number="value" @input="convert()" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="1"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">From</label><select x-model="fromUnit" @change="convert()" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm"><template x-for="u in units" :key="u.key"><option :value="u.key" x-text="u.label"></option></template></select></div>
        </div>
        <div x-show="results.length > 0" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-2">
            <template x-for="r in results" :key="r.unit"><div class="flex justify-between items-center bg-gray-50 rounded-lg px-4 py-2.5 border border-gray-100"><span class="text-sm text-gray-600" x-text="r.label"></span><span class="font-mono text-sm font-semibold text-gray-900" x-text="r.value"></span></div></template>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Common Weight Conversions</h2>
        <table class="w-full text-sm text-gray-600 mb-6"><thead><tr class="border-b"><th class="text-left py-2">From</th><th class="text-left py-2">To</th><th class="text-left py-2">Factor</th></tr></thead><tbody><tr class="border-b border-gray-100"><td class="py-2">1 kg</td><td>pounds</td><td>2.20462</td></tr><tr class="border-b border-gray-100"><td class="py-2">1 pound</td><td>ounces</td><td>16</td></tr><tr><td class="py-2">1 stone</td><td>pounds</td><td>14</td></tr></tbody></table>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function weightConv() {
    return {
        value: 1, fromUnit: 'kg', results: [],
        units: [
            { key: 'mg', label: 'Milligrams (mg)', toKg: 0.000001 },
            { key: 'g', label: 'Grams (g)', toKg: 0.001 },
            { key: 'kg', label: 'Kilograms (kg)', toKg: 1 },
            { key: 'oz', label: 'Ounces (oz)', toKg: 0.0283495 },
            { key: 'lb', label: 'Pounds (lb)', toKg: 0.453592 },
            { key: 'st', label: 'Stones (st)', toKg: 6.35029 },
            { key: 't', label: 'Metric Tons (t)', toKg: 1000 },
        ],
        convert() {
            const from = this.units.find(u => u.key === this.fromUnit);
            if (!from) return;
            const kg = this.value * from.toKg;
            this.results = this.units.filter(u => u.key !== this.fromUnit).map(u => ({
                unit: u.key, label: u.label,
                value: (kg / u.toKg).toFixed(6).replace(/\.?0+$/, ''),
            }));
        },
    };
}
</script>
@endsection
