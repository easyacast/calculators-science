@php
    use App\Helpers\ToolRegistry;

    $popularTools = ToolRegistry::getPopularTools(8);
    $categoryLinks = ToolRegistry::getCategoryLinks();
    $baseUrl = config('site.url');
    $currentPage = $currentPage ?? '';
@endphp

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-10">

        {{-- Popular Tools --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Popular Calculators & Tools</h2>
            <p class="text-gray-600 text-sm mb-4">Our most used scientific calculators and tools — free, with step-by-step solutions.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                @foreach($popularTools as $tool)
                <a href="{{ $tool['url'] }}" class="group block bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md rounded-xl p-4 transition-all">
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">{{ $tool['category'] }}</span>
                    <h3 class="font-semibold text-gray-900 text-sm mt-2 group-hover:text-indigo-600 transition-colors">{{ $tool['title'] }}</h3>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed line-clamp-2">{{ $tool['description'] }}</p>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Browse Categories --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Browse by Category</h2>
            <p class="text-gray-600 text-sm mb-4">Find the right calculator for your needs across 8 scientific disciplines.</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach($categoryLinks as $cat)
                <a href="{{ $cat['url'] }}" class="group block bg-gray-50 hover:bg-indigo-50 rounded-xl p-4 text-center transition-colors border border-gray-100 hover:border-indigo-200">
                    <h3 class="font-semibold text-gray-900 text-sm group-hover:text-indigo-600 transition-colors">{{ $cat['name'] }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $cat['toolCount'] }} tools</p>
                </a>
                @endforeach
            </div>
        </div>

        {{-- AI Math Solver CTA --}}
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 mb-1">Try Our AI Math Solver</h3>
                    <p class="text-sm text-gray-600">Type any math problem in plain English and get instant step-by-step solutions powered by AI.</p>
                </div>
                <a href="{{ $baseUrl }}/math/ai-math-solver" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors text-sm whitespace-nowrap flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Try AI Math Solver
                </a>
            </div>
        </div>

        {{-- Quick Links to Other Static Pages --}}
        <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
            @if($currentPage !== 'home')
            <a href="{{ $baseUrl }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">Home</a>
            @endif
            @if($currentPage !== 'about')
            <a href="{{ $baseUrl }}/about" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">About Us</a>
            @endif
            @if($currentPage !== 'contact')
            <a href="{{ $baseUrl }}/contact" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">Contact Us</a>
            @endif
            @if($currentPage !== 'privacy')
            <a href="{{ $baseUrl }}/privacy-policy" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">Privacy Policy</a>
            @endif
            @if($currentPage !== 'terms')
            <a href="{{ $baseUrl }}/terms-of-service" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">Terms of Service</a>
            @endif
            <a href="{{ $baseUrl }}/sitemap" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">Sitemap</a>
        </div>
    </div>
</div>
