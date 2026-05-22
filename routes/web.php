<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| SEO-friendly URL structure:
|   / .......................... Homepage
|   /{category} ............... Category page (math, physics, etc.)
|   /{category}/{tool} ........ Individual tool page
|   /sitemap.xml .............. XML Sitemap Index
|   /sitemap-{category}.xml ... Category XML Sitemap
*/

// Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-of-service', [PageController::class, 'terms'])->name('terms');
Route::get('/sitemap', [PageController::class, 'sitemapHtml'])->name('sitemap.html');

// XML Sitemaps
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');
Route::get('/sitemap-{category}.xml', [SitemapController::class, 'category'])->name('sitemap.category');

// API routes for AI Math Solver (internal, never expose keys)
Route::post('/api/solve', [ApiController::class, 'solve']);
Route::post('/api/chat', [ApiController::class, 'chat']);

// Category pages
Route::get('/{category}', [PageController::class, 'category'])
    ->where('category', implode('|', array_keys(config('site.categories'))))
    ->name('category');

// Tool pages (must come last - catches /{category}/{tool})
Route::get('/{category}/{tool}', [ToolController::class, 'show'])
    ->where('category', implode('|', array_keys(config('site.categories'))))
    ->name('tool');
