@php
    use App\Helpers\ToolRegistry;

    $currentCategorySlug = $currentCategorySlug ?? '';
    $categories = config('site.categories');
    $baseUrl = config('site.url');

    $otherCategoryTools = [];
    foreach (ToolRegistry::all() as $catSlug => $catData) {
        if ($catSlug === $currentCategorySlug) continue;
        $tools = $catData['tools'] ?? [];
        if (empty($tools)) continue;
        $firstSlug = array_key_first($tools);
        $tool = $tools[$firstSlug];
        $otherCategoryTools[] = [
            'title' => $tool['title'],
            'description' => $tool['description'] ?? '',
            'url' => $baseUrl . '/' . $catSlug . '/' . $firstSlug,
            'category' => $categories[$catSlug]['name'] ?? ($catData['name'] ?? ucfirst($catSlug)),
            'categorySlug' => $catSlug,
        ];
    }
@endphp

<div class="mt-12 space-y-10">

    {{-- AI Math Solver CTA --}}
    @if($currentCategorySlug !== 'math')
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-lg mb-1">Need Help Solving a Problem?</h3>
                <p class="text-sm text-indigo-100">Our AI Math Solver handles any math problem — just type it in plain English and get instant step-by-step solutions.</p>
            </div>
            <a href="{{ $baseUrl }}/math/ai-math-solver" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-indigo-700 font-semibold rounded-xl hover:bg-indigo-50 transition-colors text-sm whitespace-nowrap flex-shrink-0 shadow-sm">
                Try AI Solver
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
    @endif

    {{-- Featured Tools from Other Categories --}}
    @if(count($otherCategoryTools) > 0)
    <div>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-1 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Explore Other Categories</h2>
                <p class="text-gray-500 text-xs mt-0.5">Popular tools from our other scientific categories</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($otherCategoryTools as $tool)
            <a href="{{ $tool['url'] }}" class="group flex items-start gap-3 bg-white border border-gray-200 hover:border-purple-300 hover:shadow-lg rounded-xl p-4 transition-all duration-200">
                <div class="flex-shrink-0 w-10 h-10 bg-purple-50 group-hover:bg-purple-100 rounded-lg flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="min-w-0">
                    <span class="inline-block text-[10px] font-semibold uppercase tracking-wider text-purple-600 bg-purple-100 px-2 py-0.5 rounded-full mb-1">{{ $tool['category'] }}</span>
                    <h3 class="font-semibold text-gray-900 text-sm group-hover:text-purple-600 transition-colors truncate">{{ $tool['title'] }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-2 leading-relaxed">{{ $tool['description'] }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Browse All Categories --}}
    <div>
        <div class="flex items-center gap-3 mb-4">
            <div class="w-1 h-8 bg-gradient-to-b from-emerald-500 to-teal-500 rounded-full"></div>
            <h2 class="text-xl font-bold text-gray-900">All Calculator Categories</h2>
        </div>
        <div class="flex flex-wrap gap-2">
            @foreach($categories as $catSlug => $cat)
            <a href="{{ $baseUrl }}/{{ $catSlug }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border {{ $catSlug === $currentCategorySlug ? 'bg-indigo-600 text-white border-indigo-600 shadow-md shadow-indigo-200' : 'bg-white text-gray-700 border-gray-200 hover:bg-indigo-50 hover:text-indigo-700 hover:border-indigo-200 hover:shadow-sm' }}">
                {{ $cat['name'] }}
                <span class="text-xs {{ $catSlug === $currentCategorySlug ? 'text-indigo-200' : 'text-gray-400' }}">({{ count(ToolRegistry::forCategory($catSlug)) }})</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Breadcrumbs --}}
    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 pt-4 border-t border-gray-200">
        <a href="{{ $baseUrl }}" class="hover:text-indigo-600 transition-colors font-medium">Home</a>
        <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900 font-medium">{{ $categories[$currentCategorySlug]['name'] ?? ucfirst($currentCategorySlug) }}</span>
    </div>
</div>
