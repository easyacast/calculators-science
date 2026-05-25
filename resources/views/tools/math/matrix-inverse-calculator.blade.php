@extends('layouts.app')
@section('title', 'Matrix Inverse Calculator (2×2)')
@section('meta_description', 'Calculate the inverse of a 2×2 matrix.')
@section('canonical', config('site.url') . '/math/matrix-inverse-calculator')
@section('schema')
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"SoftwareApplication","name":"Matrix Inverse Calculator (2×2)","applicationCategory":"EducationalApplication","operatingSystem":"Web","offers":{"@type":"Offer","price":"0","priceCurrency":"USD"}}
</script>
@endsection
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/math" class="hover:text-indigo-600">Mathematics</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">Matrix Inverse Calculator (2×2)</li>
        </ol>
    </nav>
    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">Matrix Inverse Calculator (2×2)</h1>
    <p class="text-lg text-gray-600 mb-8">Calculate the inverse of a 2×2 matrix.</p>
    <div x-data="matrixInverseCalculator()" class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">a</label>
                <input type="number" x-model.number="a" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="4">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">b</label>
                <input type="number" x-model.number="b" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="7">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">c</label>
                <input type="number" x-model.number="c" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">d</label>
                <input type="number" x-model.number="d" step="any" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="6">
            </div>
        </div>
        <button @click="calculate()" class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">Calculate</button>
        <div x-show="error" x-cloak class="mt-4 bg-red-50 rounded-xl p-4 border border-red-100"><p class="text-sm text-red-700" x-text="error"></p></div>
        <div x-show="result !== null" x-cloak class="mt-6">
            <div class="bg-gradient-to-r from-indigo-50 to-orange-50 rounded-xl p-5 border border-indigo-200">
                <div class="text-xs font-medium text-indigo-600 uppercase tracking-wider mb-1">Result</div>
                <div class="text-xl font-bold text-gray-900" x-text="resultText"></div>
            </div>
            <div class="mt-4 space-y-3">
                <template x-for="(step, i) in steps" :key="i">
                    <div class="border border-gray-100 rounded-xl p-4"><div class="flex items-start gap-3">
                        <div class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                        <div><h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4><p class="text-gray-600 text-sm mt-1" x-text="step.text"></p></div>
                    </div></div>
                </template>
            </div>
        </div>
    </div>
    @include('components.adsense', ['slot' => 'tool-mid'])
    <div class="max-w-3xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">About Matrix Inverse Calculator (2×2)</h2>
        <p class="text-gray-600 leading-relaxed mb-4">The inverse of a 2×2 matrix exists only when the determinant is non-zero. Multiply the adjugate by 1/det.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-center"><p class="formula-block">$$A^{-1} = \frac{1}{ad-bc}\begin{pmatrix} d & -b \\ -c & a \end{pmatrix}$$</p></div>
        @include('components.internal-links', ['currentCategory' => $categorySlug, 'currentSlug' => $toolSlug])
    </div>
</div>
@endsection
@section('scripts')
<script>
function matrixInverseCalculator() {
    return {
        a: '', b: '', c: '', d: '', result: null, resultText: '', steps: [], error: '',
        calculate() { this.error=''; this.result=null; let a=parseFloat(this.a),b=parseFloat(this.b),c=parseFloat(this.c),d=parseFloat(this.d);let det=a*d-b*c;if(det===0){this.error="Matrix is singular (det=0)";return;}this.result=det;this.resultText="det = "+det+", A⁻¹ = [["+(d/det).toFixed(4)+", "+(-b/det).toFixed(4)+"], ["+(-c/det).toFixed(4)+", "+(a/det).toFixed(4)+"]]";this.steps=[{title:"Determinant",text:"ad-bc = "+det},{title:"Inverse",text:"1/"+det+" × [["+d+", "+(-b)+"], ["+(-c)+", "+a+"]]"},{title:"Result",text:"[["+(d/det).toFixed(4)+", "+(-b/det).toFixed(4)+"], ["+(-c/det).toFixed(4)+", "+(a/det).toFixed(4)+"]]"}]; }
    };
}
</script>
@endsection