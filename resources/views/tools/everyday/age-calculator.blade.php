@extends('layouts.app')
@section('title', 'Age Calculator')
@section('meta_description', 'Calculate exact age in years, months, and days.')
@section('canonical', config('site.url') . '/everyday/age-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Age Calculator","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/everyday" class="hover:text-indigo-600">Everyday Tools</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Age Calculator</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Age Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate exact age in years, months, and days.</p>
    <div x-data="ageCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Birth Year</label>
                <input type="number" x-model.number="year" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" placeholder="1990">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Birth Month</label>
                <input type="number" x-model.number="month" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" placeholder="6">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Birth Day</label>
                <input type="number" x-model.number="day" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500" placeholder="15">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-violet-600 text-white font-medium rounded-xl hover:bg-violet-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-violet-50 to-orange-50 rounded-xl p-5 border border-violet-200">
                <div class="text-xs font-medium text-violet-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-violet-100 text-violet-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Age Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Calculate your exact age including months and days, total days lived, and countdown to next birthday.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$age = today - birthdate$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function ageCalculator() {
    return {
        year: '', month: '', day: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let y=parseInt(this.year),m=parseInt(this.month),d=parseInt(this.day);if(!y||!m||!d){this.error="Enter date";return;}let birth=new Date(y,m-1,d);let today=new Date();let years=today.getFullYear()-birth.getFullYear();let months=today.getMonth()-birth.getMonth();let days=today.getDate()-birth.getDate();if(days<0){months--;days+=new Date(today.getFullYear(),today.getMonth(),0).getDate();}if(months<0){years--;months+=12;}let totalDays=Math.floor((today-birth)/(86400000));this.result=years;this.resultText=years+" years, "+months+" months, "+days+" days";this.steps=[{title:"Age",text:years+" years, "+months+" months, "+days+" days"},{title:"Total days",text:totalDays.toLocaleString()},{title:"Total weeks",text:Math.floor(totalDays/7).toLocaleString()},{title:"Next birthday",text:Math.ceil((new Date(today.getFullYear()+(today>new Date(today.getFullYear(),m-1,d)?1:0),m-1,d)-today)/86400000)+" days away"}]; }
    };
}
</script>
@endsection