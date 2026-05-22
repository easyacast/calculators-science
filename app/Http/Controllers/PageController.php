<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    private function getToolsForCategory(string $categorySlug): array
    {
        $allTools = [
            'math' => [
                ['title' => 'AI Math Solver', 'slug' => 'ai-math-solver', 'description' => 'Solve any math problem with AI-powered step-by-step solutions, interactive graphs, and tutoring.'],
                ['title' => 'Quadratic Equation Calculator', 'slug' => 'quadratic-equation-calculator', 'description' => 'Solve quadratic equations ax\u00b2 + bx + c = 0 with detailed step-by-step solutions.'],
                ['title' => 'Percentage Calculator', 'slug' => 'percentage-calculator', 'description' => 'Calculate percentages, percentage change, and find what percent one number is of another.'],
                ['title' => 'Fraction Calculator', 'slug' => 'fraction-calculator', 'description' => 'Add, subtract, multiply, and divide fractions with step-by-step solutions.'],
                ['title' => 'Square Root Calculator', 'slug' => 'square-root-calculator', 'description' => 'Calculate the square root of any number with decimal precision.'],
                ['title' => 'Exponent Calculator', 'slug' => 'exponent-calculator', 'description' => 'Calculate powers and exponents for any base and exponent value.'],
                ['title' => 'GCD & LCM Calculator', 'slug' => 'gcd-lcm-calculator', 'description' => 'Find the Greatest Common Divisor and Least Common Multiple of numbers.'],
                ['title' => 'Logarithm Calculator', 'slug' => 'logarithm-calculator', 'description' => 'Calculate logarithms with any base including natural log and common log.'],
            ],
            'physics' => [
                ['title' => 'Newton Force Calculator', 'slug' => 'newton-force-calculator', 'description' => 'Calculate force, mass, or acceleration using F = ma.'],
                ['title' => 'Velocity Calculator', 'slug' => 'velocity-calculator', 'description' => 'Calculate velocity, distance, or time for uniform and accelerated motion.'],
                ['title' => 'Ohm\'s Law Calculator', 'slug' => 'ohms-law-calculator', 'description' => 'Calculate voltage, current, or resistance using V = IR.'],
                ['title' => 'Kinetic Energy Calculator', 'slug' => 'kinetic-energy-calculator', 'description' => 'Calculate kinetic energy from mass and velocity.'],
                ['title' => 'Momentum Calculator', 'slug' => 'momentum-calculator', 'description' => 'Calculate linear momentum from mass and velocity.'],
            ],
            'chemistry' => [
                ['title' => 'Ideal Gas Law Calculator', 'slug' => 'ideal-gas-law-calculator', 'description' => 'Solve PV = nRT for any variable.'],
                ['title' => 'Molar Mass Calculator', 'slug' => 'molar-mass-calculator', 'description' => 'Calculate the molar mass of chemical compounds.'],
                ['title' => 'pH Calculator', 'slug' => 'ph-calculator', 'description' => 'Calculate pH, pOH, and hydrogen ion concentration.'],
                ['title' => 'Dilution Calculator', 'slug' => 'dilution-calculator', 'description' => 'Calculate dilution using C1V1 = C2V2 formula.'],
            ],
            'biology' => [
                ['title' => 'Hardy-Weinberg Calculator', 'slug' => 'hardy-weinberg-calculator', 'description' => 'Calculate allele and genotype frequencies in populations.'],
                ['title' => 'Population Growth Calculator', 'slug' => 'population-growth-calculator', 'description' => 'Model exponential and logistic population growth.'],
            ],
            'finance' => [
                ['title' => 'Compound Interest Calculator', 'slug' => 'compound-interest-calculator', 'description' => 'Calculate compound interest with various compounding periods.'],
                ['title' => 'EMI Calculator', 'slug' => 'emi-calculator', 'description' => 'Calculate monthly EMI for loans with principal, rate, and tenure.'],
                ['title' => 'ROI Calculator', 'slug' => 'roi-calculator', 'description' => 'Calculate Return on Investment for your investments.'],
                ['title' => 'Mortgage Calculator', 'slug' => 'mortgage-calculator', 'description' => 'Calculate monthly mortgage payments, total interest, and amortization.'],
            ],
            'engineering' => [
                ['title' => 'Beam Deflection Calculator', 'slug' => 'beam-deflection-calculator', 'description' => 'Calculate beam deflection for various loading conditions.'],
                ['title' => 'Resistor Color Code Calculator', 'slug' => 'resistor-color-code', 'description' => 'Decode resistor values from color bands.'],
            ],
            'unit-converter' => [
                ['title' => 'Length Converter', 'slug' => 'length-converter', 'description' => 'Convert between meters, feet, inches, kilometers, miles, and more.'],
                ['title' => 'Weight Converter', 'slug' => 'weight-converter', 'description' => 'Convert between kilograms, pounds, ounces, grams, and more.'],
                ['title' => 'Temperature Converter', 'slug' => 'temperature-converter', 'description' => 'Convert between Celsius, Fahrenheit, and Kelvin.'],
                ['title' => 'Speed Converter', 'slug' => 'speed-converter', 'description' => 'Convert between km/h, mph, m/s, knots, and more.'],
            ],
            'health' => [
                ['title' => 'BMI Calculator', 'slug' => 'bmi-calculator', 'description' => 'Calculate your Body Mass Index and understand your weight category.'],
                ['title' => 'BMR Calculator', 'slug' => 'bmr-calculator', 'description' => 'Calculate your Basal Metabolic Rate and daily calorie needs.'],
                ['title' => 'Calorie Calculator', 'slug' => 'calorie-calculator', 'description' => 'Estimate daily calorie intake based on activity level and goals.'],
            ],
        ];

        return $allTools[$categorySlug] ?? [];
    }
}
