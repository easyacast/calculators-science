<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Helpers\ToolRegistry;

class SitemapController extends Controller
{
    /**
     * Generate XML Sitemap Index.
     */
    public function index(): Response
    {
        $categories = config('site.categories');
        $siteUrl = config('site.url');

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($categories as $slug => $cat) {
            $xml .= "  <sitemap>\n";
            $xml .= "    <loc>{$siteUrl}/sitemap-{$slug}.xml</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        $xml .= '</sitemapindex>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Generate category-specific sitemap.
     */
    public function category(string $categorySlug): Response
    {
        $categories = config('site.categories');
        $siteUrl = config('site.url');

        if (!isset($categories[$categorySlug])) {
            abort(404);
        }

        $tools = $this->getToolSlugs($categorySlug);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Category page
        $xml .= "  <url>\n";
        $xml .= "    <loc>{$siteUrl}/{$categorySlug}</loc>\n";
        $xml .= "    <changefreq>weekly</changefreq>\n";
        $xml .= "    <priority>0.8</priority>\n";
        $xml .= "  </url>\n";

        // Tool pages
        foreach ($tools as $toolSlug) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$siteUrl}/{$categorySlug}/{$toolSlug}</loc>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Get tool slugs for a category from ToolRegistry.
     */
    private function getToolSlugs(string $category): array
    {
        return array_keys(ToolRegistry::forCategory($category));
    }
}
