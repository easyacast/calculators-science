@extends('layouts.app')

@section('title', 'Readabilityscore Calculator - Free Online')
@section('meta_description', 'Free online readabilityscore calculator. Step-by-step solutions included.')
@section('canonical', config('site.url') . '/text-tools/readabilityscore-calculator')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Readabilityscore Calculator",
    "applicationCategory": "DeveloperApplication",
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
            <li><a href="{{ config('site.url') }}/text-tools" class="hover:text-indigo-600">Text Tools</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Readabilityscore Calculator</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Readabilityscore Calculator</h1>
    <p class="text-lg text-gray-600 mb-8">Free online readabilityscore calculator.</p>

    <div x-data="calcReadabilityscore()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Input Text</label>
                <textarea x-model="input" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono" placeholder="Paste or type your text here..."></textarea>
            </div>
        </div>
        <button @click="process()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Process</button>
        <button x-show="output" @click="navigator.clipboard.writeText(output)" class="ml-2 px-4 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors">Copy Result</button>
        <div x-show="output" x-cloak class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Result</label>
            <textarea x-text="output" readonly rows="6" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm font-mono"></textarea>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Readabilityscore Calculator</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Free online readabilityscore calculator. This tool provides instant results with clear explanations.</p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">How It Works</h2>
        <p class="text-gray-600 leading-relaxed mb-6">Calculate readability score. Simply paste your text into the input area, click Process, and copy the result.</p>


        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection

@section('scripts')
<script>
function calcReadabilityscore() {
    return {
        input: '',
        output: '',
        process() {
            let input = this.input;
            let lines = input.split('\n');
            try {
                this.output = (function(){let sentences=input.split(/[.!?]+/).filter(s=>s.trim()).length;let words=input.split(/\s+/).filter(w=>w).length;let syllables=input.split(/\s+/).reduce((a,w)=>a+Math.max(1,w.replace(/[^aeiouy]/gi,'').length),0);let fk=206.835-1.015*(words/sentences)-84.6*(syllables/words);return 'Flesch Reading Ease: '+fk.toFixed(1)+'\nGrade Level: '+(0.39*(words/sentences)+11.8*(syllables/words)-15.59).toFixed(1);})();
            } catch(e) { this.output = 'Error: ' + e.message; }
        },
    };
}
</script>
@endsection