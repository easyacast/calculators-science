<?php

namespace App\Http\Controllers;

use App\Services\MathSolverService;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function show(string $categorySlug, string $toolSlug, Request $request)
    {
        $categories = config('site.categories');

        if (! isset($categories[$categorySlug])) {
            abort(404);
        }

        $category = $categories[$categorySlug];
        $viewPath = "tools.{$categorySlug}.{$toolSlug}";

        if (! view()->exists($viewPath)) {
            abort(404);
        }

        $solverQuery = '';
        $solverMode = 'step-by-step';
        $solution = null;

        if ($toolSlug === 'ai-math-solver') {
            $solverQuery = trim((string) $request->query('q', ''));
            $solverMode = (string) $request->query('mode', 'step-by-step');

            if ($solverQuery !== '') {
                $solution = app(MathSolverService::class)->solve($solverQuery, $solverMode);
            }
        }

        return view($viewPath, compact('category', 'categorySlug', 'toolSlug', 'solverQuery', 'solverMode', 'solution'));
    }
}
