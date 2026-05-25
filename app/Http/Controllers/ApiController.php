<?php

namespace App\Http\Controllers;

use App\Helpers\ToolRegistry;
use App\Services\MathSolverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(private MathSolverService $solver)
    {
    }

    public function search(Request $request): JsonResponse
    {
        $query = trim((string) $request->input('q', ''));
        if (mb_strlen($query) < 2) {
            return response()->json([]);
        }

        $allTools = ToolRegistry::all();
        $baseUrl = config('site.url');
        $categories = config('site.categories');
        $queryLower = mb_strtolower($query);
        $queryWords = array_filter(explode(' ', $queryLower));
        $results = [];

        foreach ($allTools as $catSlug => $catData) {
            $tools = $catData['tools'] ?? [];
            foreach ($tools as $toolSlug => $tool) {
                $titleLower = mb_strtolower($tool['title']);
                $descLower = mb_strtolower($tool['description'] ?? '');
                $slugLower = str_replace('-', ' ', $toolSlug);

                $score = 0;
                if (str_contains($titleLower, $queryLower)) $score += 100;
                foreach ($queryWords as $word) {
                    if (str_contains($titleLower, $word)) $score += 30;
                    if (str_contains($slugLower, $word)) $score += 20;
                    if (str_contains($descLower, $word)) $score += 10;
                }

                if ($score > 0) {
                    $results[] = [
                        'title' => $tool['title'],
                        'url' => $baseUrl . '/' . $catSlug . '/' . $toolSlug,
                        'category' => $categories[$catSlug]['name'] ?? ucfirst($catSlug),
                        'score' => $score,
                    ];
                }
            }
        }

        usort($results, fn($a, $b) => $b['score'] - $a['score']);
        return response()->json(array_slice($results, 0, 10));
    }

    public function solve(Request $request): JsonResponse
    {
        $problem = (string) ($request->input('problem') ?? '');
        $mode = (string) ($request->input('mode') ?? 'step-by-step');
        $image = $request->input('image');
        $mimeType = $request->input('mimeType');

        try {
            return response()->json(
                $this->solver->solve($problem, $mode, $image, $mimeType)
            );
        } catch (\Throwable $e) {
            report($e);

            $fallback = $this->solver->offlineSolve($problem, $mode, $image);

            return response()->json($fallback);
        }
    }

    public function chat(Request $request): JsonResponse
    {
        $problemContext = $request->input('problemContext');
        $chatHistory = $request->input('chatHistory', []);
        $newMessage = $request->input('newMessage', '');

        if (! is_string($newMessage) || trim($newMessage) === '') {
            return response()->json(['text' => 'Message content is required.'], 400);
        }

        try {
            return response()->json(
                $this->solver->chat($problemContext, $chatHistory, $newMessage)
            );
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'text' => "I'm having trouble connecting to the AI tutoring service. Please try again in a moment.",
            ]);
        }
    }
}
