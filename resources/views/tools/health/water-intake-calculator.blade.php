@extends('layouts.app')
@section('title', 'Water Intake Calculator')
@section('meta_description', 'Calculate recommended daily water intake.')
@section('canonical', config('site.url') . '/health/water-intake-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Water Intake Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/health" class="hover:text-indigo-600">Health</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Water Intake Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Water Intake Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate recommended daily water intake.</p>
    <div x-data="waterIntakeCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                <input type="number" x-model.number="weight" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="70">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Activity level (1-5)</label>
                <input type="number" x-model.number="activity" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="3">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-rose-600 text-white font-medium rounded-xl hover:bg-rose-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-rose-50 to-orange-50 rounded-xl p-5 border border-rose-200">
                <div class="text-xs font-medium text-rose-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Water Intake Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">General guideline: ~33 mL per kg body weight. Add more for exercise, hot weather, pregnancy, or illness.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$Water = weight(kg) \times 0.033$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function waterIntakeCalculator() {
    return {
        weight: '', activity: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let w=parseFloat(this.weight),a=parseInt(this.activity)||3;if(!w){this.error="Enter weight";return;}let base=w*0.033;let extra=[0,0.25,0.5,0.75,1.0][Math.min(a-1,4)];this.result=base+extra;this.resultText="Recommended: "+this.result.toFixed(1)+" L/day";this.steps=[{title:"Base",text:base.toFixed(1)+" L"},{title:"Activity bonus",text:extra+" L"},{title:"Total",text:this.result.toFixed(1)+" L ("+(this.result/0.237).toFixed(0)+" cups)"}]; }
    };
}
</script>
@endsection