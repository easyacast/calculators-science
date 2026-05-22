<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LlmsController extends Controller
{
    /**
     * Generate llms.txt - concise overview for AI/LLM discovery.
     * Auto-updates as categories and tools change.
     */
    public function index()
    {
        $siteName = config('site.name');
        $siteUrl = config('site.url');
        $description = config('site.description');
        $categories = config('site.categories');
        $allTools = $this->getAllTools();

        $lines = [];
        $lines[] = "# {$siteName}";
        $lines[] = "";
        $lines[] = "> {$description}";
        $lines[] = "";
        $lines[] = "## About";
        $lines[] = "";
        $lines[] = "{$siteName} is a free online platform providing scientific calculators and tools for Mathematics, Physics, Chemistry, Biology, Finance, Engineering, Health & Fitness, and Unit Conversion. All tools include step-by-step solutions, formulas, interactive graphs, and educational content.";
        $lines[] = "";
        $lines[] = "## Links";
        $lines[] = "";
        $lines[] = "- Homepage: {$siteUrl}";
        $lines[] = "- About: {$siteUrl}/about";
        $lines[] = "- Contact: {$siteUrl}/contact";
        $lines[] = "- Sitemap: {$siteUrl}/sitemap";
        $lines[] = "- Full LLMs file: {$siteUrl}/llms-full.txt";
        $lines[] = "";
        $lines[] = "## Categories";
        $lines[] = "";

        foreach ($categories as $slug => $cat) {
            $toolCount = count($allTools[$slug] ?? []);
            $lines[] = "- [{$cat['name']}]({$siteUrl}/{$slug}): {$cat['description']} ({$toolCount} tools)";
        }

        $lines[] = "";
        $lines[] = "## Featured Tools";
        $lines[] = "";
        $lines[] = "- [AI Math Solver]({$siteUrl}/math/ai-math-solver): Solve any math problem with AI-powered step-by-step solutions, interactive graphs, and tutoring.";
        $lines[] = "- [Quadratic Equation Calculator]({$siteUrl}/math/quadratic-equation-calculator): Solve quadratic equations with detailed steps and graph visualization.";
        $lines[] = "- [BMI Calculator]({$siteUrl}/health/bmi-calculator): Calculate Body Mass Index with health category assessment.";
        $lines[] = "- [Compound Interest Calculator]({$siteUrl}/finance/compound-interest-calculator): Calculate compound interest with year-by-year breakdown.";
        $lines[] = "- [Ideal Gas Law Calculator]({$siteUrl}/chemistry/ideal-gas-law-calculator): Solve PV = nRT for any variable.";

        return response(implode("\n", $lines), 200)
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    /**
     * Generate llms-full.txt - comprehensive listing of every page and tool.
     * Auto-updates as categories and tools change.
     */
    public function full()
    {
        $siteName = config('site.name');
        $siteUrl = config('site.url');
        $description = config('site.description');
        $categories = config('site.categories');
        $allTools = $this->getAllTools();

        $lines = [];
        $lines[] = "# {$siteName} - Complete Site Documentation";
        $lines[] = "";
        $lines[] = "> {$description}";
        $lines[] = "";
        $lines[] = "## Site Overview";
        $lines[] = "";
        $lines[] = "- **Name**: {$siteName}";
        $lines[] = "- **URL**: {$siteUrl}";
        $lines[] = "- **Tech Stack**: Laravel 11, Alpine.js, Tailwind CSS, KaTeX";
        $lines[] = "- **Features**: Step-by-step solutions, interactive graphs, AI tutoring, formula rendering";
        $lines[] = "- **Categories**: " . count($categories);

        $totalTools = 0;
        foreach ($allTools as $tools) {
            $totalTools += count($tools);
        }
        $lines[] = "- **Total Tools**: {$totalTools}";
        $lines[] = "";

        $lines[] = "## Static Pages";
        $lines[] = "";
        $lines[] = "| Page | URL | Description |";
        $lines[] = "|------|-----|-------------|";
        $lines[] = "| Homepage | {$siteUrl}/ | Main landing page with category grid and featured tools |";
        $lines[] = "| About | {$siteUrl}/about | About the platform and team |";
        $lines[] = "| Contact | {$siteUrl}/contact | Contact information and form |";
        $lines[] = "| Privacy Policy | {$siteUrl}/privacy-policy | Data privacy and cookie policy |";
        $lines[] = "| Terms of Service | {$siteUrl}/terms-of-service | Terms and conditions |";
        $lines[] = "| Sitemap | {$siteUrl}/sitemap | HTML sitemap of all pages |";
        $lines[] = "| XML Sitemap | {$siteUrl}/sitemap.xml | XML sitemap index for search engines |";
        $lines[] = "";

        foreach ($categories as $slug => $cat) {
            $tools = $allTools[$slug] ?? [];
            $lines[] = "## {$cat['name']}";
            $lines[] = "";
            $lines[] = "**Category URL**: {$siteUrl}/{$slug}";
            $lines[] = "";
            $lines[] = "{$cat['description']}";
            $lines[] = "";

            if (!empty($tools)) {
                $lines[] = "| Tool | URL | Description |";
                $lines[] = "|------|-----|-------------|";
                foreach ($tools as $tool) {
                    $lines[] = "| {$tool['title']} | {$siteUrl}/{$slug}/{$tool['slug']} | {$tool['description']} |";
                }
                $lines[] = "";
            }
        }

        $lines[] = "## API Endpoints";
        $lines[] = "";
        $lines[] = "| Endpoint | Method | Description |";
        $lines[] = "|----------|--------|-------------|";
        $lines[] = "| /api/solve | POST | Solve math problems with AI (requires CSRF token) |";
        $lines[] = "| /api/chat | POST | AI tutor chat for follow-up questions (requires CSRF token) |";
        $lines[] = "";

        $lines[] = "## Technical SEO";
        $lines[] = "";
        $lines[] = "- XML Sitemap: {$siteUrl}/sitemap.xml";
        $lines[] = "- Robots.txt: {$siteUrl}/robots.txt";
        $lines[] = "- LLMs.txt: {$siteUrl}/llms.txt";
        $lines[] = "- LLMs Full: {$siteUrl}/llms-full.txt";
        $lines[] = "- Schema.org: JSON-LD structured data on every page";
        $lines[] = "- Open Graph: Meta tags for social sharing";
        $lines[] = "- Canonical URLs: On every page";
        $lines[] = "- KaTeX: Mathematical formula rendering";

        return response(implode("\n", $lines), 200)
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    /**
     * Get all tools from the PageController registry.
     */
    private function getAllTools(): array
    {
        return [
            'math' => [
                ['title' => 'AI Math Solver', 'slug' => 'ai-math-solver', 'description' => 'Solve any math problem with AI-powered step-by-step solutions, interactive graphs, and tutoring.'],
                ['title' => 'Quadratic Equation Calculator', 'slug' => 'quadratic-equation-calculator', 'description' => 'Solve quadratic equations with detailed step-by-step solutions.'],
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
                ['title' => 'Length Converter', 'slug' => 'length-converter', 'description' => 'Convert between metric and imperial length units.'],
                ['title' => 'Weight Converter', 'slug' => 'weight-converter', 'description' => 'Convert between kilograms, pounds, ounces, grams, and more.'],
                ['title' => 'Temperature Converter', 'slug' => 'temperature-converter', 'description' => 'Convert between Celsius, Fahrenheit, and Kelvin.'],
                ['title' => 'Speed Converter', 'slug' => 'speed-converter', 'description' => 'Convert between mph, km/h, m/s, and knots.'],
                ['title' => 'Area Converter', 'slug' => 'area-converter', 'description' => 'Convert between square meters, acres, hectares, and more.'],
            ],
            'health' => [
                ['title' => 'BMI Calculator', 'slug' => 'bmi-calculator', 'description' => 'Calculate your Body Mass Index and understand your weight category.'],
                ['title' => 'BMR Calculator', 'slug' => 'bmr-calculator', 'description' => 'Calculate your Basal Metabolic Rate and daily calorie needs.'],
                ['title' => 'Calorie Calculator', 'slug' => 'calorie-calculator', 'description' => 'Calculate daily calorie intake based on activity level and goals.'],
            ],
        ];
    }
}
