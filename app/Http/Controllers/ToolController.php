<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    /**
     * Route to specific tool view based on category and tool slug.
     */
    public function show(string $categorySlug, string $toolSlug)
    {
        $categories = config('site.categories');

        if (!isset($categories[$categorySlug])) {
            abort(404);
        }

        $category = $categories[$categorySlug];
        $viewPath = "tools.{$categorySlug}.{$toolSlug}";

        if (!view()->exists($viewPath)) {
            abort(404);
        }

        return view($viewPath, compact('category', 'categorySlug', 'toolSlug'));
    }
}
