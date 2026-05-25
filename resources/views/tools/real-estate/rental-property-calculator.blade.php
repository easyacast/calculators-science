@extends('layouts.app')

@section('title', 'Rental Property Calculator - Free Online')
@section('meta_description', 'Free Analyze rental property investment returns. Step-by-step solutions and formulas included.')
@section('canonical', config('site.url') . '/real-estate/rental-property-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Rental Property Calculator",
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
            <li><a href="{{ config('site.url') }}/real-estate" class="hover:text-indigo-600">Real Estate</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Rental Property Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Rental Property Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Analyze rental property investment returns.</p>

    <div x-data="rentalPropertyCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Price ($)</label>
                <input type="number" x-model.number="price" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="250000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Down Payment (%)</label>
                <input type="number" x-model.number="downPct" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="20">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Rent ($)</label>
                <input type="number" x-model.number="rent" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Expenses ($)</label>
                <input type="number" x-model.number="expenses" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="800">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mortgage Rate (%)</label>
                <input type="number" x-model.number="rate" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="6.5">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Rental Property Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Analyze rental property investment returns. This calculator provides instant results with step-by-step explanations to help you understand the calculation process.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block text-lg font-mono">NOI, Cap Rate, Cash-on-Cash Return</p>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function rentalPropertyCalculator() {
    return {
        price: 250000,
        downPct: 20,
        rent: 2000,
        expenses: 800,
        rate: 6.5,
        calculated: false,
        result: '',
        steps: '',

        calculate() {
            try {
                let dp = this.price * this.downPct / 100;
let loan = this.price - dp;
let r = this.rate/100/12;
let mortgage = loan * r * Math.pow(1+r,360) / (Math.pow(1+r,360)-1);
let cashFlow = this.rent - this.expenses - mortgage;
let annualCF = cashFlow * 12;
let coc = (annualCF / dp * 100).toFixed(2);
this.result = '$' + cashFlow.toFixed(2) + '/month';
this.steps = 'Mortgage: $' + mortgage.toFixed(2) + '/mo\nCash flow: ' + this.result + '\nAnnual: $' + annualCF.toFixed(2) + '\nCoC return: ' + coc + '%';
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