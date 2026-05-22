{{-- Site Footer --}}
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
                <p class="text-sm text-gray-400 leading-relaxed">
                    {{ config('site.tagline') }}. Trusted by students, teachers, and professionals worldwide.
                </p>
            </div>

            {{-- Categories --}}
            <div>
                <h3 class="text-white font-semibold mb-4">Categories</h3>
                <ul class="space-y-2">
                    @foreach(config('site.categories') as $slug => $cat)
                    <li>
                        <a href="{{ config('site.url') }}/{{ $slug }}" class="text-sm text-gray-400 hover:text-white transition-colors">
                            {{ $cat['name'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Popular Tools --}}
            <div>
                <h3 class="text-white font-semibold mb-4">Popular Tools</h3>
                <ul class="space-y-2">
                    <li><a href="{{ config('site.url') }}/math/ai-math-solver" class="text-sm text-gray-400 hover:text-white transition-colors">AI Math Solver</a></li>
                    <li><a href="{{ config('site.url') }}/math/quadratic-equation-calculator" class="text-sm text-gray-400 hover:text-white transition-colors">Quadratic Equation Calculator</a></li>
                    <li><a href="{{ config('site.url') }}/math/percentage-calculator" class="text-sm text-gray-400 hover:text-white transition-colors">Percentage Calculator</a></li>
                    <li><a href="{{ config('site.url') }}/health/bmi-calculator" class="text-sm text-gray-400 hover:text-white transition-colors">BMI Calculator</a></li>
                    <li><a href="{{ config('site.url') }}/unit-converter/length-converter" class="text-sm text-gray-400 hover:text-white transition-colors">Length Converter</a></li>
                    <li><a href="{{ config('site.url') }}/finance/compound-interest-calculator" class="text-sm text-gray-400 hover:text-white transition-colors">Compound Interest Calculator</a></li>
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

                {{-- Social Links --}}
                @if(config('site.social.facebook') || config('site.social.twitter') || config('site.social.youtube'))
                <div class="mt-6">
                    <h4 class="text-white font-semibold mb-3">Follow Us</h4>
                    <div class="flex gap-3">
                        @if(config('site.social.facebook'))
                        <a href="{{ config('site.social.facebook') }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        @if(config('site.social.twitter'))
                        <a href="{{ config('site.social.twitter') }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors" aria-label="Twitter">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('site.name') }}. All rights reserved.</p>
            <p class="text-xs text-gray-600">Built for students, teachers, and professionals who love learning.</p>
        </div>
    </div>
</footer>
