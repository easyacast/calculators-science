@extends('layouts.app')

@section('title', 'Compound Interest Calculator - Free Online')
@section('meta_description', 'Free compound interest calculator. Calculate how your savings or investments grow over time with monthly, quarterly, or yearly compounding. Includes formula breakdown and growth chart.')
@section('canonical', config('site.url') . '/finance/compound-interest-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Compound Interest Calculator",
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
            <li class="text-gray-900 font-medium">Compound Interest Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Compound Interest Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">See how your money grows with compound interest. Enter principal, rate, time, and compounding frequency to visualize your investment growth.</p>

    <div x-data="compoundCalc()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Principal Amount ($)</label>
                <input type="number" x-model.number="principal" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10000">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Annual Interest Rate (%)</label>
                <input type="number" x-model.number="rate" step="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="7">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Time Period (years)</label>
                <input type="number" x-model.number="years" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="10">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Compounding Frequency</label>
                <select x-model.number="frequency" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="1">Annually</option>
                    <option value="2">Semi-Annually</option>
                    <option value="4">Quarterly</option>
                    <option value="12">Monthly</option>
                    <option value="365">Daily</option>
                </select>
            </div>
        </div>

        <button @click="calculate()" class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors">Calculate</button>

        <div x-show="calculated" x-cloak class="mt-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-green-50 rounded-xl p-4 border border-green-200 text-center">
                    <div class="text-xs text-green-600 font-medium uppercase mb-1">Total Amount</div>
                    <div class="text-2xl font-bold text-gray-900" x-text="'$' + totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></div>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 border border-blue-200 text-center">
                    <div class="text-xs text-blue-600 font-medium uppercase mb-1">Interest Earned</div>
                    <div class="text-2xl font-bold text-gray-900" x-text="'$' + interestEarned.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></div>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 border border-purple-200 text-center">
                    <div class="text-xs text-purple-600 font-medium uppercase mb-1">Total Return</div>
                    <div class="text-2xl font-bold text-gray-900" x-text="returnPercent.toFixed(1) + '%'"></div>
                </div>
            </div>

            {{-- Growth Chart (SVG bar chart) --}}
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <h3 class="font-semibold text-gray-900 text-sm mb-3">Year-by-Year Growth</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b border-gray-200 text-gray-500"><th class="text-left py-2 px-2">Year</th><th class="text-right py-2 px-2">Balance</th><th class="text-right py-2 px-2">Interest</th></tr></thead>
                        <tbody>
                            <template x-for="row in yearlyData.slice(0, 20)" :key="row.year">
                                <tr class="border-b border-gray-100">
                                    <td class="py-1.5 px-2" x-text="row.year"></td>
                                    <td class="py-1.5 px-2 text-right font-mono" x-text="'$' + row.balance.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                    <td class="py-1.5 px-2 text-right font-mono text-green-600" x-text="'$' + row.interest.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">What is Compound Interest?</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Compound interest is interest calculated on the initial principal and also on the accumulated interest from previous periods. Albert Einstein reportedly called it "the eighth wonder of the world." Unlike simple interest, which only earns on the original amount, compound interest lets your money grow exponentially over time.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">The Compound Interest Formula</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block">$$A = P\left(1 + \frac{r}{n}\right)^{nt}$$</p>
        </div>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
            <li><strong>A</strong> = Final amount</li>
            <li><strong>P</strong> = Principal (initial investment)</li>
            <li><strong>r</strong> = Annual interest rate (decimal)</li>
            <li><strong>n</strong> = Number of times compounded per year</li>
            <li><strong>t</strong> = Number of years</li>
        </ul>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Example</h2>
        <p class="text-gray-600 mb-6">If you invest $10,000 at 7% annually compounded monthly for 10 years: $A = 10000(1 + 0.07/12)^{120} = $20,096.61$. Your money doubles in about 10 years.</p>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function compoundCalc() {
    return {
        principal: 10000, rate: 7, years: 10, frequency: 12,
        calculated: false, totalAmount: 0, interestEarned: 0, returnPercent: 0, yearlyData: [],

        calculate() {
            const r = this.rate / 100;
            const n = this.frequency;
            this.totalAmount = this.principal * Math.pow(1 + r / n, n * this.years);
            this.interestEarned = this.totalAmount - this.principal;
            this.returnPercent = (this.interestEarned / this.principal) * 100;

            this.yearlyData = [];
            for (let y = 1; y <= this.years; y++) {
                const balance = this.principal * Math.pow(1 + r / n, n * y);
                const prevBalance = y === 1 ? this.principal : this.principal * Math.pow(1 + r / n, n * (y - 1));
                this.yearlyData.push({ year: y, balance, interest: balance - prevBalance });
            }
            this.calculated = true;
        },
    };
}
</script>
@endsection
