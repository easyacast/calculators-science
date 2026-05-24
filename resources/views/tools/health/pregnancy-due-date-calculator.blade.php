@extends('layouts.app')
@section('title', 'Pregnancy Due Date Calculator')
@section('meta_description', 'Calculate estimated due date from last menstrual period.')
@section('canonical', config('site.url') . '/health/pregnancy-due-date-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Pregnancy Due Date Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
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
            <li class="text-gray-900 font-medium">Pregnancy Due Date Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Pregnancy Due Date Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate estimated due date from last menstrual period.</p>
    <div x-data="pregnancyDueDateCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">LMP Year</label>
                <input type="number" x-model.number="year" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="2024">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">LMP Month</label>
                <input type="number" x-model.number="month" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">LMP Day</label>
                <input type="number" x-model.number="day" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-rose-500" placeholder="15">
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
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Pregnancy Due Date Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Naegele's rule: due date = LMP + 280 days (40 weeks). First trimester: weeks 1-12, second: 13-26, third: 27-40.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$EDD = LMP + 280\text{ days}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function pregnancyDueDateCalculator() {
    return {
        year: '', month: '', day: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let y=parseInt(this.year),m=parseInt(this.month),d=parseInt(this.day);if(!y||!m||!d){this.error="Enter date";return;}let lmp=new Date(y,m-1,d);let edd=new Date(lmp.getTime()+280*24*60*60*1000);let today=new Date();let weeks=Math.floor((today-lmp)/(7*24*60*60*1000));this.result=280;this.resultText="Due date: "+edd.toDateString();this.steps=[{title:"LMP",text:lmp.toDateString()},{title:"Due date (40 weeks)",text:edd.toDateString()},{title:"Current week",text:"~"+weeks}]; }
    };
}
</script>
@endsection