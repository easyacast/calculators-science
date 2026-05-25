@extends('layouts.app')

@section('title', $query ? "Search: {$query}" : 'Search Calculators & Tools')
@section('meta_description', 'Search across ' . count($results) . '+ scientific calculators, converters, and tools.')
@section('robots', 'noindex, follow')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">
        @if($query)
            Search results for "{{ $query }}"
        @else
            Search Calculators & Tools
        @endif
    </h1>

    <form action="{{ config('site.url') }}/search" method="GET" class="mb-8">
        <div class="relative">
            <input type="text" name="q" value="{{ $query }}" placeholder="Search calculators, tools, formulas..."
                class="w-full pl-12 pr-4 py-3 bg-white border border-gray-300 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm" autofocus>
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
    </form>

    @if($query && count($results) > 0)
    <p class="text-sm text-gray-500 mb-6">{{ count($results) }} result{{ count($results) !== 1 ? 's' : '' }} found</p>
    <div class="space-y-3">
        @foreach($results as $tool)
        <a href="{{ $tool['url'] }}" class="block bg-white border border-gray-200 rounded-xl p-5 hover:shadow-md hover:border-indigo-200 transition-all group">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $tool['title'] }}</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($tool['description'], 150) }}</p>
                </div>
                <span class="flex-shrink-0 px-2.5 py-1 bg-indigo-50 text-indigo-600 text-xs font-medium rounded-lg">{{ $tool['category'] }}</span>
            </div>
        </a>
        @endforeach
    </div>
    @elseif($query)
    <div class="text-center py-16">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">No results found</h2>
        <p class="text-gray-600 mb-6">Try different keywords or browse our categories below.</p>
        <a href="{{ config('site.url') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors">
            Browse All Tools
        </a>
    </div>
    @else
    <div class="text-center py-16">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Search our tools</h2>
        <p class="text-gray-600">Type a keyword to find calculators, converters, and tools across all categories.</p>
    </div>
    @endif
</div>

@include('components.internal-links', ['currentCategory' => '', 'currentSlug' => 'search'])
@endsection
