<?php

/*
|--------------------------------------------------------------------------
| Centralized Site Configuration
|--------------------------------------------------------------------------
|
| This file is the SINGLE SOURCE OF TRUTH for your domain, branding, SEO,
| URL structure, analytics, ad codes, and social media links. When you
| purchase a domain, change the 'url' value below and every page, sitemap,
| canonical tag, Open Graph URL, and internal link will update automatically.
|
*/

return [

    /*
    |----------------------------------------------------------------------
    | Domain & Base URL
    |----------------------------------------------------------------------
    | Change this ONE value when you purchase/change your domain.
    | Every canonical tag, sitemap entry, OG tag, and internal link
    | references config('site.url') so it propagates everywhere.
    */
    'url' => env('SITE_URL', 'https://yourdomain.com'),

    /*
    |----------------------------------------------------------------------
    | Site Identity & Branding
    |----------------------------------------------------------------------
    */
    'name' => env('SITE_NAME', 'SciCalc Pro'),
    'tagline' => 'Free Online Scientific Calculators & Tools',
    'description' => 'The most comprehensive collection of free online calculators for Math, Physics, Chemistry, Biology, Finance, and Engineering. Step-by-step solutions, interactive graphs, and AI-powered tutoring.',
    'logo' => '/images/logo.svg',
    'favicon' => '/images/favicon.ico',
    'language' => 'en',
    'locale' => 'en_US',

    /*
    |----------------------------------------------------------------------
    | SEO Defaults
    |----------------------------------------------------------------------
    */
    'seo' => [
        'title_separator' => ' | ',
        'default_title' => 'Free Online Scientific Calculators & Tools',
        'default_description' => 'Solve complex math, physics, chemistry, biology, finance, and engineering problems with our free online calculators. Step-by-step explanations, formulas, graphs, and AI tutoring included.',
        'default_keywords' => 'calculator, online calculator, math solver, scientific calculator, physics calculator, chemistry calculator, finance calculator, unit converter, equation solver',
        'og_type' => 'website',
        'og_image' => '/images/og-default.png',
        'twitter_card' => 'summary_large_image',
        'twitter_handle' => '',
        'robots_default' => 'index, follow',
        'author' => 'SciCalc Pro Team',
    ],

    /*
    |----------------------------------------------------------------------
    | URL Structure Configuration
    |----------------------------------------------------------------------
    | Controls how URLs are generated across the entire site.
    | Pattern: {base_url}/{category_slug}/{tool_slug}
    */
    'url_structure' => [
        'trailing_slash' => false,
        'force_lowercase' => true,
        'category_prefix' => '',       // e.g. 'tools/' would make /tools/math/
        'use_subcategories' => true,    // enables /physics/fluid-mechanics/tool
    ],

    /*
    |----------------------------------------------------------------------
    | Google Analytics & Tag Manager
    |----------------------------------------------------------------------
    */
    'analytics' => [
        'gtm_id' => env('GTM_ID', ''),                // e.g. GTM-XXXXXXX
        'ga4_id' => env('GA4_MEASUREMENT_ID', ''),     // e.g. G-XXXXXXXXXX
    ],

    /*
    |----------------------------------------------------------------------
    | Advertising (Google AdSense)
    |----------------------------------------------------------------------
    */
    'ads' => [
        'adsense_client_id' => env('ADSENSE_CLIENT_ID', ''),   // e.g. ca-pub-XXXXXXXXXXXXXXXX
        'adsense_auto_ads' => env('ADSENSE_AUTO_ADS', false),
        'show_ads' => env('SHOW_ADS', false),
    ],

    /*
    |----------------------------------------------------------------------
    | Social Media Profiles
    |----------------------------------------------------------------------
    */
    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK', ''),
        'twitter' => env('SOCIAL_TWITTER', ''),
        'youtube' => env('SOCIAL_YOUTUBE', ''),
        'instagram' => env('SOCIAL_INSTAGRAM', ''),
        'linkedin' => env('SOCIAL_LINKEDIN', ''),
    ],

    /*
    |----------------------------------------------------------------------
    | Contact Information
    |----------------------------------------------------------------------
    */
    'contact' => [
        'email' => env('CONTACT_EMAIL', 'contact@yourdomain.com'),
        'support_email' => env('SUPPORT_EMAIL', 'support@yourdomain.com'),
    ],

    /*
    |----------------------------------------------------------------------
    | API Keys (server-side only, never exposed to client)
    |----------------------------------------------------------------------
    */
    'api' => [
        'groq_api_key' => env('GROQ_API_KEY', ''),
        'groq_model' => env('GROQ_MODEL', 'llama-3.3-70b-versatile'),
    ],

    /*
    |----------------------------------------------------------------------
    | Categories Configuration
    |----------------------------------------------------------------------
    | Central registry of all tool categories. Add new categories here
    | and they automatically appear in navigation, sitemaps, and routing.
    */
    'categories' => [
        'math' => [
            'name' => 'Mathematics',
            'slug' => 'math',
            'icon' => 'calculator',
            'color' => 'indigo',
            'description' => 'Algebra, Calculus, Geometry, Statistics, Number Theory, and more.',
            'meta_title' => 'Free Math Calculators & Solvers',
            'meta_description' => 'Solve math problems with our free online calculators. Algebra, Calculus, Geometry, Statistics, Trigonometry tools with step-by-step solutions.',
        ],
        'physics' => [
            'name' => 'Physics',
            'slug' => 'physics',
            'icon' => 'atom',
            'color' => 'amber',
            'description' => 'Mechanics, Electromagnetism, Thermodynamics, Optics, and Quantum Physics.',
            'meta_title' => 'Free Physics Calculators & Tools',
            'meta_description' => 'Calculate physics problems with our free online tools. Mechanics, electromagnetism, thermodynamics, optics calculators with formulas and explanations.',
        ],
        'chemistry' => [
            'name' => 'Chemistry',
            'slug' => 'chemistry',
            'icon' => 'flask-conical',
            'color' => 'emerald',
            'description' => 'Stoichiometry, Gas Laws, Solutions, Thermochemistry, and Organic Chemistry.',
            'meta_title' => 'Free Chemistry Calculators & Tools',
            'meta_description' => 'Solve chemistry problems with our free online calculators. Stoichiometry, gas laws, molarity, pH, and more with step-by-step solutions.',
        ],
        'biology' => [
            'name' => 'Biology',
            'slug' => 'biology',
            'icon' => 'dna',
            'color' => 'rose',
            'description' => 'Population Genetics, Ecology, Bioinformatics, and Medical Biology.',
            'meta_title' => 'Free Biology Calculators & Tools',
            'meta_description' => 'Biology calculators for genetics, ecology, population dynamics, BMI, and medical calculations with explanations.',
        ],
        'finance' => [
            'name' => 'Finance',
            'slug' => 'finance',
            'icon' => 'trending-up',
            'color' => 'green',
            'description' => 'Loans, Investments, Taxes, Compound Interest, and Business Accounting.',
            'meta_title' => 'Free Finance Calculators & Tools',
            'meta_description' => 'Financial calculators for loans, mortgages, investments, compound interest, EMI, taxes, and retirement planning.',
        ],
        'engineering' => [
            'name' => 'Engineering',
            'slug' => 'engineering',
            'icon' => 'wrench',
            'color' => 'sky',
            'description' => 'Civil, Mechanical, Electrical, and Computer Engineering calculators.',
            'meta_title' => 'Free Engineering Calculators & Tools',
            'meta_description' => 'Engineering calculators for structural analysis, electrical circuits, signal processing, and mechanical design.',
        ],
        'unit-converter' => [
            'name' => 'Unit Converters',
            'slug' => 'unit-converter',
            'icon' => 'arrow-left-right',
            'color' => 'purple',
            'description' => 'Length, Weight, Temperature, Speed, Volume, and Digital Storage converters.',
            'meta_title' => 'Free Unit Conversion Tools',
            'meta_description' => 'Convert units instantly with our free online converters. Length, weight, temperature, speed, volume, and more.',
        ],
        'health' => [
            'name' => 'Health & Fitness',
            'slug' => 'health',
            'icon' => 'heart-pulse',
            'color' => 'red',
            'description' => 'BMI, BMR, Calorie, Body Fat, Pregnancy, and Medical calculators.',
            'meta_title' => 'Free Health & Fitness Calculators',
            'meta_description' => 'Health calculators for BMI, BMR, calories, body fat percentage, pregnancy due date, and more.',
        ],
    ],
];
