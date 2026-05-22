@extends('layouts.app')
@section('title', 'Sitemap')
@section('canonical', config('site.url') . '/sitemap')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Sitemap</h1>
    <div class="space-y-8">
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-3">Main Pages</h2>
            <ul class="space-y-1">
                <li><a href="{{ config('site.url') }}" class="text-indigo-600 hover:underline">Home</a></li>
                <li><a href="{{ config('site.url') }}/about" class="text-indigo-600 hover:underline">About</a></li>
                <li><a href="{{ config('site.url') }}/contact" class="text-indigo-600 hover:underline">Contact</a></li>
            </ul>
        </div>
        @foreach($categories as $slug => $cat)
        <div>
            <h2 class="text-xl font-bold text-gray-900 mb-3">{{ $cat['name'] }}</h2>
            <p class="text-sm text-gray-500 mb-2"><a href="{{ config('site.url') }}/{{ $slug }}" class="text-indigo-600 hover:underline">View all {{ $cat['name'] }} tools</a></p>
        </div>
        @endforeach
    </div>
</div>
@endsection
