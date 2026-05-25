@php
    $steps = $solution['steps'] ?? [];
    $concepts = $solution['concepts'] ?? [];
    $followUps = $solution['followUpQuestions'] ?? [];
    $extracted = $solution['extractedText'] ?? null;
@endphp
<article
    id="ai-math-solver-static-output"
    class="ai-math-solver-static mt-8 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm"
    itemscope
    itemtype="https://schema.org/MathSolver"
    aria-live="polite"
>
    <header class="mb-6 border-b border-gray-100 pb-4">
        <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 mb-1">Step-by-step solution</p>
        <h2 class="text-2xl font-bold text-gray-900" itemprop="name">{{ $solution['solvedProblem'] ?? ($problem ?? 'Math Problem') }}</h2>
        @if(!empty($problem))
            <p class="text-sm text-gray-500 mt-1">Problem: <span itemprop="mathExpression">{{ $problem }}</span></p>
        @endif
        @if($extracted)
            <p class="text-sm text-gray-600 mt-2"><strong>Read from image:</strong> {{ $extracted }}</p>
        @endif
        @if(!empty($solution['extractedLatex']))
            <p class="formula-block text-center my-2">$${{ $solution['extractedLatex'] }}$$</p>
        @endif
    </header>

    <section class="mb-6" aria-labelledby="static-final-answer">
        <h3 id="static-final-answer" class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-2">Final answer</h3>
        <p class="text-xl font-mono font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-xl px-4 py-3" itemprop="text">
            {{ $solution['finalAnswer'] ?? '' }}
        </p>
    </section>

    @if(count($steps) > 0)
        <section class="mb-6" aria-labelledby="static-solution-steps">
            <h3 id="static-solution-steps" class="text-lg font-bold text-gray-900 mb-4">Solution steps</h3>
            <ol class="space-y-4 list-none m-0 p-0">
                @foreach($steps as $index => $step)
                    <li class="border border-gray-100 rounded-xl p-4" itemprop="step" itemscope itemtype="https://schema.org/HowToStep">
                        <meta itemprop="position" content="{{ $index + 1 }}">
                        <h4 class="font-semibold text-gray-900 text-sm" itemprop="name">{{ $step['title'] ?? ('Step '.($index + 1)) }}</h4>
                        @if(!empty($step['explanation']))
                            <p class="text-gray-600 text-sm mt-2 leading-relaxed" itemprop="text">{{ $step['explanation'] }}</p>
                        @endif
                        @if(!empty($step['formula']))
                            <p class="mt-2 font-mono text-sm bg-gray-50 rounded-lg px-3 py-2 text-gray-800">{{ $step['formula'] }}</p>
                        @endif
                    </li>
                @endforeach
            </ol>
        </section>
    @endif

    @if(count($concepts) > 0)
        <section class="mb-6" aria-labelledby="static-concepts">
            <h3 id="static-concepts" class="text-lg font-bold text-gray-900 mb-4">Key concepts</h3>
            <dl class="space-y-3">
                @foreach($concepts as $concept)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <dt class="font-semibold text-gray-900 text-sm">{{ $concept['name'] ?? '' }}</dt>
                        <dd class="text-gray-600 text-sm mt-1">{{ $concept['definition'] ?? '' }}</dd>
                    </div>
                @endforeach
            </dl>
        </section>
    @endif

    @if(!empty($solution['synthesis']['comparisonMarkdown']))
        <section class="mb-6" aria-labelledby="static-consensus">
            <h3 id="static-consensus" class="text-lg font-bold text-gray-900 mb-3">Verified consensus</h3>
            <div class="prose prose-sm max-w-none text-gray-700">{!! \Illuminate\Support\Str::markdown($solution['synthesis']['comparisonMarkdown']) !!}</div>
        </section>
    @endif

    @if(count($followUps) > 0)
        <section aria-labelledby="static-followups">
            <h3 id="static-followups" class="text-lg font-bold text-gray-900 mb-3">Practice questions</h3>
            <ul class="list-disc list-inside text-gray-600 space-y-1 text-sm">
                @foreach($followUps as $question)
                    <li>{{ $question }}</li>
                @endforeach
            </ul>
        </section>
    @endif
</article>
