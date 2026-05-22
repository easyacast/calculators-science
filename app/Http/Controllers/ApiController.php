<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * AI Math Solver endpoint.
     * Proxies requests to Groq API securely.
     */
    public function solve(Request $request): JsonResponse
    {
        $problem = $request->input('problem', '');
        $mode = $request->input('mode', 'step-by-step');
        $image = $request->input('image');

        $apiKey = config('site.api.groq_api_key');
        $model = config('site.api.groq_model');

        if (!$apiKey) {
            return response()->json($this->offlineSolve($problem, $mode, $image));
        }

        $systemPrompt = $this->buildSolveSystemPrompt($mode);

        $userContent = $problem;
        if ($image) {
            $userContent = "Image of math problem provided. ";
            if ($problem) {
                $userContent .= "Additional context: " . $problem;
            }
        }

        $messages = [
            ['role' => 'user', 'content' => $userContent],
        ];

        try {
            $result = $this->callGroq($messages, $systemPrompt, $model, true);
            $parsed = json_decode($result, true);

            if (!$parsed) {
                return response()->json($this->offlineSolve($problem, $mode, $image));
            }

            return response()->json($parsed);
        } catch (\Exception $e) {
            return response()->json($this->offlineSolve($problem, $mode, $image));
        }
    }

    /**
     * AI Tutor chat endpoint.
     */
    public function chat(Request $request): JsonResponse
    {
        $problemContext = $request->input('problemContext');
        $chatHistory = $request->input('chatHistory', []);
        $newMessage = $request->input('newMessage', '');

        $apiKey = config('site.api.groq_api_key');
        $model = config('site.api.groq_model');

        if (!$apiKey) {
            return response()->json([
                'text' => "The AI tutor requires a Groq API key. Please configure GROQ_API_KEY in the .env file to enable AI tutoring. In the meantime, you can review the step-by-step solution provided above."
            ]);
        }

        $systemPrompt = "You are a warm, encouraging math tutor. You explain mathematical concepts in a simple, teacher-to-student tone. No em-dashes, no robotic language. Use markdown for formatting. If the student asks about the problem context, reference it. Provide practice problems when appropriate.";

        if ($problemContext) {
            $systemPrompt .= "\n\nCurrent problem context: " . json_encode($problemContext);
        }

        $messages = [];
        foreach ($chatHistory as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'model' ? 'assistant' : 'user',
                'content' => $msg['text'],
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $newMessage];

        try {
            $result = $this->callGroq($messages, $systemPrompt, $model, false);
            return response()->json(['text' => $result]);
        } catch (\Exception $e) {
            return response()->json([
                'text' => "I'm having trouble connecting to the AI service right now. Please try again in a moment."
            ]);
        }
    }

    /**
     * Call Groq API.
     */
    private function callGroq(array $messages, string $systemPrompt, string $model, bool $jsonMode): string
    {
        $apiKey = config('site.api.groq_api_key');

        $allMessages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ...$messages,
        ];

        $body = [
            'model' => $model,
            'messages' => $allMessages,
            'temperature' => 0.1,
        ];

        if ($jsonMode) {
            $body['response_format'] = ['type' => 'json_object'];
        }

        $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . trim($apiKey),
            ],
            CURLOPT_POSTFIELDS => json_encode($body),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \Exception("Groq API returned HTTP {$httpCode}");
        }

        $data = json_decode($response, true);
        return $data['choices'][0]['message']['content'] ?? '';
    }

    /**
     * Build system prompt for the solver.
     */
    private function buildSolveSystemPrompt(string $mode): string
    {
        return <<<PROMPT
You are MathMind, a world-class mathematics and science solver. Respond ONLY with valid JSON in this exact structure:
{
  "solvedProblem": "the problem statement",
  "finalAnswer": "the final answer",
  "steps": [
    {"title": "Step N: Title", "explanation": "detailed explanation", "formula": "LaTeX formula"}
  ],
  "concepts": [
    {"name": "Concept Name", "definition": "brief definition"}
  ],
  "graphable": true/false,
  "graphFunctions": ["expression in terms of x using Math.sin, Math.cos, **, etc."],
  "followUpQuestions": ["related question 1", "related question 2", "related question 3"],
  "errorAlert": null
}
Mode: {$mode}. Provide thorough step-by-step reasoning. Use clear LaTeX notation for formulas. If the problem involves a function that can be graphed, set graphable to true and provide JavaScript-compatible expressions in graphFunctions.
PROMPT;
    }

    /**
     * Offline fallback solver for when API key is not configured.
     */
    private function offlineSolve(string $problem, string $mode, ?string $image): array
    {
        $clean = trim($problem);
        $normalized = strtolower(preg_replace('/\s+/', '', $clean));

        // Try quadratic equation: ax^2 + bx + c = 0
        if (preg_match('/^([+-]?\d*\.?\d*)x\^2([+-]\d*\.?\d*)x([+-]\d*\.?\d*)(?:=0)?$/', $normalized, $m)) {
            $a = $m[1] === '' || $m[1] === '+' ? 1 : ($m[1] === '-' ? -1 : floatval($m[1]));
            $b = $m[2] === '' || $m[2] === '+' ? 1 : ($m[2] === '-' ? -1 : floatval($m[2]));
            $c = floatval($m[3] ?: 0);

            if ($a != 0) {
                $disc = $b * $b - 4 * $a * $c;
                $steps = [
                    ['title' => 'Step 1: Identify coefficients', 'explanation' => "From ax^2 + bx + c = 0: a = {$a}, b = {$b}, c = {$c}", 'formula' => "a = {$a}, b = {$b}, c = {$c}"],
                    ['title' => 'Step 2: Calculate discriminant', 'explanation' => 'D = b^2 - 4ac determines the nature of roots.', 'formula' => "D = ({$b})^2 - 4({$a})({$c}) = {$disc}"],
                ];

                if ($disc > 0) {
                    $x1 = round((-$b + sqrt($disc)) / (2 * $a), 4);
                    $x2 = round((-$b - sqrt($disc)) / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Apply quadratic formula', 'explanation' => "Two real roots found.", 'formula' => "x = (-b +/- sqrt(D)) / 2a"];
                    $answer = "x = {$x1}, x = {$x2}";
                } elseif ($disc == 0) {
                    $x = round(-$b / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Apply quadratic formula', 'explanation' => "One repeated root.", 'formula' => "x = -b / 2a"];
                    $answer = "x = {$x}";
                } else {
                    $real = round(-$b / (2 * $a), 4);
                    $imag = round(sqrt(-$disc) / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Complex roots', 'explanation' => "Discriminant is negative, so roots are complex.", 'formula' => "x = {$real} +/- {$imag}i"];
                    $answer = "x = {$real} + {$imag}i, x = {$real} - {$imag}i";
                }

                return [
                    'solvedProblem' => $clean,
                    'finalAnswer' => $answer,
                    'steps' => $steps,
                    'concepts' => [['name' => 'Quadratic Formula', 'definition' => 'A formula that gives the solutions of ax^2 + bx + c = 0.']],
                    'graphable' => true,
                    'graphFunctions' => ["{$a}*x**2 + {$b}*x + {$c}"],
                    'followUpQuestions' => ['What is the vertex of this parabola?', 'How do you factor this equation?', 'What are complex roots?'],
                ];
            }
        }

        // Default fallback
        return [
            'solvedProblem' => $clean ?: 'Math Problem',
            'finalAnswer' => 'Configure GROQ_API_KEY in .env for AI-powered solving',
            'steps' => [
                ['title' => 'Step 1: AI Solver Setup Required', 'explanation' => 'The AI-powered solver needs a Groq API key. Get a free key at console.groq.com and add it as GROQ_API_KEY in your .env file.', 'formula' => 'GROQ_API_KEY = your-key-here'],
                ['title' => 'Step 2: Offline Mode Active', 'explanation' => 'Basic quadratic equations can still be solved offline. Try entering something like: 2x^2+5x-3=0', 'formula' => 'ax^2 + bx + c = 0'],
            ],
            'concepts' => [['name' => 'Offline Mode', 'definition' => 'Basic calculations work without an API key. Advanced AI features require the Groq API.']],
            'graphable' => false,
            'graphFunctions' => [],
            'followUpQuestions' => ['How do I get a Groq API key?', 'Solve 2x^2 + 5x - 3 = 0', 'What equations can be solved offline?'],
        ];
    }
}
