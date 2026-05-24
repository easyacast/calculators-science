<?php

namespace App\Services;

class MathSolverService
{
    public function solve(string $problem, string $mode = 'step-by-step', ?string $image = null, ?string $mimeType = null): array
    {
        $problem = trim($problem);
        $mode = $mode ?: 'step-by-step';
        $extractedText = null;
        $extractedLatex = null;
        $hadImage = (bool) $image;

        if ($problem === '' && ! $image) {
            return $this->offlineSolve('', $mode, $image);
        }

        if (! $this->isApiKeyConfigured()) {
            return $this->offlineSolve($problem, $mode, $image);
        }

        if ($image) {
            if (! $this->isGroqConfigured() && ! $this->isGeminiConfigured()) {
                return $this->offlineSolve($problem, $mode, $image);
            }

            try {
                $transcription = $this->transcribeImageToText($image, $mimeType, $problem);
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

        $groqData = null;
        $geminiData = null;
        $deepseekData = null;
        $groqError = null;
        $geminiError = null;
        $deepseekError = null;

        if ($this->isGroqConfigured()) {
            try {
                $groqData = $this->callGroqSolve($problem, $mode);
            } catch (\Throwable $e) {
                report($e);
                $groqError = $e->getMessage();
            }
        }

        if ($this->isGeminiConfigured()) {
            try {
                $geminiData = $this->callGeminiSolve($problem, $mode, null, null);
            } catch (\Throwable $e) {
                report($e);
                $geminiError = $e->getMessage();
            }
        }

        if ($this->isDeepSeekConfigured()) {
            try {
                $deepseekData = $this->callDeepSeekSolve($problem, $mode);
            } catch (\Throwable $e) {
                report($e);
                $deepseekError = $e->getMessage();
            }
        }

        $synthesisData = null;
        $labeledSolutions = array_filter([
            'Solver Alpha' => $groqData,
            'Solver Beta' => $geminiData,
            'Solver Gamma' => $deepseekData,
        ]);

        if (count($labeledSolutions) >= 2) {
            try {
                $synthesisData = $this->callMultiAiSynthesis($problem, $labeledSolutions);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $primary = $synthesisData ?: ($groqData ?: ($deepseekData ?: $geminiData));

        if (! $primary) {
            $offline = $this->offlineSolve($problem, $mode, null);
            $offline['extractedText'] = $extractedText;
            $offline['extractedLatex'] = $extractedLatex;

            return $offline;
        }

        return [
            'solvedProblem' => $primary['solvedProblem'] ?? $problem,
            'finalAnswer' => $primary['finalAnswer'] ?? ($primary['perfectAnswer'] ?? 'Checked Answer'),
            'steps' => $primary['steps'] ?? [],
            'concepts' => $primary['concepts'] ?? [],
            'graphable' => $primary['graphable'] ?? false,
            'graphFunctions' => $primary['graphFunctions'] ?? [],
            'followUpQuestions' => $primary['followUpQuestions'] ?? [],
            'alphaResponse' => $groqData,
            'betaResponse' => $geminiData,
            'gammaResponse' => $deepseekData,
            'extractedText' => $extractedText,
            'extractedLatex' => $extractedLatex,
            'synthesis' => $synthesisData ? [
                'agreement' => $synthesisData['agreement'] ?? 'partial',
                'comparisonMarkdown' => $synthesisData['comparisonMarkdown'] ?? '',
                'perfectAnswer' => $synthesisData['perfectAnswer'] ?? ($synthesisData['finalAnswer'] ?? ''),
            ] : null,
        ];
    }

    private function mergeProblemWithTranscription(string $userNotes, array $transcription): string
    {
        $solverPrompt = trim($transcription['solverPrompt'] ?? '');
        $userNotes = trim($userNotes);

        if ($userNotes !== '') {
            return $solverPrompt !== ''
                ? $solverPrompt."\n\nUser notes: ".$userNotes
                : $userNotes;
        }

        return $solverPrompt;
    }

    /**
     * @return array{displayText: string, latex: ?string, solverPrompt: string, contentType: string}
     */
    private function transcribeImageToText(string $image, ?string $mimeType, string $userNotes): array
    {
        if ($this->isGroqConfigured()) {
            return $this->transcribeImageWithGroq($image, $mimeType, $userNotes);
        }

        if ($this->isGeminiConfigured()) {
            return $this->transcribeImageWithGemini($image, $mimeType, $userNotes);
        }

        throw new \RuntimeException('Configure GROQ_API_KEY for image reading.');
    }

    /**
     * @return array{displayText: string, latex: ?string, solverPrompt: string, contentType: string}
     */
    private function parseImageTranscription(string $raw, string $userNotes): array
    {
        $text = trim($raw);
        if (str_starts_with($text, '```')) {
            $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
            $text = preg_replace('/\s*```$/', '', $text);
        }

        $parsed = json_decode(trim($text), true);
        if (is_array($parsed)) {
            $displayText = trim((string) ($parsed['displayText'] ?? $parsed['plainText'] ?? ''));
            $latex = trim((string) ($parsed['latex'] ?? ''));
            $contentType = trim((string) ($parsed['contentType'] ?? 'unknown'));
            $solverPrompt = trim((string) ($parsed['solverPrompt'] ?? ''));

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
        $math = $latex !== '' ? ' Formula: '.$this->normalizeLatex($latex) : '';

        return match ($contentType) {
            'formula', 'formula_reference', 'theorem', 'definition' => "The image shows a mathematical formula or definition: {$label}.{$math} Explain what it means, define each variable or symbol, when it is used, and demonstrate with one clear worked example.",
            'equation' => "Solve this equation step by step: {$label}.{$math}",
            'expression' => "Analyze and simplify this expression step by step: {$label}.{$math}",
            default => $userNotes !== ''
                ? "Using this content from the image: {$label}.{$math} Task: {$userNotes}"
                : "Analyze the math content from the image and provide a complete step-by-step response. Content: {$label}.{$math}",
        };
    }

    /**
     * @return array{displayText: string, latex: ?string, solverPrompt: string, contentType: string}
     */
    private function normalizeLegacyOcrText(string $raw, string $userNotes): array
    {
        $latex = $this->extractLatexFromText($raw);
        $displayText = $latex !== null
            ? $this->latexToReadableText($latex)
            : $this->cleanOcrPlainText($raw);

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
        if (preg_match('/\$\$(.+?)\$\$/s', $text, $matches)) {
            return $this->normalizeLatex(trim($matches[1]));
        }

        if (preg_match('/\\\[(.+?)\\\]/s', $text, $matches)) {
            return $this->normalizeLatex(trim($matches[1]));
        }

        if (preg_match('/\\\((.+?)\\\)/s', $text, $matches)) {
            return $this->normalizeLatex(trim($matches[1]));
        }

        if (str_contains($text, '\\frac') || str_contains($text, '\\sqrt') || str_contains($text, '\\pm')) {
            return $this->normalizeLatex(trim($text, " \t\n\r\0\x0B$"));
        }

        return null;
    }

    private function normalizeLatex(string $latex): string
    {
        $latex = trim($latex);
        $latex = preg_replace('/^\$\$|\$\$$/', '', $latex);
        $latex = preg_replace('/^\\\(|\\\)$/','', $latex);
        $latex = preg_replace('/^\\\[|\\\]$/','', $latex);

        return trim($latex);
    }

    private function latexToReadableText(string $latex): string
    {
        $text = $this->normalizeLatex($latex);
        $text = preg_replace('/\\\\frac\{([^}]+)\}\{([^}]+)\}/', '($1)/($2)', $text);
        $text = str_replace(['\\pm', '\\times', '\\cdot', '\\leq', '\\geq', '\\neq'], ['±', '×', '·', '≤', '≥', '≠'], $text);
        $text = preg_replace('/\\\\sqrt\{([^}]+)\}/', '√($1)', $text);
        $text = preg_replace('/\^2\b/', '²', $text);
        $text = preg_replace('/\^3\b/', '³', $text);
        $text = preg_replace('/\\\\([a-zA-Z]+)/', '$1', $text);
        $text = str_replace(['{', '}', '_'], '', $text);
        $text = preg_replace('/\s+/', ' ', $text);

        if (preg_match('/\(.*?-.*?b.*?\^2.*?-.*?4.*?a.*?c.*?\)/i', $text)) {
            return 'Quadratic formula: '.$text;
        }

        return trim($text);
    }

    private function cleanOcrPlainText(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/^\$\$|\$\$$/', '', $text);

        return trim($text);
    }

    public function chat(?array $problemContext, array $chatHistory, string $newMessage): array
    {
        if (! $this->isApiKeyConfigured()) {
            return [
                'text' => "Hi! I'm your AI tutoring assistant. Submit a problem in the sidebar and I'll help you work through it step by step.",
            ];
        }

        $systemInstruction = $this->buildChatSystemInstruction($problemContext);
        $groqText = null;
        $geminiText = null;
        $deepseekText = null;

        if ($this->isGroqConfigured()) {
            try {
                $groqText = $this->callGroqChat($chatHistory, $newMessage, $systemInstruction);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        if ($this->isGeminiConfigured()) {
            try {
                $geminiText = $this->callGeminiChat($chatHistory, $newMessage, $systemInstruction);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        if ($this->isDeepSeekConfigured()) {
            try {
                $deepseekText = $this->callDeepSeekChat($chatHistory, $newMessage, $systemInstruction);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $responses = array_filter([
            'alpha' => $groqText,
            'beta' => $geminiText,
            'gamma' => $deepseekText,
        ]);

        if ($responses === []) {
            return [
                'text' => "I'm having trouble connecting to the AI tutoring service. Please try again in a moment.",
            ];
        }

        $synthesis = null;
        if (count($responses) >= 2) {
            try {
                $synthesis = $this->callChatSynthesis($newMessage, $responses);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $text = $synthesis['text'] ?? ($groqText ?? ($deepseekText ?? ($geminiText ?? '')));

        return [
            'text' => $text,
            'alphaResponse' => $groqText,
            'betaResponse' => $geminiText,
            'gammaResponse' => $deepseekText,
            'synthesis' => $synthesis,
        ];
    }

    private function buildChatSystemInstruction(?array $problemContext): string
    {
        return 'You are a friendly, encouraging, and highly competent AI scientific and financial coach and tutor.
You are helping a scientist, student, professional, or CA work through their current line of inquiry.
Here is the context of the problem they are currently solving:
Original problem: '.json_encode($problemContext['solvedProblem'] ?? '').'
Calculated full final answer: '.json_encode($problemContext['finalAnswer'] ?? '').'

Follow these instructions strictly:
1. Do not simply blurt out the final solution instantly if they ask you for alternative expressions. Give helpful clues, ask guiding questions, and break down complex logic conceptually.
2. Keep your responses clear, practical, and highly positive.
3. Keep answers concise, and ALWAYS format your answers using markdown paragraphs, bold key terms, block lists, and markdown tables when comparing formulas, constants, options or variable items. Avoid long blocks of uninterrupted raw prose. Use LaTeX math style like $x^2$ or $$E=mc^2$$ where helpful.';
    }

    private function isGroqConfigured(): bool
    {
        $key = config('site.api.groq_api_key');

        return is_string($key) && trim($key) !== '';
    }

    private function isGeminiConfigured(): bool
    {
        $key = config('site.api.gemini_api_key');

        return is_string($key) && trim($key) !== '';
    }

    private function isDeepSeekConfigured(): bool
    {
        $key = config('site.api.deepseek_api_key');

        return is_string($key) && trim($key) !== '';
    }

    private function isApiKeyConfigured(): bool
    {
        return $this->isGroqConfigured() || $this->isGeminiConfigured() || $this->isDeepSeekConfigured();
    }

    private function callGroqSolve(string $problem, string $mode): array
    {
        $systemInstruction = $this->buildSolveSystemPrompt($mode);
        $promptText = 'Solve the query: "'.$problem.'". Output results strictly in JSON conforming to the requested schema.';
        $messages = [['role' => 'user', 'content' => $promptText]];
        $response = $this->callGroq($messages, $systemInstruction, config('site.api.groq_model'), true);

        return $this->parseJsonResponse($response);
    }

    private function callDeepSeekSolve(string $problem, string $mode): array
    {
        $systemInstruction = $this->buildSolveSystemPrompt($mode);
        $promptText = 'Solve the query: "'.$problem.'". Output results strictly in JSON conforming to the requested schema.';
        $messages = [['role' => 'user', 'content' => $promptText]];
        $response = $this->callDeepSeek($messages, $systemInstruction, config('site.api.deepseek_model'), true);

        return $this->parseJsonResponse($response);
    }

    private function transcribeImageWithGroq(string $image, ?string $mimeType, string $userNotes): array
    {
        $systemInstruction = 'You are an expert math OCR assistant. Read math images accurately and return JSON only.

Rules:
1. displayText must be plain, human-readable math (Unicode symbols like ±, √, ² are OK). Example: "Quadratic formula: x = (-b ± √(b² − 4ac)) / (2a)"
2. latex must be clean LaTeX WITHOUT $$ wrappers. Example: "x = \\frac{-b \\pm \\sqrt{b^2 - 4ac}}{2a}"
3. contentType: one of formula, formula_reference, equation, expression, word_problem, diagram
4. solverPrompt: a clear instruction for a math tutor AI. If the image is a formula/theorem (not an equation to solve), ask to explain it, define symbols, and give one worked example. If it is an equation, ask to solve it step by step.
5. Do NOT solve the problem in this response.

Return JSON schema:
{"displayText":"...","latex":"...","contentType":"...","solverPrompt":"..."}';

        [$base64, $resolvedMime] = $this->parseImageData($image, $mimeType);
        $payloadUrl = str_starts_with($image, 'data:') ? $image : "data:{$resolvedMime};base64,{$base64}";

        $promptText = trim($userNotes) !== ''
            ? 'Read the math in this image. User context: "'.$userNotes.'". Return JSON only.'
            : 'Read all math content in this image. Return JSON only.';

        $messages = [[
            'role' => 'user',
            'content' => [
                ['type' => 'text', 'text' => $promptText],
                ['type' => 'image_url', 'image_url' => ['url' => $payloadUrl]],
            ],
        ]];

        $response = $this->callGroq($messages, $systemInstruction, config('site.api.groq_vision_model'), true, 120);

        return $this->parseImageTranscription($response, $userNotes);
    }

    private function transcribeImageWithGemini(string $image, ?string $mimeType, string $userNotes): array
    {
        [$base64, $resolvedMime] = $this->parseImageData($image, $mimeType);
        $prompt = trim($userNotes) !== ''
            ? 'Read the math in this image. User context: "'.$userNotes.'". Return JSON with displayText, latex, contentType, solverPrompt.'
            : 'Read all math content in this image. Return JSON with displayText (readable plain text), latex (no $$), contentType, and solverPrompt.';

        $response = $this->callGemini(
            [['role' => 'user', 'parts' => [
                ['inlineData' => ['mimeType' => $resolvedMime, 'data' => $base64]],
                ['text' => $prompt],
            ]]],
            'You are a math OCR assistant. Return JSON only with displayText, latex, contentType, solverPrompt. Use readable plain text in displayText.',
            true
        );

        return $this->parseImageTranscription($response, $userNotes);
    }

    private function callGroqChat(array $chatHistory, string $newMessage, string $systemInstruction): string
    {
        $messages = [];
        foreach ($chatHistory as $msg) {
            $messages[] = [
                'role' => in_array($msg['role'] ?? '', ['model', 'assistant'], true) ? 'assistant' : 'user',
                'content' => $msg['text'] ?? '',
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $newMessage];

        return $this->callGroq($messages, $systemInstruction, config('site.api.groq_model'), false);
    }

    private function callDeepSeekChat(array $chatHistory, string $newMessage, string $systemInstruction): string
    {
        $messages = [];
        foreach ($chatHistory as $msg) {
            $messages[] = [
                'role' => in_array($msg['role'] ?? '', ['model', 'assistant'], true) ? 'assistant' : 'user',
                'content' => $msg['text'] ?? '',
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $newMessage];

        return $this->callDeepSeek($messages, $systemInstruction, config('site.api.deepseek_model'), false);
    }

    private function callGeminiSolve(string $problem, string $mode, ?string $image, ?string $mimeType): array
    {
        $systemInstruction = $this->buildSolveSystemPrompt($mode);
        $parts = [];

        if ($image) {
            [$base64, $resolvedMime] = $this->parseImageData($image, $mimeType);
            $parts[] = ['inlineData' => ['mimeType' => $resolvedMime, 'data' => $base64]];
            $parts[] = ['text' => 'Solve this problem from the image. Additional instructions: "'.($problem ?: '').'"'];
        } else {
            $parts[] = ['text' => 'Solve this problem structure: "'.$problem.'"'];
        }

        $response = $this->callGemini(
            [['role' => 'user', 'parts' => $parts]],
            $systemInstruction,
            true
        );

        return $this->parseJsonResponse($response);
    }

    private function callMultiAiSynthesis(string $problem, array $labeledSolutions): array
    {
        $systemInstruction = 'You are an expert STEM and Finance Peer Reviewer and Synthesis Tutoress.
Study the solutions from multiple independent solvers for the problem provided.
Synthesize a unified, mathematically perfect solution representing the best consensus.
Use the solver labels provided (Solver Alpha, Solver Beta, Solver Gamma). Do NOT mention brand names like Groq, Gemini, or DeepSeek.

Return valid JSON matching this schema:
{"solvedProblem":"...","agreement":"agree|disagree|partial","comparisonMarkdown":"...","perfectAnswer":"...","finalAnswer":"...","steps":[{"title":"...","explanation":"...","formula":"..."}],"concepts":[{"name":"...","definition":"..."}],"graphable":boolean,"graphFunctions":["..."],"followUpQuestions":["..."]}';

        $prompt = 'Solve Problem: "'.$problem.'"'."\n\n";
        foreach ($labeledSolutions as $label => $solution) {
            $prompt .= "--- {$label} ---\n";
            $prompt .= 'Answer: '.($solution['finalAnswer'] ?? '')."\n";
            $prompt .= 'Steps: '.json_encode($solution['steps'] ?? [])."\n\n";
        }
        $prompt .= 'Output comparative details and synthesized perfect steps in JSON format matching the schema.';

        if ($this->isGeminiConfigured()) {
            $response = $this->callGemini(
                [['role' => 'user', 'parts' => [['text' => $prompt]]]],
                $systemInstruction,
                true
            );
        } elseif ($this->isGroqConfigured()) {
            $response = $this->callGroq(
                [['role' => 'user', 'content' => $prompt]],
                $systemInstruction,
                config('site.api.groq_model'),
                true
            );
        } else {
            $response = $this->callDeepSeek(
                [['role' => 'user', 'content' => $prompt]],
                $systemInstruction,
                config('site.api.deepseek_model'),
                true
            );
        }

        return $this->parseJsonResponse($response);
    }

    private function callChatSynthesis(string $question, array $responses): array
    {
        $labels = ['alpha' => 'Tutor Alpha', 'beta' => 'Tutor Beta', 'gamma' => 'Tutor Gamma'];
        $prompt = 'The student asked: "'.$question."\"\n\n";
        foreach ($responses as $engine => $text) {
            $prompt .= '--- '.($labels[$engine] ?? $engine)." ---\n{$text}\n\n";
        }
        $prompt .= 'Synthesize the best tutoring response combining the strongest explanations from all tutors. Use markdown. Return JSON: {"text":"...","comparisonMarkdown":"..."}';

        $system = 'You are a synthesis tutor. Merge multiple tutor answers into one clear, encouraging best answer. Return JSON only.';

        if ($this->isGeminiConfigured()) {
            $raw = $this->callGemini(
                [['role' => 'user', 'parts' => [['text' => $prompt]]]],
                $system,
                true
            );
        } elseif ($this->isGroqConfigured()) {
            $raw = $this->callGroq([['role' => 'user', 'content' => $prompt]], $system, config('site.api.groq_model'), true);
        } else {
            $raw = $this->callDeepSeek([['role' => 'user', 'content' => $prompt]], $system, config('site.api.deepseek_model'), true);
        }

        $parsed = $this->parseJsonResponse($raw);

        return [
            'text' => $parsed['text'] ?? $raw,
            'comparisonMarkdown' => $parsed['comparisonMarkdown'] ?? '',
        ];
    }

    private function callGeminiChat(array $chatHistory, string $newMessage, string $systemInstruction): string
    {
        $contents = [];
        foreach ($chatHistory as $msg) {
            $role = in_array($msg['role'] ?? '', ['model', 'assistant'], true) ? 'model' : 'user';
            $contents[] = ['role' => $role, 'parts' => [['text' => $msg['text'] ?? '']]];
        }
        $contents[] = ['role' => 'user', 'parts' => [['text' => $newMessage]]];

        return $this->callGemini($contents, $systemInstruction, false);
    }

    private function callGroq(array $messages, string $systemPrompt, string $model, bool $jsonMode, int $timeout = 60): string
    {
        $apiKey = config('site.api.groq_api_key');
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
            'https://api.groq.com/openai/v1/chat/completions',
            ['Content-Type: application/json', 'Authorization: Bearer '.trim($apiKey)],
            json_encode($body),
            $timeout
        );

        $data = json_decode($response, true);

        return $data['choices'][0]['message']['content'] ?? '';
    }

    private function callDeepSeek(array $messages, string $systemPrompt, string $model, bool $jsonMode, int $timeout = 90): string
    {
        $apiKey = config('site.api.deepseek_api_key');
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
            'https://api.deepseek.com/chat/completions',
            ['Content-Type: application/json', 'Authorization: Bearer '.trim($apiKey)],
            json_encode($body),
            $timeout
        );

        $data = json_decode($response, true);

        return $data['choices'][0]['message']['content'] ?? '';
    }

    private function callGemini(array $contents, string $systemInstruction, bool $jsonMode): string
    {
        $apiKey = config('site.api.gemini_api_key');
        $model = config('site.api.gemini_model');

        $body = [
            'systemInstruction' => ['parts' => [['text' => $systemInstruction]]],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.1,
            ],
        ];

        if ($jsonMode) {
            $body['generationConfig']['responseMimeType'] = 'application/json';
        }

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/'.$model.':generateContent?key='.urlencode(trim($apiKey));
        $response = $this->httpPost($url, ['Content-Type: application/json'], json_encode($body));
        $data = json_decode($response, true);

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }

    private function buildSolveSystemPrompt(string $mode): string
    {
        return 'You are a world-class, multi-disciplinary Scientific & Financial AI Solver and Tutoress.
Your task is to solve the given STEM or professional query according to the requested mode: "'.$mode.'".

The query may cover mathematics, physics, chemistry, biology, finance, and engineering.
Solve it step-by-step according to the mode:
- "step-by-step": Break down the problem logically with clear steps and intermediate equations.
- "conceptual": Focus on explaining formulas, definitions, theorems, and core principles.
- "interactive": Outline full solution steps and write follow-up practice questions.
- "graph": Emphasize mathematical curves, coordinate behavior, trends, and plots.

Use markdown tables and lists where helpful. Use LaTeX notation in formulas when appropriate.
If graphable, set graphable to true and provide JavaScript-compatible expressions in graphFunctions (e.g. "2*x + 3", "Math.sin(x)").

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
        if (! is_array($parsed)) {
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

        if ($response === false || $httpCode !== 200) {
            $detail = $curlError ?: '';
            if (is_string($response) && $response !== '') {
                $decoded = json_decode($response, true);
                if (is_array($decoded)) {
                    $detail = $decoded['error']['message'] ?? ($decoded['error']['code'] ?? $response);
                } else {
                    $detail = substr($response, 0, 300);
                }
            }

            throw new \RuntimeException(
                'API request failed'.($httpCode ? " (HTTP {$httpCode})" : '').($detail ? ": {$detail}" : '')
            );
        }

        return $response;
    }

    public function offlineSolve(string $problem, string $mode, ?string $image): array
    {
        $clean = trim($problem);

        if ($image) {
            return [
                'solvedProblem' => $clean ?: 'Visual Math Problem',
                'finalAnswer' => 'Try a clearer photo or type the problem manually',
                'steps' => [
                    ['title' => 'Visual Scanner', 'explanation' => 'We could not fully process this image. Try a well-lit photo with clear handwriting or printed text.', 'formula' => ''],
                    ['title' => 'Text Mode', 'explanation' => 'You can also type equations directly, for example: 2x^2 + 5x - 3 = 0', 'formula' => 'ax^2 + bx + c = 0'],
                ],
                'concepts' => [['name' => 'Visual Transcription', 'definition' => 'Clear photos help the scanner read math symbols accurately.']],
                'graphable' => false,
                'graphFunctions' => [],
                'followUpQuestions' => ['Solve 2x^2 + 5x - 3 = 0', 'What is the quadratic formula?'],
            ];
        }

        $normalized = strtolower(preg_replace('/\s+/', '', $clean));

        if (preg_match('/^([+-]?\d*(?:\.\d+)?)x\^2([+-]?\d*(?:\.\d+)?)x([+-]?\d*(?:\.\d+)?)(?:=0)?$/', $normalized, $m)) {
            $a = $m[1] === '' || $m[1] === '+' ? 1 : ($m[1] === '-' ? -1 : (float) $m[1]);
            $b = $m[2] === '' || $m[2] === '+' ? 1 : ($m[2] === '-' ? -1 : (float) $m[2]);
            $c = (float) ($m[3] ?: 0);

            if ($a != 0) {
                $disc = $b * $b - 4 * $a * $c;
                $steps = [
                    ['title' => 'Step 1: Extract coefficients', 'explanation' => "From ax² + bx + c = 0: a = {$a}, b = {$b}, c = {$c}", 'formula' => "a = {$a}, b = {$b}, c = {$c}"],
                    ['title' => 'Step 2: Compute discriminant', 'explanation' => 'D = b² - 4ac determines the nature of roots.', 'formula' => "D = ({$b})^2 - 4({$a})({$c}) = {$disc}"],
                ];

                if ($disc > 0) {
                    $x1 = round((-$b + sqrt($disc)) / (2 * $a), 4);
                    $x2 = round((-$b - sqrt($disc)) / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Apply quadratic formula', 'explanation' => 'Two real roots found.', 'formula' => 'x = (-b ± √D) / 2a'];
                    $answer = "x = {$x1}, x = {$x2}";
                } elseif ($disc == 0) {
                    $x = round(-$b / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Repeated root', 'explanation' => 'One repeated real root.', 'formula' => 'x = -b / 2a'];
                    $answer = "x = {$x}";
                } else {
                    $real = round(-$b / (2 * $a), 4);
                    $imag = round(sqrt(-$disc) / (2 * $a), 4);
                    $steps[] = ['title' => 'Step 3: Complex roots', 'explanation' => 'Discriminant is negative.', 'formula' => "x = {$real} ± {$imag}i"];
                    $answer = "x = {$real} + {$imag}i, x = {$real} - {$imag}i";
                }

                return [
                    'solvedProblem' => $clean,
                    'finalAnswer' => $answer,
                    'steps' => $steps,
                    'concepts' => [
                        ['name' => 'Quadratic Formula', 'definition' => 'Solutions of ax² + bx + c = 0.'],
                        ['name' => 'Discriminant', 'definition' => 'b² - 4ac indicates root type.'],
                    ],
                    'graphable' => true,
                    'graphFunctions' => ["{$a}*Math.pow(x,2) + ({$b}*x) + ({$c})"],
                    'followUpQuestions' => ['What is the vertex?', 'How do you factor this?', 'What are complex roots?'],
                ];
            }
        }

        if (preg_match('/^([+-]?\d*(?:\.\d+)?)x([+-]?\d*(?:\.\d+)?)=([+-]?\d*(?:\.\d+)?)$/', $normalized, $m)) {
            $a = $m[1] === '' || $m[1] === '+' ? 1 : ($m[1] === '-' ? -1 : (float) $m[1]);
            $b = (float) ($m[2] ?: 0);
            $c = (float) ($m[3] ?: 0);

            if ($a != 0) {
                $rest = $c - $b;
                $ans = $rest / $a;

                return [
                    'solvedProblem' => $clean,
                    'finalAnswer' => 'x = '.round($ans, 4),
                    'steps' => [
                        ['title' => 'Step 1: Simplify constants', 'explanation' => "Subtract {$b} from both sides.", 'formula' => "{$a}x = {$rest}"],
                        ['title' => 'Step 2: Isolate x', 'explanation' => "Divide by {$a}.", 'formula' => 'x = '.round($ans, 4)],
                    ],
                    'concepts' => [['name' => 'Linear Equations', 'definition' => 'First-degree equations with one unique solution.']],
                    'graphable' => true,
                    'graphFunctions' => ["{$a}*x + {$b} - {$c}"],
                    'followUpQuestions' => ['What is the slope?', 'How can we verify this root?'],
                ];
            }
        }

        return [
            'solvedProblem' => $clean ?: 'MathMind Workspace',
            'finalAnswer' => 'Try rephrasing or use a sample problem below',
            'steps' => [
                ['title' => 'Basic Patterns', 'explanation' => 'Simple linear and quadratic equations can be solved here. For other problems, try rephrasing or uploading a clearer photo.', 'formula' => '2x^2 + 5x - 3 = 0'],
            ],
            'concepts' => [['name' => 'AI Math Solver', 'definition' => 'Multi-engine step-by-step solving with graphs and tutoring.']],
            'graphable' => true,
            'graphFunctions' => ['Math.sin(x)', 'Math.cos(x)'],
            'followUpQuestions' => ['Solve 2x^2 + 5x - 3 = 0', 'Plot y = sin(x)'],
        ];
    }
}
