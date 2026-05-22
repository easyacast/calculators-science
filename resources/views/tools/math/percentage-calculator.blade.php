@extends('layouts.app')

@section('title', 'Percentage Calculator - Calculate Percentages Online')
@section('meta_description', 'Free online percentage calculator. Find what percent of a number is, calculate percentage increase or decrease, and convert fractions to percentages with step-by-step explanations.')
@section('canonical', config('site.url') . '/math/percentage-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Percentage Calculator",
    "applicationCategory": "CalculatorApplication",
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
            <li><a href="{{ config('site.url') }}/math" class="hover:text-indigo-600">Mathematics</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Percentage Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Percentage Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate percentages quickly and accurately. Find what percent of a number is, compute percentage change, or convert between fractions and percentages.</p>

    {{-- Calculator --}}
    <div x-data="percentCalc()" class="space-y-6 mb-12">
        {{-- Mode Tabs --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="flex border-b border-gray-200">
                <button @click="calcMode = 'whatIs'" :class="calcMode === 'whatIs' ? 'border-b-2 border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'text-gray-500'" class="flex-1 py-3 px-4 text-sm font-medium">What is X% of Y?</button>
                <button @click="calcMode = 'whatPercent'" :class="calcMode === 'whatPercent' ? 'border-b-2 border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'text-gray-500'" class="flex-1 py-3 px-4 text-sm font-medium">X is what % of Y?</button>
                <button @click="calcMode = 'change'" :class="calcMode === 'change' ? 'border-b-2 border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'text-gray-500'" class="flex-1 py-3 px-4 text-sm font-medium">% Change</button>
            </div>
            <div class="p-6">
                {{-- What is X% of Y --}}
                <div x-show="calcMode === 'whatIs'" class="flex flex-wrap items-end gap-3">
                    <span class="text-gray-700">What is</span>
                    <input type="number" x-model.number="pct" class="w-24 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="25">
                    <span class="text-gray-700">% of</span>
                    <input type="number" x-model.number="val1" class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="200">
                    <span class="text-gray-700">?</span>
                    <button @click="calcWhatIs()" class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Calculate</button>
                </div>

                {{-- X is what % of Y --}}
                <div x-show="calcMode === 'whatPercent'" x-cloak class="flex flex-wrap items-end gap-3">
                    <input type="number" x-model.number="val1" class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="50">
                    <span class="text-gray-700">is what % of</span>
                    <input type="number" x-model.number="val2" class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="200">
                    <span class="text-gray-700">?</span>
                    <button @click="calcWhatPercent()" class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Calculate</button>
                </div>

                {{-- % Change --}}
                <div x-show="calcMode === 'change'" x-cloak class="flex flex-wrap items-end gap-3">
                    <div>
                        <label class="text-xs text-gray-500">From</label>
                        <input type="number" x-model.number="val1" class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="80">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">To</label>
                        <input type="number" x-model.number="val2" class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-sm" placeholder="100">
                    </div>
                    <button @click="calcChange()" class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Calculate</button>
                </div>

                {{-- Result --}}
                <div x-show="answer !== null" x-cloak class="mt-5 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100">
                    <div class="text-xs font-medium text-indigo-500 uppercase tracking-wider mb-1">Result</div>
                    <div class="text-xl font-bold text-gray-900" x-text="answer"></div>
                    <p class="text-sm text-gray-600 mt-1" x-text="explanation"></p>
                </div>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    {{-- Educational Content --}}
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">What is a Percentage?</h2>
        <p class="text-gray-600 leading-relaxed mb-4">A percentage is a way of expressing a number as a fraction of 100. The word itself comes from the Latin "per centum," meaning "by the hundred." When you see 25%, it simply means 25 out of every 100. Percentages are used everywhere in daily life, from sales discounts and tax rates to exam scores and statistical data.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">The Percentage Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block">$$\text{Percentage} = \frac{\text{Part}}{\text{Whole}} \times 100$$</p>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Example</h2>
        <p class="text-gray-600 mb-6">What is 15% of 240? Using the formula: $\frac{15}{100} \times 240 = 36$. So 15% of 240 is <strong>36</strong>.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Related Tools</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ config('site.url') }}/math/quadratic-equation-calculator" class="block bg-white border border-gray-200 hover:border-indigo-300 rounded-lg p-4"><h3 class="font-semibold text-gray-900 text-sm">Quadratic Equation Calculator</h3></a>
            <a href="{{ config('site.url') }}/finance/compound-interest-calculator" class="block bg-white border border-gray-200 hover:border-indigo-300 rounded-lg p-4"><h3 class="font-semibold text-gray-900 text-sm">Compound Interest Calculator</h3></a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function percentCalc() {
    return {
        calcMode: 'whatIs', pct: 25, val1: 200, val2: 100, answer: null, explanation: '',

        calcWhatIs() {
            const r = (this.pct / 100) * this.val1;
            this.answer = r.toFixed(2);
            this.explanation = `${this.pct}% of ${this.val1} = (${this.pct}/100) x ${this.val1} = ${r.toFixed(2)}`;
        },
        calcWhatPercent() {
            if (this.val2 === 0) { this.answer = 'Cannot divide by zero'; return; }
            const r = (this.val1 / this.val2) * 100;
            this.answer = r.toFixed(2) + '%';
            this.explanation = `${this.val1} is ${r.toFixed(2)}% of ${this.val2}. Formula: (${this.val1}/${this.val2}) x 100 = ${r.toFixed(2)}%`;
        },
        calcChange() {
            if (this.val1 === 0) { this.answer = 'Cannot divide by zero'; return; }
            const r = ((this.val2 - this.val1) / Math.abs(this.val1)) * 100;
            this.answer = (r >= 0 ? '+' : '') + r.toFixed(2) + '%';
            this.explanation = `Change from ${this.val1} to ${this.val2} is ${r.toFixed(2)}%. Formula: ((${this.val2} - ${this.val1}) / |${this.val1}|) x 100`;
        },
    };
}
</script>
@endsection
