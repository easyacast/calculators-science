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
        'groq_vision_model' => env('GROQ_VISION_MODEL', 'meta-llama/llama-4-scout-17b-16e-instruct'),
        'gemini_api_key' => env('GEMINI_API_KEY', ''),
        'gemini_model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
        'deepseek_api_key' => env('DEEPSEEK_API_KEY', ''),
        'deepseek_model' => env('DEEPSEEK_MODEL', 'deepseek-chat'),
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
        'geometry' => [
            'name' => 'Geometry',
            'slug' => 'geometry',
            'icon' => 'shapes',
            'color' => 'teal',
            'description' => 'Area, Volume, Surface Area, Perimeter calculators for all shapes.',
            'meta_title' => 'Free Geometry Calculators & Tools',
            'meta_description' => 'Calculate area, volume, surface area, and perimeter for circles, triangles, rectangles, spheres, cylinders, and more.',
        ],
        'coordinate-geometry' => [
            'name' => 'Coordinate Geometry',
            'slug' => 'coordinate-geometry',
            'icon' => 'axis-3d',
            'color' => 'cyan',
            'description' => 'Distance, Slope, Midpoint, Conic Sections, and Line equations.',
            'meta_title' => 'Free Coordinate Geometry Calculators',
            'meta_description' => 'Coordinate geometry calculators for distance, slope, midpoint, circles, parabolas, ellipses, and line intersections.',
        ],
        'weather' => [
            'name' => 'Weather',
            'slug' => 'weather',
            'icon' => 'cloud-sun',
            'color' => 'sky',
            'description' => 'Heat Index, Wind Chill, Dew Point, Temperature converters.',
            'meta_title' => 'Free Weather Calculators & Tools',
            'meta_description' => 'Weather calculators for heat index, wind chill, dew point, barometric pressure, and temperature conversion.',
        ],
        'sports' => [
            'name' => 'Sports & Fitness',
            'slug' => 'sports',
            'icon' => 'trophy',
            'color' => 'orange',
            'description' => 'Pace, Calories Burned, 1RM, VO2 Max, and Sports statistics.',
            'meta_title' => 'Free Sports & Fitness Calculators',
            'meta_description' => 'Sports calculators for running pace, calories burned, one rep max, VO2 max, batting average, and more.',
        ],
        'everyday' => [
            'name' => 'Everyday Tools',
            'slug' => 'everyday',
            'icon' => 'home',
            'color' => 'violet',
            'description' => 'Age, Date, Random Number, GPA, Tip, Discount, and more daily-use calculators.',
            'meta_title' => 'Free Everyday Calculators & Tools',
            'meta_description' => 'Everyday calculators for age, dates, discounts, GPA, electricity costs, paint estimation, and more.',
        ],
        'dev-tools' => [
            'name' => 'Developer Tools',
            'slug' => 'dev-tools',
            'icon' => 'code',
            'color' => 'slate',
            'description' => 'JSON, Base64, Hash, Regex, API, UUID generators, formatters, and validators for developers.',
            'meta_title' => 'Free Developer Tools & Utilities',
            'meta_description' => 'Developer tools for JSON formatting, Base64 encoding, hash generation, regex testing, UUID generation, and more.',
        ],
        'text-tools' => [
            'name' => 'Text Tools',
            'slug' => 'text-tools',
            'icon' => 'text',
            'color' => 'lime',
            'description' => 'Word count, case conversion, find/replace, text encoding, and formatting utilities.',
            'meta_title' => 'Free Text Processing Tools',
            'meta_description' => 'Text tools for word counting, case conversion, find and replace, Morse code, slug generation, and more.',
        ],
        'tech-tools' => [
            'name' => 'Tech Tools',
            'slug' => 'tech-tools',
            'icon' => 'monitor',
            'color' => 'zinc',
            'description' => 'IP lookup, password generator, QR code, bandwidth, PPI calculators and tech utilities.',
            'meta_title' => 'Free Tech Tools & Calculators',
            'meta_description' => 'Technology tools for IP lookup, password generation, QR codes, bandwidth calculations, and more.',
        ],
        'real-estate' => [
            'name' => 'Real Estate',
            'slug' => 'real-estate',
            'icon' => 'building',
            'color' => 'amber',
            'description' => 'Rental ROI, cap rate, house flip, BRRRR, mortgage, and property investment calculators.',
            'meta_title' => 'Free Real Estate Calculators & Tools',
            'meta_description' => 'Real estate calculators for rental ROI, cap rate, house flipping, BRRRR analysis, cash flow, and property investment.',
        ],
        'investing' => [
            'name' => 'Investing',
            'slug' => 'investing',
            'icon' => 'line-chart',
            'color' => 'emerald',
            'description' => 'Portfolio allocation, crypto, options, dividends, risk/reward, and investment growth calculators.',
            'meta_title' => 'Free Investment Calculators & Tools',
            'meta_description' => 'Investment calculators for portfolio allocation, cryptocurrency, options profit, dividends, position sizing, and more.',
        ],
    ],
];
