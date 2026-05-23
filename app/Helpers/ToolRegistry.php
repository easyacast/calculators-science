<?php

namespace App\Helpers;

class ToolRegistry
{
    private static ?array $allTools = null;

    public static function all(): array
    {
        if (self::$allTools !== null) {
            return self::$allTools;
        }

        self::$allTools = [
            'math' => [
                ['title' => 'AI Math Solver', 'slug' => 'ai-math-solver', 'description' => 'Solve any math problem with AI-powered step-by-step solutions, interactive graphs, and tutoring.'],
                ['title' => 'Quadratic Equation Calculator', 'slug' => 'quadratic-equation-calculator', 'description' => 'Solve quadratic equations ax² + bx + c = 0 with detailed step-by-step solutions.'],
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

        return self::$allTools;
    }

    public static function forCategory(string $categorySlug): array
    {
        return self::all()[$categorySlug] ?? [];
    }

    /**
     * Get related tools for a specific tool page.
     * Returns same-category tools (excluding current) + cross-category recommendations.
     */
    public static function getRelatedTools(string $currentCategory, string $currentSlug, int $sameCategoryCount = 4, int $crossCategoryCount = 4): array
    {
        $allTools = self::all();
        $categories = config('site.categories');
        $baseUrl = config('site.url');

        $sameCategory = [];
        foreach ($allTools[$currentCategory] ?? [] as $tool) {
            if ($tool['slug'] !== $currentSlug) {
                $sameCategory[] = [
                    'title' => $tool['title'],
                    'description' => $tool['description'],
                    'url' => $baseUrl . '/' . $currentCategory . '/' . $tool['slug'],
                    'category' => $categories[$currentCategory]['name'] ?? ucfirst($currentCategory),
                    'categorySlug' => $currentCategory,
                ];
            }
        }

        // Shuffle then take up to $sameCategoryCount
        shuffle($sameCategory);
        $sameCategory = array_slice($sameCategory, 0, $sameCategoryCount);

        $crossCategory = [];
        foreach ($allTools as $catSlug => $tools) {
            if ($catSlug === $currentCategory) {
                continue;
            }
            // Pick one tool from each other category
            if (!empty($tools)) {
                $tool = $tools[array_rand($tools)];
                $crossCategory[] = [
                    'title' => $tool['title'],
                    'description' => $tool['description'],
                    'url' => $baseUrl . '/' . $catSlug . '/' . $tool['slug'],
                    'category' => $categories[$catSlug]['name'] ?? ucfirst($catSlug),
                    'categorySlug' => $catSlug,
                ];
            }
        }

        shuffle($crossCategory);
        $crossCategory = array_slice($crossCategory, 0, $crossCategoryCount);

        return [
            'sameCategory' => $sameCategory,
            'crossCategory' => $crossCategory,
        ];
    }

    /**
     * Get popular tools for static pages (about, contact, etc.)
     */
    public static function getPopularTools(int $count = 8): array
    {
        $allTools = self::all();
        $categories = config('site.categories');
        $baseUrl = config('site.url');

        $popular = [];
        // Pick one from each category first for diversity
        foreach ($allTools as $catSlug => $tools) {
            if (!empty($tools)) {
                $tool = $tools[0];
                $popular[] = [
                    'title' => $tool['title'],
                    'description' => $tool['description'],
                    'url' => $baseUrl . '/' . $catSlug . '/' . $tool['slug'],
                    'category' => $categories[$catSlug]['name'] ?? ucfirst($catSlug),
                    'categorySlug' => $catSlug,
                ];
            }
        }

        return array_slice($popular, 0, $count);
    }

    /**
     * Get all categories with their URLs for internal linking.
     */
    public static function getCategoryLinks(): array
    {
        $categories = config('site.categories');
        $baseUrl = config('site.url');
        $links = [];

        foreach ($categories as $slug => $cat) {
            $links[] = [
                'name' => $cat['name'],
                'slug' => $slug,
                'url' => $baseUrl . '/' . $slug,
                'description' => $cat['description'],
                'toolCount' => count(self::forCategory($slug)),
            ];
        }

        return $links;
    }
}
