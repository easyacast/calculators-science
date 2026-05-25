<?php

namespace App\Services;

class MathSolverService
{
    /**
     * Solve a math problem using all configured AI providers in parallel.
     * Returns individual engine results + a synthesis/conclusion tab.
     * Gracefully skips any failed AI — never exposes errors or branding to client.
     */
    public function solve(string $problem, string $mode = 'step-by-step', ?string $image = null, ?string $mimeType = null): array
    {
        $problem = trim($problem);
        $mode = $mode ?: 'step-by-step';
        $extractedText = null;
        $extractedLatex = null;

        if ($problem === '' && !$image) {
            return $this->offlineSolve('', $mode, $image);
        }

        if (!$this->isAnyProviderConfigured()) {
            return $this->offlineSolve($problem, $mode, $image);
        }

        // Image transcription via Groq Vision (OCR only) or Gemini
        if ($image) {
            try {
                $transcription = $this->transcribeImage($image, $mimeType, $problem);
                $extractedText = $transcription['displayText'];
                $extractedLatex = $transcription['latex'] ?? null;
                $problem = $this->mergeProblemWithTranscription($problem, $transcription);

                if ($problem === '') {
                    $offline = $this->offlineSolve('', $mode, null);
                    $offline['extractedText'] = $extractedText ?? '';
                    $offline['extractedLatex'] = $extractedLatex;
                    return $offline;
                }
            } catch (\Throwable $e) {
                report($e);
                return $this->offlineSolve($problem, $mode, $image);
            }
            $image = null;
        }

        // Call all configured providers
        $engines = $this->callAllSolvers($problem, $mode);

        // Build synthesis from all successful results
        $synthesisData = null;
        $successfulEngines = array_filter($engines, fn($r) => $r !== null);

        if (count($successfulEngines) >= 2) {
            try {
                $synthesisData = $this->synthesizeSolutions($problem, $successfulEngines);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $primary = $synthesisData ?: (reset($successfulEngines) ?: null);

        if (!$primary) {
            $offline = $this->offlineSolve($problem, $mode, null);
            $offline['extractedText'] = $extractedText;
            $offline['extractedLatex'] = $extractedLatex;
            return $offline;
        }

        return [
            'solvedProblem' => $primary['solvedProblem'] ?? $problem,
            'finalAnswer' => $primary['finalAnswer'] ?? ($primary['perfectAnswer'] ?? 'Solution computed'),
            'steps' => $primary['steps'] ?? [],
            'concepts' => $primary['concepts'] ?? [],
            'graphable' => $primary['graphable'] ?? false,
            'graphFunctions' => $primary['graphFunctions'] ?? [],
            'followUpQuestions' => $primary['followUpQuestions'] ?? [],
            'alphaResponse' => $engines['alpha'] ?? null,
            'betaResponse' => $engines['beta'] ?? null,
            'gammaResponse' => $engines['gamma'] ?? null,
            'deltaResponse' => $engines['delta'] ?? null,
            'extractedText' => $extractedText,
            'extractedLatex' => $extractedLatex,
            'synthesis' => $synthesisData ? [
                'agreement' => $synthesisData['agreement'] ?? 'partial',
                'comparisonMarkdown' => $synthesisData['comparisonMarkdown'] ?? '',
                'perfectAnswer' => $synthesisData['perfectAnswer'] ?? ($synthesisData['finalAnswer'] ?? ''),
            ] : null,
        ];
    }

    /**
     * Call all configured solve providers. Returns keyed array (alpha/beta/gamma/delta).
     * Each failed provider returns null — no errors exposed.
     */
    private function callAllSolvers(string $problem, string $mode): array
    {
        $systemPrompt = $this->buildSolveSystemPrompt($mode);
        $promptText = 'Solve the query: "' . $problem . '". Output results strictly in JSON conforming to the requested schema.';
        $results = ['alpha' => null, 'beta' => null, 'gamma' => null, 'delta' => null];

        // Groq (Solver Alpha)
        if ($this->hasKeys('groq')) {
            try {
                $resp = $this->callWithFailover('groq', [['role' => 'user', 'content' => $promptText]], $systemPrompt, true);
                $results['alpha'] = $this->parseJsonResponse($resp);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // Gemini (Solver Beta)
        if ($this->hasKeys('gemini')) {
            try {
                $resp = $this->callGeminiWithFailover(
                    [['role' => 'user', 'parts' => [['text' => 'Solve this problem structure: "' . $problem . '"']]]],
                    $systemPrompt,
                    true
                );
                $results['beta'] = $this->parseJsonResponse($resp);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // DeepSeek (Solver Gamma)
        if ($this->hasKeys('deepseek')) {
            try {
                $resp = $this->callWithFailover('deepseek', [['role' => 'user', 'content' => $promptText]], $systemPrompt, true);
                $results['gamma'] = $this->parseJsonResponse($resp);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // Mistral (Solver Delta)
        if ($this->hasKeys('mistral')) {
            try {
                $resp = $this->callWithFailover('mistral', [['role' => 'user', 'content' => $promptText]], $systemPrompt, true);
                $results['delta'] = $this->parseJsonResponse($resp);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $results;
    }

    // ========================================================================
    // Multi-key failover system
    // ========================================================================

    /**
     * Get all API keys for a provider (supports single key + comma-separated keys).
     */
    private function getApiKeys(string $provider): array
    {
        $single = config("site.api.{$provider}_api_key");
        $multi = config("site.api.{$provider}_api_keys");

        $keys = [];
        if (is_string($multi) && trim($multi) !== '') {
            $keys = array_filter(array_map('trim', explode(',', $multi)));
        }
        if (is_string($single) && trim($single) !== '' && !in_array(trim($single), $keys, true)) {
            array_unshift($keys, trim($single));
        }

        return $keys;
    }

    private function hasKeys(string $provider): bool
    {
        return count($this->getApiKeys($provider)) > 0;
    }

    private function isAnyProviderConfigured(): bool
    {
        return $this->hasKeys('groq') || $this->hasKeys('gemini') || $this->hasKeys('deepseek') || $this->hasKeys('mistral');
    }

    /**
     * Call an OpenAI-compatible provider with automatic key rotation on failure.
     */
    private function callWithFailover(string $provider, array $messages, string $systemPrompt, bool $jsonMode, int $timeout = 90): string
    {
        $keys = $this->getApiKeys($provider);
        $model = config("site.api.{$provider}_model");
        $endpoint = match ($provider) {
            'groq' => 'https://api.groq.com/openai/v1/chat/completions',
            'deepseek' => 'https://api.deepseek.com/chat/completions',
            'mistral' => 'https://api.mistral.ai/v1/chat/completions',
            default => throw new \RuntimeException("Unknown provider: {$provider}"),
        };

        $lastError = null;
        foreach ($keys as $apiKey) {
            try {
                return $this->callOpenAiCompatible($endpoint, $apiKey, $model, $messages, $systemPrompt, $jsonMode, $timeout);
            } catch (\Throwable $e) {
                $lastError = $e;
                report($e);
            }
        }

        throw $lastError ?? new \RuntimeException("No API keys available for {$provider}");
    }

    private function callOpenAiCompatible(string $endpoint, string $apiKey, string $model, array $messages, string $systemPrompt, bool $jsonMode, int $timeout): string
    {
        $allMessages = [['role' => 'system', 'content' => $systemPrompt], ...$messages];
        $body = [
            'model' => $model,
            'messages' => $allMessages,
            'temperature' => 0.1,
        ];

        if ($jsonMode) {
            $body['response_format'] = ['type' => 'json_object'];
        }

        $response = $this->httpPost(
            $endpoint,
            ['Content-Type: application/json', 'Authorization: Bearer ' . trim($apiKey)],
            json_encode($body),
            $timeout
        );

        $data = json_decode($response, true);
        return $data['choices'][0]['message']['content'] ?? '';
    }

    /**
     * Gemini has a different API format — handle failover separately.
     */
    private function callGeminiWithFailover(array $contents, string $systemInstruction, bool $jsonMode): string
    {
        $keys = $this->getApiKeys('gemini');
        $model = config('site.api.gemini_model');

        $body = [
            'systemInstruction' => ['parts' => [['text' => $systemInstruction]]],
            'contents' => $contents,
            'generationConfig' => ['temperature' => 0.1],
        ];

        if ($jsonMode) {
            $body['generationConfig']['responseMimeType'] = 'application/json';
        }

        $lastError = null;
        foreach ($keys as $apiKey) {
            try {
                $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . urlencode(trim($apiKey));
                $response = $this->httpPost($url, ['Content-Type: application/json'], json_encode($body));
                $data = json_decode($response, true);
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            } catch (\Throwable $e) {
                $lastError = $e;
                report($e);
            }
        }

        throw $lastError ?? new \RuntimeException('No Gemini API keys available');
    }

    // ========================================================================
    // Image transcription (OCR)
    // ========================================================================

    private function transcribeImage(string $image, ?string $mimeType, string $userNotes): array
    {
        // Try Groq Vision first (OCR only — extract readable data for other AIs)
        if ($this->hasKeys('groq')) {
            try {
                return $this->transcribeImageWithGroq($image, $mimeType, $userNotes);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        // Fallback to Gemini Vision
        if ($this->hasKeys('gemini')) {
            return $this->transcribeImageWithGemini($image, $mimeType, $userNotes);
        }

        throw new \RuntimeException('No vision-capable API configured.');
    }

    private function transcribeImageWithGroq(string $image, ?string $mimeType, string $userNotes): array
    {
        $systemInstruction = 'You are an expert scientific OCR assistant that reads mathematical, physical, chemical, and engineering notation from images with perfect accuracy.

Rules:
1. displayText: Write the content in human-readable form using Unicode symbols (±, √, ², ³, π, θ, Σ, ∫, ∂, ∇, α, β, γ, δ, ε, λ, μ, σ, φ, ω, ∞, ≤, ≥, ≠, ≈, ∝, →, ⇒, ∀, ∃, ∈, ∉, ⊂, ∩, ∪, ℝ, ℤ, ℕ). Example: "x = (-b ± √(b² − 4ac)) / (2a)"
2. latex: Clean LaTeX WITHOUT $$ wrappers, preserving ALL scientific notation exactly. Use proper LaTeX commands: \\frac, \\sqrt, \\int, \\sum, \\prod, \\lim, \\partial, \\nabla, \\infty, \\alpha, \\beta, etc. Example: "x = \\frac{-b \\pm \\sqrt{b^2 - 4ac}}{2a}"
3. contentType: one of formula, formula_reference, equation, expression, word_problem, diagram, system_of_equations, inequality, matrix, integral, differential_equation
4. solverPrompt: A clear instruction for a solver AI. For formulas/theorems: ask to explain, define symbols, give worked example. For equations: ask to solve step by step. For integrals/derivatives: ask to evaluate. For systems: ask to solve the system.
5. Do NOT solve the problem — only transcribe and classify.

Return JSON schema:
{"displayText":"...","latex":"...","contentType":"...","solverPrompt":"..."}';

        [$base64, $resolvedMime] = $this->parseImageData($image, $mimeType);
        $payloadUrl = str_starts_with($image, 'data:') ? $image : "data:{$resolvedMime};base64,{$base64}";

        $promptText = trim($userNotes) !== ''
            ? 'Read ALL mathematical/scientific content in this image with perfect accuracy. User context: "' . $userNotes . '". Return JSON only.'
            : 'Read ALL mathematical/scientific content in this image with perfect accuracy. Return JSON only.';

        $messages = [[
            'role' => 'user',
            'content' => [
                ['type' => 'text', 'text' => $promptText],
                ['type' => 'image_url', 'image_url' => ['url' => $payloadUrl]],
            ],
        ]];

        $keys = $this->getApiKeys('groq');
        $visionModel = config('site.api.groq_vision_model');
        $lastError = null;

        foreach ($keys as $apiKey) {
            try {
                $allMessages = [['role' => 'system', 'content' => $systemInstruction], ...$messages];
                $body = [
                    'model' => $visionModel,
                    'messages' => $allMessages,
                    'temperature' => 0.1,
                    'response_format' => ['type' => 'json_object'],
                ];

                $response = $this->httpPost(
                    'https://api.groq.com/openai/v1/chat/completions',
                    ['Content-Type: application/json', 'Authorization: Bearer ' . trim($apiKey)],
                    json_encode($body),
                    120
                );

                $data = json_decode($response, true);
                $raw = $data['choices'][0]['message']['content'] ?? '';
                return $this->parseImageTranscription($raw, $userNotes);
            } catch (\Throwable $e) {
                $lastError = $e;
                report($e);
            }
        }

        throw $lastError ?? new \RuntimeException('Groq Vision transcription failed');
    }

    private function transcribeImageWithGemini(string $image, ?string $mimeType, string $userNotes): array
    {
        [$base64, $resolvedMime] = $this->parseImageData($image, $mimeType);
        $prompt = trim($userNotes) !== ''
            ? 'Read ALL mathematical/scientific content in this image with perfect accuracy. User context: "' . $userNotes . '". Return JSON with displayText, latex, contentType, solverPrompt.'
            : 'Read ALL mathematical/scientific content in this image with perfect accuracy. Return JSON with displayText (readable plain text with Unicode symbols), latex (no $$), contentType, and solverPrompt.';

        $response = $this->callGeminiWithFailover(
            [['role' => 'user', 'parts' => [
                ['inlineData' => ['mimeType' => $resolvedMime, 'data' => $base64]],
                ['text' => $prompt],
            ]]],
            'You are a math/science OCR assistant. Read images accurately and return JSON only with displayText, latex, contentType, solverPrompt. Use Unicode symbols in displayText and proper LaTeX in latex field.',
            true
        );

        return $this->parseImageTranscription($response, $userNotes);
    }

    // ========================================================================
    // Chat (AI Tutor)
    // ========================================================================

    public function chat(?array $problemContext, array $chatHistory, string $newMessage): array
    {
        if (!$this->isAnyProviderConfigured()) {
            return ['text' => "Submit a problem first and I'll help you work through it step by step."];
        }

        $systemInstruction = $this->buildChatSystemInstruction($problemContext);
        $responses = [];

        // Try all providers for chat
        $providers = [
            'alpha' => fn() => $this->callChatWithProvider('groq', $chatHistory, $newMessage, $systemInstruction),
            'beta' => fn() => $this->callChatWithProvider('gemini_chat', $chatHistory, $newMessage, $systemInstruction),
            'gamma' => fn() => $this->callChatWithProvider('deepseek', $chatHistory, $newMessage, $systemInstruction),
            'delta' => fn() => $this->callChatWithProvider('mistral', $chatHistory, $newMessage, $systemInstruction),
        ];

        foreach ($providers as $key => $callable) {
            try {
                $text = $callable();
                if ($text !== null) {
                    $responses[$key] = $text;
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        if ($responses === []) {
            return ['text' => "I'm having trouble connecting right now. Please try again in a moment."];
        }

        // Synthesize if multiple responses
        $synthesis = null;
        if (count($responses) >= 2) {
            try {
                $synthesis = $this->synthesizeChatResponses($newMessage, $responses);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $text = $synthesis['text'] ?? reset($responses);

        return [
            'text' => $text,
            'alphaResponse' => $responses['alpha'] ?? null,
            'betaResponse' => $responses['beta'] ?? null,
            'gammaResponse' => $responses['gamma'] ?? null,
            'deltaResponse' => $responses['delta'] ?? null,
            'synthesis' => $synthesis,
        ];
    }

    private function callChatWithProvider(string $provider, array $chatHistory, string $newMessage, string $systemInstruction): ?string
    {
        if ($provider === 'gemini_chat') {
            if (!$this->hasKeys('gemini')) return null;
            return $this->callGeminiChat($chatHistory, $newMessage, $systemInstruction);
        }

        if (!$this->hasKeys($provider)) return null;

        $messages = [];
        foreach ($chatHistory as $msg) {
            $messages[] = [
                'role' => in_array($msg['role'] ?? '', ['model', 'assistant'], true) ? 'assistant' : 'user',
                'content' => $msg['text'] ?? '',
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $newMessage];

        return $this->callWithFailover($provider, $messages, $systemInstruction, false);
    }

    private function callGeminiChat(array $chatHistory, string $newMessage, string $systemInstruction): string
    {
        $contents = [];
        foreach ($chatHistory as $msg) {
            $role = in_array($msg['role'] ?? '', ['model', 'assistant'], true) ? 'model' : 'user';
            $contents[] = ['role' => $role, 'parts' => [['text' => $msg['text'] ?? '']]];
        }
        $contents[] = ['role' => 'user', 'parts' => [['text' => $newMessage]]];

        return $this->callGeminiWithFailover($contents, $systemInstruction, false);
    }

    // ========================================================================
    // Synthesis
    // ========================================================================

    private function synthesizeSolutions(string $problem, array $engines): array
    {
        $labels = ['alpha' => 'Solver A', 'beta' => 'Solver B', 'gamma' => 'Solver C', 'delta' => 'Solver D'];
        $systemInstruction = 'You are an expert STEM and Finance Peer Reviewer.
Study the solutions from multiple independent solvers for the problem provided.
Synthesize a unified, mathematically perfect solution representing the best consensus.
Use the solver labels provided (Solver A, B, C, D). Do NOT mention any AI brand names.

Return valid JSON matching this schema:
{"solvedProblem":"...","agreement":"agree|disagree|partial","comparisonMarkdown":"...","perfectAnswer":"...","finalAnswer":"...","steps":[{"title":"...","explanation":"...","formula":"..."}],"concepts":[{"name":"...","definition":"..."}],"graphable":boolean,"graphFunctions":["..."],"followUpQuestions":["..."]}';

        $prompt = 'Problem: "' . $problem . '"' . "\n\n";
        foreach ($engines as $key => $solution) {
            $label = $labels[$key] ?? $key;
            $prompt .= "--- {$label} ---\n";
            $prompt .= 'Answer: ' . ($solution['finalAnswer'] ?? '') . "\n";
            $prompt .= 'Steps: ' . json_encode($solution['steps'] ?? []) . "\n\n";
        }
        $prompt .= 'Synthesize a perfect solution in JSON.';

        $resp = $this->callBestAvailableProvider($prompt, $systemInstruction, true);
        return $this->parseJsonResponse($resp);
    }

    private function synthesizeChatResponses(string $question, array $responses): array
    {
        $labels = ['alpha' => 'Tutor A', 'beta' => 'Tutor B', 'gamma' => 'Tutor C', 'delta' => 'Tutor D'];
        $prompt = 'The student asked: "' . $question . "\"\n\n";
        foreach ($responses as $engine => $text) {
            $prompt .= '--- ' . ($labels[$engine] ?? $engine) . " ---\n{$text}\n\n";
        }
        $prompt .= 'Synthesize the best tutoring response. Return JSON: {"text":"...","comparisonMarkdown":"..."}';

        $system = 'You are a synthesis tutor. Merge multiple tutor answers into one clear, encouraging best answer. Do NOT mention any AI brand names. Return JSON only.';

        $raw = $this->callBestAvailableProvider($prompt, $system, true);
        $parsed = $this->parseJsonResponse($raw);

        return [
            'text' => $parsed['text'] ?? $raw,
            'comparisonMarkdown' => $parsed['comparisonMarkdown'] ?? '',
        ];
    }

    /**
     * Call whichever provider is available (prefer Gemini for synthesis, then Mistral, Groq, DeepSeek).
     */
    private function callBestAvailableProvider(string $prompt, string $systemInstruction, bool $jsonMode): string
    {
        if ($this->hasKeys('gemini')) {
            return $this->callGeminiWithFailover(
                [['role' => 'user', 'parts' => [['text' => $prompt]]]],
                $systemInstruction,
                $jsonMode
            );
        }

        foreach (['mistral', 'groq', 'deepseek'] as $provider) {
            if ($this->hasKeys($provider)) {
                return $this->callWithFailover($provider, [['role' => 'user', 'content' => $prompt]], $systemInstruction, $jsonMode);
            }
        }

        throw new \RuntimeException('No AI provider available for synthesis');
    }

    // ========================================================================
    // Helpers
    // ========================================================================

    private function mergeProblemWithTranscription(string $userNotes, array $transcription): string
    {
        $solverPrompt = trim($transcription['solverPrompt'] ?? '');
        $userNotes = trim($userNotes);

        if ($userNotes !== '') {
            return $solverPrompt !== '' ? $solverPrompt . "\n\nUser notes: " . $userNotes : $userNotes;
        }
        return $solverPrompt;
    }

    private function parseImageTranscription(string $raw, string $userNotes): array
    {
        $text = trim($raw);
        if (str_starts_with($text, '```')) {
            $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
            $text = preg_replace('/\s*```$/', '', $text);
        }

        $parsed = json_decode(trim($text), true);
        if (is_array($parsed)) {
            $displayText = trim((string)($parsed['displayText'] ?? $parsed['plainText'] ?? ''));
            $latex = trim((string)($parsed['latex'] ?? ''));
            $contentType = trim((string)($parsed['contentType'] ?? 'unknown'));
            $solverPrompt = trim((string)($parsed['solverPrompt'] ?? ''));

            if ($displayText === '' && $latex !== '') {
                $displayText = $this->latexToReadableText($latex);
            }

            if ($solverPrompt === '') {
                $solverPrompt = $this->buildSolverPromptFromTranscription($displayText, $latex, $contentType, $userNotes);
            }

            return [
                'displayText' => $displayText ?: $this->latexToReadableText($latex),
                'latex' => $latex !== '' ? $this->normalizeLatex($latex) : null,
                'solverPrompt' => $solverPrompt,
                'contentType' => $contentType ?: 'unknown',
            ];
        }

        return $this->normalizeLegacyOcrText($text, $userNotes);
    }

    private function buildSolverPromptFromTranscription(string $displayText, string $latex, string $contentType, string $userNotes): string
    {
        $label = $displayText ?: $this->latexToReadableText($latex);
        $math = $latex !== '' ? ' Formula: ' . $this->normalizeLatex($latex) : '';

        return match ($contentType) {
            'formula', 'formula_reference', 'theorem', 'definition' => "The image shows a mathematical formula or definition: {$label}.{$math} Explain what it means, define each variable or symbol, when it is used, and demonstrate with one clear worked example.",
            'equation', 'system_of_equations' => "Solve this equation step by step: {$label}.{$math}",
            'expression' => "Analyze and simplify this expression step by step: {$label}.{$math}",
            'integral' => "Evaluate this integral step by step: {$label}.{$math}",
            'differential_equation' => "Solve this differential equation step by step: {$label}.{$math}",
            'inequality' => "Solve this inequality step by step: {$label}.{$math}",
            'matrix' => "Perform the indicated matrix operations: {$label}.{$math}",
            default => $userNotes !== ''
                ? "Using this content from the image: {$label}.{$math} Task: {$userNotes}"
                : "Analyze the math content from the image and provide a complete step-by-step response. Content: {$label}.{$math}",
        };
    }

    private function normalizeLegacyOcrText(string $raw, string $userNotes): array
    {
        $latex = $this->extractLatexFromText($raw);
        $displayText = $latex !== null ? $this->latexToReadableText($latex) : $this->cleanOcrPlainText($raw);
        $contentType = preg_match('/=|\?|solve|find|calculate/i', $raw) ? 'equation' : 'formula';

        return [
            'displayText' => $displayText,
            'latex' => $latex,
            'solverPrompt' => $this->buildSolverPromptFromTranscription($displayText, $latex ?? '', $contentType, $userNotes),
            'contentType' => $contentType,
        ];
    }

    private function extractLatexFromText(string $text): ?string
    {
        if (preg_match('/\$\$(.+?)\$\$/s', $text, $m)) return $this->normalizeLatex(trim($m[1]));
        if (preg_match('/\\\[(.+?)\\\]/s', $text, $m)) return $this->normalizeLatex(trim($m[1]));
        if (preg_match('/\\\((.+?)\\\)/s', $text, $m)) return $this->normalizeLatex(trim($m[1]));
        if (str_contains($text, '\\frac') || str_contains($text, '\\sqrt') || str_contains($text, '\\pm')) {
            return $this->normalizeLatex(trim($text, " \t\n\r\0\x0B$"));
        }
        return null;
    }

    private function normalizeLatex(string $latex): string
    {
        $latex = trim($latex);
        $latex = preg_replace('/^\$\$|\$\$$/', '', $latex);
        $latex = preg_replace('/^\\\(|\\\)$/', '', $latex);
        $latex = preg_replace('/^\\\[|\\\]$/', '', $latex);
        return trim($latex);
    }

    private function latexToReadableText(string $latex): string
    {
        $text = $this->normalizeLatex($latex);
        $text = preg_replace('/\\\\frac\{([^}]+)\}\{([^}]+)\}/', '($1)/($2)', $text);
        $text = str_replace(
            ['\\pm', '\\times', '\\cdot', '\\leq', '\\geq', '\\neq', '\\infty', '\\pi', '\\alpha', '\\beta', '\\gamma', '\\delta', '\\theta', '\\sigma', '\\omega', '\\lambda', '\\mu', '\\epsilon', '\\phi', '\\nabla', '\\partial', '\\forall', '\\exists', '\\in', '\\sum', '\\prod', '\\int', '\\approx', '\\propto', '\\rightarrow', '\\Rightarrow'],
            ['±', '×', '·', '≤', '≥', '≠', '∞', 'π', 'α', 'β', 'γ', 'δ', 'θ', 'σ', 'ω', 'λ', 'μ', 'ε', 'φ', '∇', '∂', '∀', '∃', '∈', 'Σ', 'Π', '∫', '≈', '∝', '→', '⇒'],
            $text
        );
        $text = preg_replace('/\\\\sqrt\{([^}]+)\}/', '√($1)', $text);
        $text = preg_replace('/\^2\b/', '²', $text);
        $text = preg_replace('/\^3\b/', '³', $text);
        $text = preg_replace('/\\\\([a-zA-Z]+)/', '$1', $text);
        $text = str_replace(['{', '}', '_'], '', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    private function cleanOcrPlainText(string $text): string
    {
        return trim(preg_replace('/^\$\$|\$\$$/', '', trim($text)));
    }

    private function buildChatSystemInstruction(?array $problemContext): string
    {
        return 'You are a friendly, encouraging, and highly competent AI scientific and financial coach and tutor.
You are helping a scientist, student, professional, or CA work through their current line of inquiry.
Here is the context of the problem they are currently solving:
Original problem: ' . json_encode($problemContext['solvedProblem'] ?? '') . '
Calculated full final answer: ' . json_encode($problemContext['finalAnswer'] ?? '') . '

Follow these instructions strictly:
1. Do not simply blurt out the final solution instantly if they ask you for alternative expressions. Give helpful clues, ask guiding questions, and break down complex logic conceptually.
2. Keep your responses clear, practical, and highly positive.
3. Keep answers concise, and ALWAYS format your answers using markdown paragraphs, bold key terms, block lists, and markdown tables when comparing formulas, constants, options or variable items. Avoid long blocks of uninterrupted raw prose. Use LaTeX math style like $x^2$ or $$E=mc^2$$ where helpful.
4. Do NOT mention any AI brand names (Groq, Gemini, DeepSeek, Mistral, OpenAI, etc.).';
    }

    private function buildSolveSystemPrompt(string $mode): string
    {
        return 'You are a world-class, multi-disciplinary Scientific & Financial AI Solver.
Your task is to solve the given STEM or professional query according to the requested mode: "' . $mode . '".

The query may cover mathematics, physics, chemistry, biology, finance, and engineering.
Solve it step-by-step according to the mode:
- "step-by-step": Break down the problem logically with clear steps and intermediate equations.
- "conceptual": Focus on explaining formulas, definitions, theorems, and core principles.
- "interactive": Outline full solution steps and write follow-up practice questions.
- "graph": Emphasize mathematical curves, coordinate behavior, trends, and plots.

Use markdown tables and lists where helpful. Use LaTeX notation in formulas when appropriate.
If graphable, set graphable to true and provide JavaScript-compatible expressions in graphFunctions (e.g. "2*x + 3", "Math.sin(x)").

IMPORTANT: Do NOT mention any AI brand names (Groq, Gemini, DeepSeek, Mistral, OpenAI, etc.) anywhere in your response.

Return ONLY valid JSON matching this schema:
{"solvedProblem":"...","finalAnswer":"...","steps":[{"title":"...","explanation":"...","formula":"..."}],"concepts":[{"name":"...","definition":"..."}],"graphable":boolean,"graphFunctions":["..."],"followUpQuestions":["..."]}';
    }

    private function parseJsonResponse(string $response): array
    {
        $text = trim($response);
        if (str_starts_with($text, '```')) {
            $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
            $text = preg_replace('/\s*```$/', '', $text);
        }

        $parsed = json_decode(trim($text), true);
        if (!is_array($parsed)) {
            throw new \RuntimeException('Invalid JSON response from AI provider.');
        }
        return $parsed;
    }

    private function parseImageData(string $image, ?string $mimeType): array
    {
        if (str_starts_with($image, 'data:')) {
            if (preg_match('/^data:([^;]+);base64,(.*)$/', $image, $matches)) {
                return [$matches[2], $matches[1]];
            }
        }
        return [$image, $mimeType ?: 'image/png'];
    }

    private function httpPost(string $url, array $headers, string $body, int $timeout = 60): string
    {
        $ch = curl_init($url);
        $options = [
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
        ];

        if (app()->environment('local')) {
            $options[CURLOPT_SSL_VERIFYPEER] = false;
            $options[CURLOPT_SSL_VERIFYHOST] = 0;
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || $httpCode !== 200) {
            $detail = $curlError ?: '';
            if (is_string($response) && $response !== '') {
                $decoded = json_decode($response, true);
                if (is_array($decoded)) {
                    $detail = $decoded['error']['message'] ?? ($decoded['error']['code'] ?? substr($response, 0, 200));
                } else {
                    $detail = substr($response, 0, 200);
                }
            }
            throw new \RuntimeException(
                'API request failed' . ($httpCode ? " (HTTP {$httpCode})" : '') . ($detail ? ": {$detail}" : '')
            );
        }

        return $response;
    }

    // ========================================================================
    // Offline / fallback solver
    // ========================================================================

    public function offlineSolve(string $problem, string $mode, ?string $image): array
    {
        $clean = trim($problem);

        if ($image) {
            return [
                'solvedProblem' => $clean ?: 'Visual Math Problem',
                'finalAnswer' => 'Try a clearer photo or type the problem manually',
                'steps' => [
                    ['title' => 'Visual Scanner', 'explanation' => 'We could not fully process this image. Try a well-lit photo with clear handwriting or printed text.', 'formula' => ''],
                    ['title' => 'Text Mode', 'explanation' => 'You can also type equations directly, for example: 2x² + 5x - 3 = 0', 'formula' => 'ax² + bx + c = 0'],
                ],
                'concepts' => [['name' => 'Visual Transcription', 'definition' => 'Clear photos help the scanner read math symbols accurately.']],
                'graphable' => false,
                'graphFunctions' => [],
                'followUpQuestions' => ['Solve 2x² + 5x - 3 = 0', 'What is the quadratic formula?'],
            ];
        }

        $normalized = strtolower(preg_replace('/\s+/', '', $clean));

        // Quadratic equations
        if (preg_match('/^([+-]?\d*(?:\.\d+)?)x\^2([+-]?\d*(?:\.\d+)?)x([+-]?\d*(?:\.\d+)?)(?:=0)?$/', $normalized, $m)) {
            $a = $m[1] === '' || $m[1] === '+' ? 1 : ($m[1] === '-' ? -1 : (float)$m[1]);
            $b = $m[2] === '' || $m[2] === '+' ? 1 : ($m[2] === '-' ? -1 : (float)$m[2]);
            $c = (float)($m[3] ?: 0);

            if ($a != 0) {
                $disc = $b * $b - 4 * $a * $c;
                $steps = [
                    ['title' => 'Step 1: Extract coefficients', 'explanation' => "From ax² + bx + c = 0: a = {$a}, b = {$b}, c = {$c}", 'formula' => "a = {$a}, b = {$b}, c = {$c}"],
                    ['title' => 'Step 2: Compute discriminant', 'explanation' => 'D = b² − 4ac determines the nature of roots.', 'formula' => "D = ({$b})² − 4({$a})({$c}) = {$disc}"],
                ];

                if ($disc > 0) {
                    $x1 = round((-$b + sqrt($disc)) / (2 * $a), 4);
                    $x2 = round((-$b - sqrt($disc)) / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Apply quadratic formula', 'explanation' => 'Two real roots found.', 'formula' => 'x = (−b ± √D) / 2a'];
                    $answer = "x = {$x1}, x = {$x2}";
                } elseif ($disc == 0) {
                    $x = round(-$b / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Repeated root', 'explanation' => 'One repeated real root.', 'formula' => 'x = −b / 2a'];
                    $answer = "x = {$x}";
                } else {
                    $real = round(-$b / (2 * $a), 4);
                    $imag = round(sqrt(-$disc) / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Complex roots', 'explanation' => 'Discriminant is negative.', 'formula' => "x = {$real} ± {$imag}i"];
                    $answer = "x = {$real} + {$imag}i, x = {$real} − {$imag}i";
                }

                return [
                    'solvedProblem' => $clean,
                    'finalAnswer' => $answer,
                    'steps' => $steps,
                    'concepts' => [
                        ['name' => 'Quadratic Formula', 'definition' => 'Solutions of ax² + bx + c = 0.'],
                        ['name' => 'Discriminant', 'definition' => 'b² − 4ac indicates root type.'],
                    ],
                    'graphable' => true,
                    'graphFunctions' => ["{$a}*Math.pow(x,2) + ({$b}*x) + ({$c})"],
                    'followUpQuestions' => ['What is the vertex?', 'How do you factor this?', 'What are complex roots?'],
                ];
            }
        }

        // Linear equations
        if (preg_match('/^([+-]?\d*(?:\.\d+)?)x([+-]?\d*(?:\.\d+)?)=([+-]?\d*(?:\.\d+)?)$/', $normalized, $m)) {
            $a = $m[1] === '' || $m[1] === '+' ? 1 : ($m[1] === '-' ? -1 : (float)$m[1]);
            $b = (float)($m[2] ?: 0);
            $c = (float)($m[3] ?: 0);

            if ($a != 0) {
                $rest = $c - $b;
                $ans = $rest / $a;

                return [
                    'solvedProblem' => $clean,
                    'finalAnswer' => 'x = ' . round($ans, 4),
                    'steps' => [
                        ['title' => 'Step 1: Simplify constants', 'explanation' => "Subtract {$b} from both sides.", 'formula' => "{$a}x = {$rest}"],
                        ['title' => 'Step 2: Isolate x', 'explanation' => "Divide by {$a}.", 'formula' => 'x = ' . round($ans, 4)],
                    ],
                    'concepts' => [['name' => 'Linear Equations', 'definition' => 'First-degree equations with one unique solution.']],
                    'graphable' => true,
                    'graphFunctions' => ["{$a}*x + {$b} - {$c}"],
                    'followUpQuestions' => ['What is the slope?', 'How can we verify this root?'],
                ];
            }
        }

        // Basic arithmetic
        if (preg_match('/^([\d.]+)\s*([+\-*\/×÷])\s*([\d.]+)$/', $clean, $m)) {
            $a = (float)$m[1];
            $op = $m[2];
            $b = (float)$m[3];
            $opName = match($op) { '+' => 'Addition', '-' => 'Subtraction', '*', '×' => 'Multiplication', '/', '÷' => 'Division', default => 'Arithmetic' };
            $result = match($op) { '+' => $a + $b, '-' => $a - $b, '*', '×' => $a * $b, '/', '÷' => $b != 0 ? $a / $b : 'undefined', default => 'N/A' };

            return [
                'solvedProblem' => $clean,
                'finalAnswer' => (string)$result,
                'steps' => [
                    ['title' => 'Step 1: Identify operation', 'explanation' => "{$opName} of {$a} and {$b}.", 'formula' => "{$a} {$op} {$b}"],
                    ['title' => 'Step 2: Calculate', 'explanation' => "Result: {$result}", 'formula' => "{$a} {$op} {$b} = {$result}"],
                ],
                'concepts' => [['name' => $opName, 'definition' => "Basic arithmetic {$opName} operation."]],
                'graphable' => false,
                'graphFunctions' => [],
                'followUpQuestions' => ['What is ' . ($a * 2) . " {$op} " . ($b * 2) . '?'],
            ];
        }

        return [
            'solvedProblem' => $clean ?: 'Math Workspace',
            'finalAnswer' => 'Try rephrasing or use a sample problem below',
            'steps' => [
                ['title' => 'Getting Started', 'explanation' => 'Type any math, physics, chemistry, or finance problem. You can also upload a photo of a handwritten equation.', 'formula' => ''],
                ['title' => 'Example Problems', 'explanation' => 'Try: "Solve 2x² + 5x − 3 = 0" or "What is the derivative of sin(x)?" or "Calculate compound interest on $1000 at 5% for 3 years"', 'formula' => ''],
            ],
            'concepts' => [['name' => 'AI Math Solver', 'definition' => 'Multi-engine step-by-step solving with graphs and tutoring.']],
            'graphable' => true,
            'graphFunctions' => ['Math.sin(x)', 'Math.cos(x)'],
            'followUpQuestions' => ['Solve 2x² + 5x − 3 = 0', 'Plot y = sin(x)', 'What is the quadratic formula?'],
        ];
    }
}
