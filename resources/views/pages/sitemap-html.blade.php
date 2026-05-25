@extends('layouts.app')
@section('title', 'Sitemap')
@section('canonical', config('site.url') . '/sitemap')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Sitemap</h1>
    <div class="space-y-8">
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Main Pages</h2>
            <ul class="space-y-1">
                <li><a href="{{ config('site.url') }}" class="text-indigo-600 hover:underline">Home</a></li>
                <li><a href="{{ config('site.url') }}/about" class="text-indigo-600 hover:underline">About Us</a></li>
                <li><a href="{{ config('site.url') }}/contact" class="text-indigo-600 hover:underline">Contact Us</a></li>
                <li><a href="{{ config('site.url') }}/privacy-policy" class="text-indigo-600 hover:underline">Privacy Policy</a></li>
                <li><a href="{{ config('site.url') }}/terms-of-service" class="text-indigo-600 hover:underline">Terms of Service</a></li>
            </ul>
        </div>
        @php $allTools = \App\Helpers\ToolRegistry::all(); @endphp
        @foreach($categories as $slug => $cat)
        @if(count(($allTools[$slug] ?? [])['tools'] ?? []) > 0)
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-3">
                <a href="{{ config('site.url') }}/{{ $slug }}" class="hover:text-indigo-600">{{ $cat['name'] }}</a>
                <span class="text-sm font-normal text-gray-500">({{ count(($allTools[$slug] ?? [])['tools'] ?? []) }} tools)</span>
            </h2>
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1">
                @foreach(($allTools[$slug] ?? [])['tools'] ?? [] as $toolSlug => $tool)
                <li><a href="{{ config('site.url') }}/{{ $slug }}/{{ $toolSlug }}" class="text-sm text-indigo-600 hover:underline">{{ $tool['title'] }}</a></li>
                @endforeach
            </ul>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection
