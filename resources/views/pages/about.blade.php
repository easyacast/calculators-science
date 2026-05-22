@extends('layouts.app')
@section('title', 'About Us')
@section('meta_description', 'Learn about ' . config('site.name') . ' - your free online resource for scientific calculators, math solvers, and educational tools.')
@section('canonical', config('site.url') . '/about')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">About {{ config('site.name') }}</h1>
    <div class="prose prose-gray max-w-none">
        <p class="text-gray-600 leading-relaxed mb-4">{{ config('site.name') }} is a free online platform providing scientific calculators, math solvers, and educational tools for students, teachers, and professionals. Our mission is to make complex calculations accessible and understandable for everyone.</p>
        <p class="text-gray-600 leading-relaxed mb-4">Every tool on this website includes step-by-step solutions, detailed formula explanations, practical examples, and interactive visualizations. We believe that understanding the "why" behind a calculation is just as important as getting the right answer.</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Our Categories</h2>
        <p class="text-gray-600 leading-relaxed mb-4">We cover a wide range of scientific and practical disciplines:</p>
        <ul class="list-disc list-inside text-gray-600 space-y-2 mb-6">
            @foreach(config('site.categories') as $cat)
            <li><strong>{{ $cat['name'] }}</strong>: {{ $cat['description'] }}</li>
            @endforeach
        </ul>
        <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Contact Us</h2>
        <p class="text-gray-600">Have a suggestion or found an issue? Reach out at <a href="mailto:{{ config('site.contact.email') }}" class="text-indigo-600 hover:underline">{{ config('site.contact.email') }}</a>.</p>
    </div>
</div>
@endsection
