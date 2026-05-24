<?php

namespace App\Http\Controllers;

use App\Services\MathSolverService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct(private MathSolverService $solver)
    {
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
