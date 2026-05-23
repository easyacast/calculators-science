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
        $categories = config('site.categories');

        $featuredTools = [
            [
                'title' => 'AI Math Solver',
                'description' => 'Solve any math problem with AI-powered step-by-step solutions, interactive graphs, and tutoring.',
                'url' => config('site.url') . '/math/ai-math-solver',
                'category' => 'Mathematics',
                'color' => 'indigo',
                'featured' => true,
            ],
            [
                'title' => 'Quadratic Equation Calculator',
                'description' => 'Solve quadratic equations using the quadratic formula with detailed steps and graph visualization.',
                'url' => config('site.url') . '/math/quadratic-equation-calculator',
                'category' => 'Mathematics',
                'color' => 'indigo',
            ],
            [
                'title' => 'Percentage Calculator',
                'description' => 'Calculate percentages, percentage increase/decrease, and find what percent one number is of another.',
                'url' => config('site.url') . '/math/percentage-calculator',
                'category' => 'Mathematics',
                'color' => 'indigo',
            ],
            [
                'title' => 'BMI Calculator',
                'description' => 'Calculate your Body Mass Index (BMI) and understand your weight category for better health awareness.',
                'url' => config('site.url') . '/health/bmi-calculator',
                'category' => 'Health & Fitness',
                'color' => 'red',
            ],
            [
                'title' => 'Compound Interest Calculator',
                'description' => 'Calculate compound interest on savings and investments with monthly or yearly compounding.',
                'url' => config('site.url') . '/finance/compound-interest-calculator',
                'category' => 'Finance',
                'color' => 'green',
            ],
            [
                'title' => 'Length Converter',
                'description' => 'Convert between meters, feet, inches, centimeters, kilometers, miles, and more length units.',
                'url' => config('site.url') . '/unit-converter/length-converter',
                'category' => 'Unit Converters',
                'color' => 'purple',
            ],
            [
                'title' => 'Newton Force Calculator',
                'description' => 'Calculate force, mass, or acceleration using Newton\'s Second Law of Motion (F = ma).',
                'url' => config('site.url') . '/physics/newton-force-calculator',
                'category' => 'Physics',
                'color' => 'amber',
            ],
            [
                'title' => 'Ideal Gas Law Calculator',
                'description' => 'Solve for pressure, volume, temperature, or moles using the ideal gas law equation PV = nRT.',
                'url' => config('site.url') . '/chemistry/ideal-gas-law-calculator',
                'category' => 'Chemistry',
                'color' => 'emerald',
            ],
        ];

        return view('pages.home', compact('categories', 'featuredTools'));
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
