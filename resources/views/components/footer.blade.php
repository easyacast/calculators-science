{{-- Site Footer --}}
@php
    $footerAllTools = \App\Helpers\ToolRegistry::all();
    $footerCategories = [];
    foreach (config('site.categories') as $slug => $cat) {
        $tc = count(($footerAllTools[$slug] ?? [])['tools'] ?? []);
        if ($tc > 0) $footerCategories[$slug] = $cat;
    }
@endphp
<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Brand Column --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-lg font-bold text-white">{{ config('site.name') }}</span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed mb-6">
                    {{ config('site.tagline') }}. Trusted by students, teachers, and professionals worldwide.
                </p>

                {{-- Social Media Icons --}}
                @php
                    $socials = [
                        'facebook' => [
                            'url' => config('site.social.facebook'),
                            'label' => 'Facebook',
                            'svg' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>',
                            'hover' => 'hover:bg-blue-600',
                        ],
                        'twitter' => [
                            'url' => config('site.social.twitter'),
                            'label' => 'X (Twitter)',
                            'svg' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>',
                            'hover' => 'hover:bg-gray-700',
                        ],
                        'youtube' => [
                            'url' => config('site.social.youtube'),
                            'label' => 'YouTube',
                            'svg' => '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>',
                            'hover' => 'hover:bg-red-600',
                        ],
                        'instagram' => [
                            'url' => config('site.social.instagram'),
                            'label' => 'Instagram',
                            'svg' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>',
                            'hover' => 'hover:bg-pink-600',
                        ],
                        'linkedin' => [
                            'url' => config('site.social.linkedin'),
                            'label' => 'LinkedIn',
                            'svg' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>',
                            'hover' => 'hover:bg-blue-700',
                        ],
                    ];
                    $hasAnySocial = collect($socials)->pluck('url')->filter()->isNotEmpty();
                @endphp

                @if($hasAnySocial)
                <div class="flex items-center gap-3">
                    @foreach($socials as $key => $social)
                        @if($social['url'])
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer"
                           class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center text-gray-400 hover:text-white {{ $social['hover'] }} transition-all duration-200"
                           aria-label="{{ $social['label'] }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">{!! $social['svg'] !!}</svg>
                        </a>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Categories (only non-empty) --}}
            <div>
                <h3 class="text-white font-semibold mb-4">Categories</h3>
                <ul class="space-y-2">
                    @foreach($footerCategories as $slug => $cat)
                    <li>
                        <a href="{{ config('site.url') }}/{{ $slug }}" class="text-sm text-gray-400 hover:text-white transition-colors">
                            {{ $cat['name'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Popular Tools (auto-detected from registry) --}}
            <div>
                <h3 class="text-white font-semibold mb-4">Popular Tools</h3>
                <ul class="space-y-2">
                    @php $footerTools = \App\Helpers\ToolRegistry::getPopularTools(8); @endphp
                    @foreach($footerTools as $ft)
                    <li><a href="{{ $ft['url'] }}" class="text-sm text-gray-400 hover:text-white transition-colors">{{ $ft['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Company / Legal --}}
            <div>
                <h3 class="text-white font-semibold mb-4">Company</h3>
                <ul class="space-y-2">
                    <li><a href="{{ config('site.url') }}/about" class="text-sm text-gray-400 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ config('site.url') }}/contact" class="text-sm text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    <li><a href="{{ config('site.url') }}/privacy-policy" class="text-sm text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                    <li><a href="{{ config('site.url') }}/terms-of-service" class="text-sm text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                    <li><a href="{{ config('site.url') }}/sitemap" class="text-sm text-gray-400 hover:text-white transition-colors">Sitemap</a></li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('site.name') }}. All rights reserved.</p>
            <p class="text-xs text-gray-600">Built for students, teachers, and professionals who love learning.</p>
        </div>
    </div>
</footer>
