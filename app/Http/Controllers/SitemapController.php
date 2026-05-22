<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

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
     * Get tool slugs for a category.
     */
    private function getToolSlugs(string $category): array
    {
        $tools = [
            'math' => ['ai-math-solver', 'quadratic-equation-calculator', 'percentage-calculator', 'fraction-calculator', 'square-root-calculator', 'exponent-calculator', 'gcd-lcm-calculator', 'logarithm-calculator'],
            'physics' => ['newton-force-calculator', 'velocity-calculator', 'ohms-law-calculator', 'kinetic-energy-calculator', 'momentum-calculator'],
            'chemistry' => ['ideal-gas-law-calculator', 'molar-mass-calculator', 'ph-calculator', 'dilution-calculator'],
            'biology' => ['hardy-weinberg-calculator', 'population-growth-calculator'],
            'finance' => ['compound-interest-calculator', 'emi-calculator', 'roi-calculator', 'mortgage-calculator'],
            'engineering' => ['beam-deflection-calculator', 'resistor-color-code'],
            'unit-converter' => ['length-converter', 'weight-converter', 'temperature-converter', 'speed-converter'],
            'health' => ['bmi-calculator', 'bmr-calculator', 'calorie-calculator'],
        ];

        return $tools[$category] ?? [];
    }
}
