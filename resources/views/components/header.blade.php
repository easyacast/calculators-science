{{-- Site Header with Navigation --}}
<header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ config('site.url') }}" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-9 h-9 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent hidden sm:block">
                    {{ config('site.name') }}
                </span>
            </a>

            {{-- Right Side: Search + Mobile Menu --}}
            <div class="flex items-center gap-2">
                <button @click="searchOpen = !searchOpen" class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-gray-100 rounded-lg transition-colors" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-500 hover:text-indigo-600 hover:bg-gray-100 rounded-lg transition-colors" aria-label="Toggle menu">
                    <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Search Bar (expandable) --}}
        <div x-show="searchOpen" x-cloak x-transition class="pb-4">
            <form action="{{ config('site.url') }}/search" method="GET" class="relative">
                <input type="text" name="q" placeholder="Search calculators, tools, formulas..."
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </form>
        </div>
    </nav>

    {{-- Desktop Category Carousel Navigation --}}
    <div class="hidden lg:block border-t border-gray-100 bg-gray-50" x-data="categoryCarousel()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            {{-- Left scroll arrow --}}
            <button x-show="canScrollLeft" @click="scrollLeft()" x-cloak
                class="absolute left-0 top-0 bottom-0 z-10 w-10 flex items-center justify-center bg-gradient-to-r from-gray-50 via-gray-50 to-transparent hover:from-gray-100">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>

            {{-- Scrollable category container --}}
            <div x-ref="carousel" @scroll="updateScrollState()"
                class="flex items-center gap-1 overflow-x-auto scrollbar-hide py-2 scroll-smooth px-2"
                style="scrollbar-width: none; -ms-overflow-style: none;">
                @foreach(config('site.categories') as $slug => $cat)
                <a href="{{ config('site.url') }}/{{ $slug }}"
                   class="flex-shrink-0 px-3.5 py-1.5 text-sm font-medium text-gray-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-full transition-all whitespace-nowrap border border-transparent hover:border-indigo-200">
                    {{ $cat['name'] }}
                </a>
                @endforeach
            </div>

            {{-- Right scroll arrow --}}
            <button x-show="canScrollRight" @click="scrollRight()" x-cloak
                class="absolute right-0 top-0 bottom-0 z-10 w-10 flex items-center justify-center bg-gradient-to-l from-gray-50 via-gray-50 to-transparent hover:from-gray-100">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div x-show="mobileMenuOpen" x-cloak x-transition class="lg:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-3 grid grid-cols-2 gap-1">
            @foreach(config('site.categories') as $slug => $cat)
            <a href="{{ config('site.url') }}/{{ $slug }}"
               class="px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                {{ $cat['name'] }}
            </a>
            @endforeach
        </div>
    </div>
</header>

<script>
function categoryCarousel() {
    return {
        canScrollLeft: false,
        canScrollRight: false,
        init() {
            this.$nextTick(() => this.updateScrollState());
            window.addEventListener('resize', () => this.updateScrollState());
        },
        updateScrollState() {
            const el = this.$refs.carousel;
            if (!el) return;
            this.canScrollLeft = el.scrollLeft > 10;
            this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 10);
        },
        scrollLeft() {
            this.$refs.carousel.scrollBy({ left: -200, behavior: 'smooth' });
        },
        scrollRight() {
            this.$refs.carousel.scrollBy({ left: 200, behavior: 'smooth' });
        }
    };
}
</script>
