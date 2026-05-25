@extends('layouts.app')

@section('title', 'Quadratic Equation Calculator & Solver')
@section('meta_description', 'Free online quadratic equation calculator. Solve ax² + bx + c = 0 with step-by-step solutions, discriminant analysis, and interactive parabola graph. Learn the quadratic formula with examples.')
@section('canonical', config('site.url') . '/math/quadratic-equation-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Quadratic Equation Calculator",
    "applicationCategory": "CalculatorApplication",
    "operatingSystem": "Web",
    "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
    "description": "Solve quadratic equations ax² + bx + c = 0 with detailed step-by-step solutions and interactive parabola graphing."
}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/math" class="hover:text-indigo-600">Mathematics</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Quadratic Equation Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Quadratic Equation Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Solve any quadratic equation in the form $ax^2 + bx + c = 0$ with detailed steps, discriminant analysis, and a visual graph of the parabola.</p>

    {{-- Calculator --}}
    <div x-data="quadraticCalc()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Enter Coefficients</h2>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">a (x² coefficient)</label>
                <input type="number" x-model.number="a" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">b (x coefficient)</label>
                <input type="number" x-model.number="b" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="5">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">c (constant)</label>
                <input type="number" x-model.number="c" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="-3">
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-3 mb-4 text-center text-sm text-gray-700">
            Equation: <span class="font-mono font-semibold" x-text="`${a}x² + ${b}x + ${c} = 0`"></span>
        </div>

        <button @click="solve()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
            Solve Equation
        </button>

        {{-- Results --}}
        <div x-show="solved" x-cloak class="mt-6 space-y-4">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-5 border border-indigo-100">
                <div class="text-xs font-medium text-indigo-500 uppercase tracking-wider mb-1">Solution</div>
                <div class="text-xl font-bold text-gray-900" x-text="result"></div>
            </div>

            <div class="space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4">
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4>
                                <p class="text-gray-600 text-sm mt-1" x-text="step.text"></p>
                                <div x-show="step.formula" class="mt-2 bg-gray-50 rounded-lg px-3 py-2 font-mono text-sm text-gray-800" x-text="step.formula"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Simple SVG Graph --}}
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                <h3 class="font-semibold text-gray-900 text-sm mb-3">Parabola Graph</h3>
                <svg :viewBox="`0 0 400 300`" class="w-full max-w-lg mx-auto">
                    <line x1="0" y1="150" x2="400" y2="150" stroke="#d1d5db" stroke-width="1"/>
                    <line x1="200" y1="0" x2="200" y2="300" stroke="#d1d5db" stroke-width="1"/>
                    <path :d="graphPath" fill="none" stroke="#4f46e5" stroke-width="2.5"/>
                    <template x-for="root in roots" :key="root">
                        <circle :cx="200 + root * 30" cy="150" r="5" fill="#dc2626"/>
                    </template>
                </svg>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    {{-- Educational Content --}}
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">What is a Quadratic Equation?</h2>
        <p class="text-gray-600 leading-relaxed mb-4">
            A quadratic equation is a second-degree polynomial equation in a single variable x, with the general form $ax^2 + bx + c = 0$, where $a \neq 0$. The word "quadratic" comes from the Latin word "quadratus," which means "square." These equations appear everywhere in science and engineering, from projectile motion in physics to profit optimization in business.
        </p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">The Quadratic Formula</h2>
        <p class="text-gray-600 leading-relaxed mb-3">
            The most reliable method for solving any quadratic equation is the quadratic formula:
        </p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center">
            <p class="formula-block">$$x = \frac{-b \pm \sqrt{b^2 - 4ac}}{2a}$$</p>
        </div>
        <p class="text-gray-600 leading-relaxed mb-6">
            The expression under the square root, $b^2 - 4ac$, is called the <strong>discriminant</strong> (D). It tells you the nature of the roots:
        </p>
        <ul class="list-disc list-inside text-gray-600 space-y-2 mb-6">
            <li>If $D > 0$: Two distinct real roots</li>
            <li>If $D = 0$: One repeated real root (the parabola touches the x-axis at one point)</li>
            <li>If $D < 0$: Two complex conjugate roots (the parabola does not cross the x-axis)</li>
        </ul>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Step-by-Step Example</h2>
        <p class="text-gray-600 mb-3">Solve $3x^2 - 12x + 9 = 0$:</p>
        <ol class="list-decimal list-inside text-gray-600 space-y-2 mb-6">
            <li>Identify: $a = 3$, $b = -12$, $c = 9$</li>
            <li>Discriminant: $D = (-12)^2 - 4(3)(9) = 144 - 108 = 36$</li>
            <li>Since $D > 0$, there are two real roots</li>
            <li>$x_1 = \frac{12 + 6}{6} = 3$ and $x_2 = \frac{12 - 6}{6} = 1$</li>
        </ol>

        {{-- FAQ --}}
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
        <div class="space-y-3 mb-8">
            <details class="bg-gray-50 rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">Can a = 0 in a quadratic equation?</summary>
                <p class="text-sm text-gray-600 mt-2">No. If a = 0, the equation becomes linear (bx + c = 0), not quadratic. The coefficient 'a' must be non-zero for the equation to be quadratic.</p>
            </details>
            <details class="bg-gray-50 rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">What are complex roots?</summary>
                <p class="text-sm text-gray-600 mt-2">Complex roots occur when the discriminant is negative. They come in conjugate pairs like 2 + 3i and 2 - 3i, where i is the imaginary unit (square root of -1).</p>
            </details>
        </div>

        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function quadraticCalc() {
    return {
        a: 2, b: 5, c: -3,
        solved: false, result: '', steps: [], roots: [], graphPath: '',

        solve() {
            if (this.a === 0) { this.result = 'Coefficient "a" cannot be zero.'; this.solved = true; this.steps = []; return; }

            const disc = this.b * this.b - 4 * this.a * this.c;
            this.steps = [
                { title: 'Identify coefficients', text: `a = ${this.a}, b = ${this.b}, c = ${this.c}`, formula: `${this.a}x² + ${this.b}x + ${this.c} = 0` },
                { title: 'Calculate discriminant (D)', text: `D = b² - 4ac = (${this.b})² - 4(${this.a})(${this.c})`, formula: `D = ${this.b * this.b} - ${4 * this.a * this.c} = ${disc}` },
            ];

            this.roots = [];
            if (disc > 0) {
                const x1 = (-this.b + Math.sqrt(disc)) / (2 * this.a);
                const x2 = (-this.b - Math.sqrt(disc)) / (2 * this.a);
                this.roots = [x1, x2];
                this.result = `x₁ = ${x1.toFixed(4)}, x₂ = ${x2.toFixed(4)}`;
                this.steps.push({ title: 'Two real roots (D > 0)', text: `Apply the quadratic formula for both roots.`, formula: `x = (-${this.b} ± √${disc}) / ${2 * this.a}` });
            } else if (disc === 0) {
                const x = -this.b / (2 * this.a);
                this.roots = [x];
                this.result = `x = ${x.toFixed(4)} (repeated root)`;
                this.steps.push({ title: 'One repeated root (D = 0)', text: `The parabola touches the x-axis at exactly one point.`, formula: `x = -${this.b} / ${2 * this.a} = ${x.toFixed(4)}` });
            } else {
                const real = -this.b / (2 * this.a);
                const imag = Math.sqrt(-disc) / (2 * this.a);
                this.result = `x = ${real.toFixed(4)} ± ${imag.toFixed(4)}i`;
                this.steps.push({ title: 'Complex roots (D < 0)', text: `The discriminant is negative, so roots are complex conjugates.`, formula: `x = ${real.toFixed(4)} ± ${imag.toFixed(4)}i` });
            }

            // Generate graph path
            let d = '';
            for (let px = 0; px <= 400; px += 2) {
                const x = (px - 200) / 30;
                const y = this.a * x * x + this.b * x + this.c;
                const sy = 150 - y * 10;
                if (sy > -50 && sy < 350) {
                    d += (d === '' ? 'M' : 'L') + ` ${px} ${sy}`;
                }
            }
            this.graphPath = d;
            this.solved = true;
        }
    };
}
</script>
@endsection
