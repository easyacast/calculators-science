# Guide: Adding New Calculator Tools

This guide explains how to add new calculators and tools to the website. Follow these steps to maintain consistency in SEO, design, and code quality.

## Step 1: Plan the Tool

Before coding, decide:
- **Category**: Which category does this tool belong to? (math, physics, chemistry, etc.)
- **URL slug**: Keep it descriptive and SEO-friendly (e.g., `quadratic-equation-calculator`)
- **Title**: Use the format "Tool Name Calculator" (e.g., "Quadratic Equation Calculator")

## Step 2: Create the Blade View

Create a new file in `resources/views/tools/{category}/{tool-slug}.blade.php`.

### Template Structure

Every tool page MUST follow this structure:

```blade
@extends('layouts.app')

@section('title', 'Tool Name Calculator')
@section('meta_description', 'A 150-160 character description with primary keywords.')
@section('canonical', config('site.url') . '/category/tool-slug')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "Tool Name Calculator",
    "applicationCategory": "CalculatorApplication",
    "operatingSystem": "Web",
    "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" }
}
</script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li>...</li>
            <li class="text-gray-900 font-medium">Tool Name</li>
        </ol>
    </nav>

    <h1>Tool Name Calculator</h1>
    <p>Brief introduction...</p>

    {{-- Interactive Calculator (Alpine.js) --}}
    <div x-data="toolCalc()">
        <!-- Input fields -->
        <!-- Calculate button -->
        <!-- Results display -->
    </div>

    @include('components.adsense', ['slot' => 'tool-mid'])

    {{-- Educational Content (SSR for SEO) --}}
    <h2>What is [Concept]?</h2>
    <p>Humanized explanation...</p>

    <h2>The Formula</h2>
    <p>$$formula$$</p>

    <h2>Step-by-Step Example</h2>
    <ol>...</ol>

    <h2>Frequently Asked Questions</h2>
    <details>...</details>

    <h2>Related Tools</h2>
    <div>internal links...</div>
</div>
@endsection

@section('scripts')
<script>
function toolCalc() {
    return {
        // Alpine.js reactive data and methods
    };
}
</script>
@endsection
```

## Step 3: Register the Tool

1. **Add to `PageController.php`**: Add the tool to `getToolsForCategory()` array
2. **Add to `SitemapController.php`**: Add the slug to `getToolSlugs()` array

The route `/{category}/{tool}` will automatically pick up the new Blade view.

## Step 4: SEO Checklist

- [ ] H1 tag with exact tool name
- [ ] Meta title (50-60 characters, keyword at start)
- [ ] Meta description (150-160 characters, includes CTA)
- [ ] Canonical URL set
- [ ] Schema.org structured data (SoftwareApplication + FAQPage)
- [ ] Breadcrumbs with proper hierarchy
- [ ] KaTeX formulas with `$$..$$` and `$..$` syntax
- [ ] At least 1 worked example
- [ ] FAQ section (3-5 questions)
- [ ] Related tools internal links (2-4 links)
- [ ] Ad placeholders where appropriate

## Step 5: Content Writing Guidelines

### Tone
- Write like a friendly teacher explaining to a curious student
- Simple, clear language - avoid jargon unless you explain it
- No AI-sounding phrases, no em-dashes
- Active voice preferred

### Structure for Each Section
1. **Introduction**: 2-3 sentences explaining what the tool does and why it matters
2. **Formula**: Display using KaTeX with explanation of each variable
3. **Example**: Real-world scenario with full worked solution
4. **FAQ**: Address common questions students would ask

### Formula Rendering
- Block formulas: `$$E = mc^2$$`
- Inline formulas: `$a^2 + b^2 = c^2$`
- KaTeX is loaded globally via the layout

## Step 6: Adding a New Category

1. Add the category to `config/site.php` in the `categories` array
2. Create the directory: `resources/views/tools/{new-category}/`
3. The category page and sitemap will auto-generate

## Domain Configuration

When you purchase a domain:
1. Update `SITE_URL` in `.env` file
2. Update `Sitemap:` line in `public/robots.txt`
3. Uncomment HTTPS redirect in `public/.htaccess`
4. All internal links, canonical tags, sitemaps, and OG tags will update automatically
