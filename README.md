# SciCalc Pro

Free Online Scientific Calculators & Tools — built with Laravel 11, Alpine.js, and Tailwind CSS.

## Quick Start

```bash
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan serve
```

Then open http://localhost:8000

## Features

- **11 Interactive Calculators** across 8 categories (Math, Physics, Chemistry, Biology, Finance, Engineering, Health, Unit Converters)
- **AI Math Solver** with step-by-step solutions, interactive graphing, and AI tutor chat (powered by Groq API)
- **Full SEO** — dynamic sitemaps, Schema.org, canonical tags, Open Graph, KaTeX formulas
- **Centralized Configuration** (`config/site.php`) — change one value when you buy a domain and everything updates

## Adding New Tools

See [GUIDE_ADDING_NEW_TOOLS.md](GUIDE_ADDING_NEW_TOOLS.md) for instructions.

## Configuration

All domain, SEO, analytics, ads, and social settings are centralized in `config/site.php` and controlled via `.env` variables. When you purchase a domain:

1. Update `SITE_URL` in `.env`
2. Update `Sitemap:` line in `public/robots.txt`
3. Uncomment HTTPS redirect in `public/.htaccess`

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.1+)
- **Frontend**: Blade templates, Alpine.js, Tailwind CSS
- **Math Rendering**: KaTeX
- **AI Integration**: Groq API (optional, offline fallback included)

## License

Open-source under the [MIT License](https://opensource.org/licenses/MIT).
