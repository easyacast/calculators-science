@extends('layouts.app')
@section('title', 'Bernoulli Numbers Calculator')
@section('meta_description', 'Free Bernoulli Numbers Calculator. Compute Bernoulli numbers B(n) for fluid mechanics and mathematical series. Step-by-step solutions.')
@section('canonical', config('site.url') . '/physics/bernoulli-numbers-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Bernoulli Numbers Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Bernoulli Numbers Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Bernoulli Numbers Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate Bernoulli numbers used in fluid mechanics, number theory, and series expansions.</p>

    <div x-data="bernoulliNumbersCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Index (n)</label>
                <input type="number" x-model.number="n" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="6">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Bernoulli Numbers</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Bernoulli numbers are a sequence of rational numbers with deep connections to number theory, fluid mechanics, and calculus. They appear in the Taylor series expansion of many functions and in formulas for sums of powers.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center"><p class="formula-block">$$\sum_{k=0}^{n} \binom{n+1}{k} B_k = 0$$</p></div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">First Few Bernoulli Numbers</h2>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
            <li>B(0) = 1</li><li>B(1) = -1/2</li><li>B(2) = 1/6</li><li>B(4) = -1/30</li><li>B(6) = 1/42</li>
        </ul>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function bernoulliNumbersCalculator() {
    return {
        n: '', result: null, resultText: '', steps: [], error: '',
        
        calculate() {
            let n = parseInt(this.n);
            if (isNaN(n) || n < 0) { this.error = 'Please enter a non-negative integer'; return; }
            let B = [1, -0.5];
            for (let m = 2; m <= n; m++) {
                if (m % 2 === 1 && m > 1) { B[m] = 0; continue; }
                let s = 0;
                for (let k = 0; k < m; k++) {
                    let binom = 1;
                    for (let i = 0; i < k; i++) binom = binom * (m + 1 - i) / (i + 1);
                    s += binom * (B[k] || 0);
                }
                B[m] = -s / (m + 1);
            }
            this.result = (B[n] !== undefined) ? B[n] : 0;
            this.resultText = 'B(' + n + ') = ' + this.result.toFixed(10);
            this.steps = [
                {title: 'Input', text: 'n = ' + n},
                {title: 'Using recurrence relation', text: 'Sum of binomial(n+1,k) * B(k) = 0 for k=0..n'},
                {title: 'Result', text: 'B(' + n + ') = ' + this.result.toFixed(10)}
            ];
        }
    };
}
</script>
@endsection