@extends('layouts.app')
@section('title', "Newton's Force Calculator (F = ma)")
@section('meta_description', "Free Newton's Second Law calculator. Calculate force, mass, or acceleration with step-by-step solutions. Learn F = ma with real-world examples.")
@section('canonical', config('site.url') . '/physics/newton-force-calculator')

@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Newton Force Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Newton's Force Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Newton's Force Calculator (F = ma)</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate force, mass, or acceleration using Newton's Second Law of Motion. Enter any two values and the calculator will find the third.</p>

    <div x-data="newtonCalc()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="flex gap-3 mb-4">
            <button @click="solveFor = 'force'" :class="solveFor === 'force' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Find Force</button>
            <button @click="solveFor = 'mass'" :class="solveFor === 'mass' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Find Mass</button>
            <button @click="solveFor = 'acceleration'" :class="solveFor === 'acceleration' ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded-lg text-sm font-medium">Find Acceleration</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div x-show="solveFor !== 'force'">
                <label class="block text-sm font-medium text-gray-700 mb-1">Force (N)</label>
                <input type="number" x-model.number="force" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="10">
            </div>
            <div x-show="solveFor !== 'mass'">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mass (kg)</label>
                <input type="number" x-model.number="mass" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="5">
            </div>
            <div x-show="solveFor !== 'acceleration'">
                <label class="block text-sm font-medium text-gray-700 mb-1">Acceleration (m/s²)</label>
                <input type="number" x-model.number="acceleration" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" placeholder="2">
            </div>
        </div>

        <button @click="calculate()" class="px-6 py-2.5 bg-amber-600 text-white font-medium rounded-xl hover:bg-amber-700 transition-colors">Calculate</button>

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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Newton's Second Law of Motion</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Newton's Second Law states that the force acting on an object is equal to the mass of that object multiplied by its acceleration. It is one of the most fundamental equations in physics.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-center"><p class="formula-block">$$F = m \times a$$</p></div>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
            <li><strong>F</strong> = Force in Newtons (N)</li>
            <li><strong>m</strong> = Mass in kilograms (kg)</li>
            <li><strong>a</strong> = Acceleration in meters per second squared (m/s²)</li>
        </ul>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Example</h2>
        <p class="text-gray-600 mb-6">A 1,500 kg car accelerates at 3 m/s². What is the net force? $F = 1500 \times 3 = 4,500$ N. That is 4,500 Newtons of force.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Related Tools</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ config('site.url') }}/physics/velocity-calculator" class="block bg-white border border-gray-200 hover:border-amber-300 rounded-lg p-4"><h3 class="font-semibold text-gray-900 text-sm">Velocity Calculator</h3></a>
            <a href="{{ config('site.url') }}/math/ai-math-solver" class="block bg-white border border-gray-200 hover:border-amber-300 rounded-lg p-4"><h3 class="font-semibold text-gray-900 text-sm">AI Math Solver</h3></a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function newtonCalc() {
    return {
        solveFor: 'force', force: 10, mass: 5, acceleration: 2,
        result: null, resultText: '', steps: [],

        calculate() {
            this.steps = [];
            if (this.solveFor === 'force') {
                this.result = this.mass * this.acceleration;
                this.resultText = `Force = ${this.result.toFixed(4)} N`;
                this.steps = [
                    { title: 'Identify given values', text: `Mass = ${this.mass} kg, Acceleration = ${this.acceleration} m/s²` },
                    { title: 'Apply formula F = m × a', text: `F = ${this.mass} × ${this.acceleration} = ${this.result.toFixed(4)} N` },
                ];
            } else if (this.solveFor === 'mass') {
                if (this.acceleration === 0) { this.resultText = 'Acceleration cannot be zero'; return; }
                this.result = this.force / this.acceleration;
                this.resultText = `Mass = ${this.result.toFixed(4)} kg`;
                this.steps = [
                    { title: 'Identify given values', text: `Force = ${this.force} N, Acceleration = ${this.acceleration} m/s²` },
                    { title: 'Apply formula m = F / a', text: `m = ${this.force} / ${this.acceleration} = ${this.result.toFixed(4)} kg` },
                ];
            } else {
                if (this.mass === 0) { this.resultText = 'Mass cannot be zero'; return; }
                this.result = this.force / this.mass;
                this.resultText = `Acceleration = ${this.result.toFixed(4)} m/s²`;
                this.steps = [
                    { title: 'Identify given values', text: `Force = ${this.force} N, Mass = ${this.mass} kg` },
                    { title: 'Apply formula a = F / m', text: `a = ${this.force} / ${this.mass} = ${this.result.toFixed(4)} m/s²` },
                ];
            }
        },
    };
}
</script>
@endsection
