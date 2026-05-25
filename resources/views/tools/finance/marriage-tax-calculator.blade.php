@extends('layouts.app')

@section('title', 'Marriage Tax Calculator - Free Online')
@section('meta_description', 'Free Compare taxes filing jointly vs separately. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/finance/marriage-tax-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Marriage Tax Calculator",
    "applicationCategory": "FinanceApplication",
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
            <li><a href="{{ config('site.url') }}/finance" class="hover:text-indigo-600">Finance</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Marriage Tax Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Marriage Tax Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Compare taxes filing jointly vs separately.</p>

    <div x-data="marriageTaxCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Spouse 1 Income ($)</label>
                <input type="number" x-model.number="income1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="60000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Spouse 2 Income ($)</label>
                <input type="number" x-model.number="income2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="50000">
            </div>
        </div>

        <button @click="calculate()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Calculate</button>

        <div x-show="calculated" x-cloak class="mt-6">
            <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-200 text-center mb-4">
                <div class="text-xs text-indigo-600 font-medium uppercase mb-1">Result</div>
                <div class="text-2xl font-bold text-gray-900" x-text="result"></div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <h3 class="font-semibold text-gray-900 text-sm mb-2">Step-by-Step Solution</h3>
                <pre class="text-sm text-gray-700 whitespace-pre-wrap" x-text="steps"></pre>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Marriage Tax Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Compare taxes filing jointly vs separately. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">Compare single vs married filing jointly</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function marriageTaxCalculator() {
    return {
        income1: 60000,
        income2: 50000,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                function calcTax(inc, married) {
  let b = married ? [[23200,.10],[94300,.12],[201050,.22],[383900,.24]] : [[11600,.10],[47150,.12],[100525,.22],[191950,.24]];
  let tax = 0, prev = 0;
  for(let [l,r] of b) { if(inc<=l){tax+=(inc-prev)*r;break;} tax+=(l-prev)*r;prev=l; }
  return tax;
}
let single = calcTax(this.income1,false) + calcTax(this.income2,false);
let joint = calcTax(this.income1+this.income2,true);
let diff = joint - single;
this.result = (diff > 0 ? 'Penalty' : 'Bonus') + ': $' + Math.abs(Math.round(diff)).toLocaleString();
this.steps = 'Filing separately: $' + Math.round(single).toLocaleString() + '\nFiling jointly: $' + Math.round(joint).toLocaleString() + '\nMarriage ' + this.result;
                this.calculated = true;
            } catch(e) {
                this.result = 'Error: Please check your inputs';
                this.steps = e.message;
                this.calculated = true;
            }
        },
    };
}
</script>
@endsection