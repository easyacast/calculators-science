<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ToolRegistry;

class PageController extends Controller
{
    /**
     * Homepage with categories grid and featured tools.
     */
    public function home()
    {
        $allCategories = config('site.categories');
        $allTools = ToolRegistry::all();

        // Filter out empty categories
        $categories = [];
        $totalTools = 0;
        foreach ($allCategories as $slug => $cat) {
            $toolCount = count(($allTools[$slug] ?? [])['tools'] ?? []);
            if ($toolCount > 0) {
                $categories[$slug] = $cat;
                $totalTools += $toolCount;
            }
        }
        $categoryCount = count($categories);

        $featuredTools = ToolRegistry::getPopularTools(8);

        return view('pages.home', compact('categories', 'featuredTools', 'totalTools', 'categoryCount'));
    }

    /**
     * Search tools across all categories.
     */
    public function search(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $results = [];

        if ($query !== '') {
            $allTools = ToolRegistry::all();
            $baseUrl = config('site.url');
            $categories = config('site.categories');
            $queryLower = mb_strtolower($query);
            $queryWords = array_filter(explode(' ', $queryLower));

            foreach ($allTools as $catSlug => $catData) {
                $tools = $catData['tools'] ?? [];
                foreach ($tools as $toolSlug => $tool) {
                    $titleLower = mb_strtolower($tool['title']);
                    $descLower = mb_strtolower($tool['description'] ?? '');
                    $slugLower = str_replace('-', ' ', $toolSlug);

                    // Score: exact match in title > word match in title > slug match > description match
                    $score = 0;
                    if (str_contains($titleLower, $queryLower)) {
                        $score += 100;
                    }
                    foreach ($queryWords as $word) {
                        if (str_contains($titleLower, $word)) $score += 30;
                        if (str_contains($slugLower, $word)) $score += 20;
                        if (str_contains($descLower, $word)) $score += 10;
                    }

                    if ($score > 0) {
                        $results[] = [
                            'title' => $tool['title'],
                            'description' => $tool['description'] ?? '',
                            'url' => $baseUrl . '/' . $catSlug . '/' . $toolSlug,
                            'category' => $categories[$catSlug]['name'] ?? ucfirst($catSlug),
                            'categorySlug' => $catSlug,
                            'score' => $score,
                        ];
                    }
                }
            }

            // Sort by score descending
            usort($results, fn($a, $b) => $b['score'] - $a['score']);
            $results = array_slice($results, 0, 50);
        }

        return view('pages.search', compact('query', 'results'));
    }

    /**
     * Category page listing all tools in a category.
     */
    public function category(string $categorySlug)
    {
        $categories = config('site.categories');

        if (!isset($categories[$categorySlug])) {
            abort(404);
        }

        $category = $categories[$categorySlug];
        $tools = $this->getToolsForCategory($categorySlug);

        return view('pages.category', compact('category', 'categorySlug', 'tools', 'categories'));
    }

    /**
     * About page.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Contact page.
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Privacy Policy page.
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Terms of Service page.
     */
    public function terms()
    {
        return view('pages.terms');
    }

    /**
     * HTML Sitemap page.
     */
    public function sitemapHtml()
    {
        $categories = config('site.categories');
        return view('pages.sitemap-html', compact('categories'));
    }

    /**
     * Get tools for a specific category.
     * In production, this would query the database.
     */
    /**
     * Get tools for a specific category via centralized registry.
     */
    private function getToolsForCategory(string $categorySlug): array
    {
        return ToolRegistry::forCategory($categorySlug);
    }
}
