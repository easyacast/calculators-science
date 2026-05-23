@php
    use App\Helpers\ToolRegistry;

    $currentCategory = $currentCategory ?? '';
    $currentSlug = $currentSlug ?? '';
    $related = ToolRegistry::getRelatedTools($currentCategory, $currentSlug, 4, 4);
    $sameCategory = $related['sameCategory'];
    $crossCategory = $related['crossCategory'];
    $categories = config('site.categories');
    $categoryName = $categories[$currentCategory]['name'] ?? ucfirst($currentCategory);
    $baseUrl = config('site.url');
@endphp

<div class="mt-12 space-y-10">

    {{-- Same Category Tools --}}
    @if(count($sameCategory) > 0)
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">More {{ $categoryName }} Tools</h2>
        <p class="text-gray-600 text-sm mb-4">Explore other calculators in the {{ $categoryName }} category.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($sameCategory as $tool)
            <a href="{{ $tool['url'] }}" class="group block bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md rounded-xl p-4 transition-all">
                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-indigo-600 transition-colors">{{ $tool['title'] }}</h3>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $tool['description'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Cross-Category Recommendations --}}
    @if(count($crossCategory) > 0)
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">You Might Also Like</h2>
        <p class="text-gray-600 text-sm mb-4">Popular tools from other categories that complement your work.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            @foreach($crossCategory as $tool)
            <a href="{{ $tool['url'] }}" class="group block bg-white border border-gray-200 hover:border-purple-300 hover:shadow-md rounded-xl p-4 transition-all">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">{{ $tool['category'] }}</span>
                </div>
                <h3 class="font-semibold text-gray-900 text-sm group-hover:text-purple-600 transition-colors">{{ $tool['title'] }}</h3>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $tool['description'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- AI Math Solver CTA --}}
    @if($currentSlug !== 'ai-math-solver')
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 mb-1">Can't Find the Right Calculator?</h3>
                <p class="text-sm text-gray-600">Try our AI Math Solver — type any math problem in plain English and get step-by-step solutions instantly.</p>
            </div>
            <a href="{{ $baseUrl }}/math/ai-math-solver" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors text-sm whitespace-nowrap flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Try AI Math Solver
            </a>
        </div>
    </div>
    @endif

    {{-- Browse Categories --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Browse All Categories</h2>
        <p class="text-gray-600 text-sm mb-4">Explore our complete collection of scientific calculators and tools.</p>
        <div class="flex flex-wrap gap-2">
            @foreach($categories as $catSlug => $cat)
            <a href="{{ $baseUrl }}/{{ $catSlug }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $catSlug === $currentCategory ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                {{ $cat['name'] }}
                <span class="text-xs opacity-70">({{ count(ToolRegistry::forCategory($catSlug)) }})</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Breadcrumb-style back links --}}
    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 pt-4 border-t border-gray-200">
        <a href="{{ $baseUrl }}" class="hover:text-indigo-600 transition-colors">Home</a>
        <span>/</span>
        <a href="{{ $baseUrl }}/{{ $currentCategory }}" class="hover:text-indigo-600 transition-colors">{{ $categoryName }}</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Current Tool</span>
    </div>
</div>
