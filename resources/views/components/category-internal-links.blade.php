@php
    use App\Helpers\ToolRegistry;

    $currentCategorySlug = $currentCategorySlug ?? '';
    $categories = config('site.categories');
    $baseUrl = config('site.url');

    // Get featured tools from other categories
    $otherCategoryTools = [];
    foreach (ToolRegistry::all() as $catSlug => $tools) {
        if ($catSlug === $currentCategorySlug || empty($tools)) continue;
        $firstSlug = array_key_first($tools);
        $tool = $tools[$firstSlug];
        $otherCategoryTools[] = [
            'title' => $tool['title'],
            'description' => $tool['description'],
            'url' => $baseUrl . '/' . $catSlug . '/' . $firstSlug,
            'category' => $categories[$catSlug]['name'] ?? ucfirst($catSlug),
            'categorySlug' => $catSlug,
        ];
    }
@endphp

<div class="mt-12 space-y-10">

    {{-- AI Math Solver CTA --}}
    @if($currentCategorySlug !== 'math')
    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="flex-1">
                <h3 class="font-bold text-gray-900 mb-1">Need Help Solving a Problem?</h3>
                <p class="text-sm text-gray-600">Our AI Math Solver can handle any math problem — just type it in plain English and get instant step-by-step solutions.</p>
            </div>
            <a href="{{ $baseUrl }}/math/ai-math-solver" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors text-sm whitespace-nowrap flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Try AI Math Solver
            </a>
        </div>
    </div>
    @endif

    {{-- Featured Tools from Other Categories --}}
    @if(count($otherCategoryTools) > 0)
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Explore Other Categories</h2>
        <p class="text-gray-600 text-sm mb-4">Popular tools from our other scientific categories.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($otherCategoryTools as $tool)
            <a href="{{ $tool['url'] }}" class="group block bg-white border border-gray-200 hover:border-purple-300 hover:shadow-md rounded-xl p-4 transition-all">
                <span class="text-[10px] font-semibold uppercase tracking-wider text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">{{ $tool['category'] }}</span>
                <h3 class="font-semibold text-gray-900 text-sm mt-2 group-hover:text-purple-600 transition-colors">{{ $tool['title'] }}</h3>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $tool['description'] }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Browse All Categories --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">All Calculator Categories</h2>
        <div class="flex flex-wrap gap-2">
            @foreach($categories as $catSlug => $cat)
            <a href="{{ $baseUrl }}/{{ $catSlug }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $catSlug === $currentCategorySlug ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                {{ $cat['name'] }}
                <span class="text-xs opacity-70">({{ count(ToolRegistry::forCategory($catSlug)) }})</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Breadcrumbs --}}
    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 pt-4 border-t border-gray-200">
        <a href="{{ $baseUrl }}" class="hover:text-indigo-600 transition-colors">Home</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">{{ $categories[$currentCategorySlug]['name'] ?? ucfirst($currentCategorySlug) }}</span>
    </div>
</div>
