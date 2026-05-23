@extends('layouts.app')

@section('title', $category['meta_title'])
@section('meta_description', $category['meta_description'])
@section('canonical', config('site.url') . '/' . $categorySlug)

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "{{ $category['meta_title'] }}",
    "description": "{{ $category['meta_description'] }}",
    "url": "{{ config('site.url') }}/{{ $categorySlug }}"
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600 transition-colors">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">{{ $category['name'] }}</li>
        </ol>
    </nav>

    {{-- Category Header --}}
    <div class="mb-10">
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">{{ $category['name'] }} Calculators & Tools</h1>
        <p class="mt-3 text-lg text-gray-600 max-w-3xl">{{ $category['description'] }}</p>
    </div>

    @include('components.adsense', ['slot' => 'category-top'])

    {{-- Tools Grid --}}
    @if(count($tools) > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($tools as $tool)
        @include('components.tool-card', [
            'title' => $tool['title'],
            'description' => $tool['description'],
            'url' => config('site.url') . '/' . $categorySlug . '/' . $tool['slug'],
            'category' => $category['name'],
            'color' => $category['color'],
        ])
        @endforeach
    </div>
    @else
    <div class="bg-gray-50 rounded-xl p-12 text-center">
        <p class="text-gray-500">More tools coming soon! We are actively building new calculators for this category.</p>
    </div>
    @endif

    @include('components.adsense', ['slot' => 'category-bottom'])

    @include('components.category-internal-links', ['currentCategorySlug' => $categorySlug])
</div>
@endsection
