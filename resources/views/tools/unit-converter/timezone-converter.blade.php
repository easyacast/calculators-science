@extends('layouts.app')
@section('title', 'Timezone Converter')
@section('meta_description', 'Convert time between UTC offsets.')
@section('canonical', config('site.url') . '/unit-converter/timezone-converter')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Timezone Converter","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/unit-converter" class="hover:text-indigo-600">Unit Converters</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Timezone Converter</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Timezone Converter</h1>
    <p class="text-lg text-gray-600 mb-8">Convert time between UTC offsets.</p>
    <div x-data="timezoneConverter()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hour (0-23)</label>
                <input type="number" x-model.number="hour" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="14">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Minute (0-59)</label>
                <input type="number" x-model.number="min" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="30">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From UTC offset (e.g. -5)</label>
                <input type="number" x-model.number="fromOff" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To UTC offset (e.g. +5.5)</label>
                <input type="number" x-model.number="toOff" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="5.5">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-purple-600 text-white font-medium rounded-xl hover:bg-purple-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-purple-50 to-orange-50 rounded-xl p-5 border border-purple-200">
                <div class="text-xs font-medium text-purple-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Timezone Converter</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Time zones are expressed as UTC offsets. EST = UTC-5, IST = UTC+5:30, JST = UTC+9.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$time_{target} = time_{source} + (offset_{target} - offset_{source})$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function timezoneConverter() {
    return {
        hour: '', min: '', fromOff: '', toOff: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let h=parseInt(this.hour),m=parseInt(this.min)||0,fo=parseFloat(this.fromOff)||0,to2=parseFloat(this.toOff)||0;if(isNaN(h)||h<0||h>23){this.error="Enter valid hour";return;}let totalMin=h*60+m+(to2-fo)*60;totalMin=((totalMin%1440)+1440)%1440;let newH=Math.floor(totalMin/60),newM=Math.round(totalMin%60);this.result=newH;this.resultText=String(newH).padStart(2,"0")+":"+String(newM).padStart(2,"0");this.steps=[{title:"Source",text:String(h).padStart(2,"0")+":"+String(m).padStart(2,"0")+" UTC"+(fo>=0?"+":"")+fo},{title:"Target",text:this.resultText+" UTC"+(to2>=0?"+":"")+to2},{title:"Difference",text:(to2-fo)+" hours"}]; }
    };
}
</script>
@endsection