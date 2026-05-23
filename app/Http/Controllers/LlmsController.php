<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ToolRegistry;

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
        $allTools = ToolRegistry::all();

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
        $allTools = ToolRegistry::all();

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
}
