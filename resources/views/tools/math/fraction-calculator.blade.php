@extends('layouts.app')
@section('title', 'Fraction Calculator - Add, Subtract, Multiply, Divide Fractions')
@section('meta_description', 'Free online fraction calculator. Add, subtract, multiply, and divide fractions with step-by-step solutions. Simplify fractions and convert to decimals.')
@section('canonical', config('site.url') . '/math/fraction-calculator')
@section('schema')<script type="application/ld+json">{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Fraction Calculator","applicationCategory":"CalculatorApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}</script>@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6"><ol class="flex items-center gap-2 text-sm text-gray-500"><li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li><li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li><li><a href="{{ config('site.url') }}/math" class="hover:text-indigo-600">Mathematics</a></li><li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li><li class="text-gray-900 font-medium">Fraction Calculator</li></ol></nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Fraction Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Add, subtract, multiply, or divide two fractions with step-by-step solutions. Results are automatically simplified.</p>

    <div x-data="fractionCalc()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="flex items-center gap-3 flex-wrap mb-4">
            <div class="text-center"><label class="text-xs text-gray-500 block">Numerator</label><input type="number" x-model.number="n1" class="w-20 px-2 py-2 border border-gray-300 rounded-lg text-sm text-center" placeholder="1"><hr class="border-gray-400 my-1"><label class="text-xs text-gray-500 block">Denominator</label><input type="number" x-model.number="d1" class="w-20 px-2 py-2 border border-gray-300 rounded-lg text-sm text-center" placeholder="2"></div>
            <select x-model="op" class="px-3 py-2 border border-gray-300 rounded-lg text-lg font-bold"><option value="+">+</option><option value="-">-</option><option value="*">×</option><option value="/">÷</option></select>
            <div class="text-center"><label class="text-xs text-gray-500 block">Numerator</label><input type="number" x-model.number="n2" class="w-20 px-2 py-2 border border-gray-300 rounded-lg text-sm text-center" placeholder="1"><hr class="border-gray-400 my-1"><label class="text-xs text-gray-500 block">Denominator</label><input type="number" x-model.number="d2" class="w-20 px-2 py-2 border border-gray-300 rounded-lg text-sm text-center" placeholder="3"></div>
            <button @click="calculate()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700">=</button>
        </div>
        <div x-show="result" x-cloak class="mt-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-5 border border-indigo-100">
            <div class="text-xs font-medium text-indigo-500 uppercase tracking-wider mb-1">Result</div>
            <div class="text-xl font-bold text-gray-900" x-text="result"></div>
            <div class="text-sm text-gray-600 mt-1" x-text="decimal"></div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">How to Work with Fractions</h2>
        <p class="text-gray-600 leading-relaxed mb-4">A fraction represents a part of a whole. It has a numerator (top number) and a denominator (bottom number). To add or subtract fractions, you need a common denominator. To multiply, multiply straight across. To divide, multiply by the reciprocal.</p>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Fraction Operations</h2>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center"><p class="formula-block">$$\frac{a}{b} + \frac{c}{d} = \frac{ad + bc}{bd}$$</p></div>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center"><p class="formula-block">$$\frac{a}{b} \times \frac{c}{d} = \frac{ac}{bd}$$</p></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function fractionCalc() {
    function gcd(a, b) { a = Math.abs(a); b = Math.abs(b); while (b) { [a, b] = [b, a % b]; } return a; }
    return {
        n1: 1, d1: 2, n2: 1, d2: 3, op: '+', result: null, decimal: '',
        calculate() {
            if (this.d1 === 0 || this.d2 === 0) { this.result = 'Denominator cannot be zero'; return; }
            let rn, rd;
            if (this.op === '+') { rn = this.n1 * this.d2 + this.n2 * this.d1; rd = this.d1 * this.d2; }
            else if (this.op === '-') { rn = this.n1 * this.d2 - this.n2 * this.d1; rd = this.d1 * this.d2; }
            else if (this.op === '*') { rn = this.n1 * this.n2; rd = this.d1 * this.d2; }
            else { if (this.n2 === 0) { this.result = 'Cannot divide by zero'; return; } rn = this.n1 * this.d2; rd = this.d1 * this.n2; }
            const g = gcd(rn, rd);
            rn /= g; rd /= g;
            if (rd < 0) { rn = -rn; rd = -rd; }
            this.result = rd === 1 ? `${rn}` : `${rn}/${rd}`;
            this.decimal = `Decimal: ${(rn / rd).toFixed(6)}`;
        },
    };
}
</script>
@endsection
