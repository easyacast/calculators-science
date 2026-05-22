{{-- Reusable Tool Card Component (included via @include) --}}
@php
$title = $title ?? 'Tool';
$description = $description ?? '';
$url = $url ?? '#';
$category = is_string($category ?? '') ? ($category ?? '') : '';
$icon = $icon ?? 'calculator';
$color = is_string($color ?? 'indigo') ? ($color ?? 'indigo') : 'indigo';
$featured = $featured ?? false;

$colorClasses = [
    'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-200 group-hover:bg-indigo-100',
    'amber' => 'bg-amber-50 text-amber-600 border-amber-200 group-hover:bg-amber-100',
    'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-200 group-hover:bg-emerald-100',
    'rose' => 'bg-rose-50 text-rose-600 border-rose-200 group-hover:bg-rose-100',
    'green' => 'bg-green-50 text-green-600 border-green-200 group-hover:bg-green-100',
    'sky' => 'bg-sky-50 text-sky-600 border-sky-200 group-hover:bg-sky-100',
    'purple' => 'bg-purple-50 text-purple-600 border-purple-200 group-hover:bg-purple-100',
    'red' => 'bg-red-50 text-red-600 border-red-200 group-hover:bg-red-100',
];
$classes = $colorClasses[$color] ?? $colorClasses['indigo'];
@endphp

<a href="{{ $url }}" class="group block bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-200 overflow-hidden {{ $featured ? 'ring-2 ring-indigo-200' : '' }}">
    <div class="p-5">
        <div class="flex items-start gap-3">
            <div class="p-2.5 rounded-lg border {{ $classes }} transition-colors flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            <div class="min-w-0">
                @if($category)
                <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ $category }}</span>
                @endif
                <h3 class="text-sm font-semibold text-gray-900 transition-colors mt-0.5">{{ $title }}</h3>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $description }}</p>
            </div>
        </div>
    </div>
</a>
