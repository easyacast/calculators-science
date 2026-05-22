@extends('layouts.app')

@section('title', 'AI Math Solver - Step by Step Solutions with Graphs')
@section('meta_description', 'Solve any math problem instantly with our free AI Math Solver. Get step-by-step solutions, interactive graphs, and AI tutoring for algebra, calculus, trigonometry, and more.')
@section('canonical', config('site.url') . '/math/ai-math-solver')
@section('meta_keywords', 'ai math solver, math problem solver, step by step math, equation solver, algebra solver, calculus solver, math graph, math tutor')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "MathSolver",
    "name": "AI Math Solver",
    "url": "{{ config('site.url') }}/math/ai-math-solver",
    "usageInfo": "{{ config('site.url') }}/terms-of-service",
    "mathExpression": [
        "2x+3=7",
        "x^2-5x+6=0",
        "d/dx(x^3+2x)",
        "∫sin(x)dx"
    ],
    "description": "AI-powered math solver with step-by-step solutions, interactive graphing, and tutoring.",
    "potentialAction": [{
        "@type": "SolveMathAction",
        "target": "{{ config('site.url') }}/math/ai-math-solver?q={math_expression_string}",
        "mathExpression-input": "required name=math_expression_string",
        "eduQuestionType": [
            "Algebra",
            "Arithmetic",
            "Calculus",
            "Geometry",
            "Statistics",
            "Trigonometry"
        ]
    }]
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "AI Math Solver",
    "applicationCategory": "EducationalApplication",
    "operatingSystem": "Web",
    "offers": { "@type": "Offer", "price": "0", "priceCurrency": "USD" },
    "description": "AI-powered math solver with step-by-step solutions, interactive graphing, and tutoring."
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "How does the AI Math Solver work?",
            "acceptedAnswer": { "@type": "Answer", "text": "Type or upload a math problem. The AI analyzes the equation, provides a step-by-step solution, generates interactive graphs when applicable, and offers an AI tutor for follow-up questions." }
        },
        {
            "@type": "Question",
            "name": "What types of math problems can it solve?",
            "acceptedAnswer": { "@type": "Answer", "text": "The solver handles algebra, calculus, trigonometry, linear algebra, statistics, geometry, and more. It can solve equations, find derivatives, compute integrals, plot functions, and explain concepts." }
        },
        {
            "@type": "Question",
            "name": "Is the AI Math Solver free?",
            "acceptedAnswer": { "@type": "Answer", "text": "Yes, the AI Math Solver is completely free to use with no sign-up required." }
        }
    ]
}
</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumbs --}}
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center gap-2 text-sm text-gray-500">
            <li><a href="{{ config('site.url') }}" class="hover:text-indigo-600">Home</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li><a href="{{ config('site.url') }}/math" class="hover:text-indigo-600">Mathematics</a></li>
            <li><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></li>
            <li class="text-gray-900 font-medium">AI Math Solver</li>
        </ol>
    </nav>

    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-2">AI Math Solver</h1>
    <p class="text-lg text-gray-600 mb-8">Type any math problem or upload an image. Get step-by-step solutions, interactive graphs, and AI tutoring instantly.</p>

    {{-- Main Solver Application (Alpine.js) --}}
    <div x-data="mathSolver()" class="space-y-6">

        {{-- Input Section --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            {{-- Input Tabs --}}
            <div class="flex border-b border-gray-200">
                <button @click="inputTab = 'text'" :class="inputTab === 'text' ? 'border-b-2 border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-3 px-4 text-sm font-medium transition-colors">
                    Type Problem
                </button>
                <button @click="inputTab = 'photo'" :class="inputTab === 'photo' ? 'border-b-2 border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-3 px-4 text-sm font-medium transition-colors">
                    Upload Photo
                </button>
            </div>

            <div class="p-5">
                {{-- Text Input --}}
                <div x-show="inputTab === 'text'">
                    <textarea
                        x-ref="problemInput"
                        x-model="problem"
                        @keydown.ctrl.enter="solve()"
                        placeholder="Type your math problem... (e.g., Solve 2x^2 + 5x - 3 = 0)"
                        class="w-full h-28 p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm resize-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    ></textarea>

                    {{-- Quick Math Keys --}}
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        <template x-for="key in mathKeys" :key="key.label">
                            <button @click="insertSymbol(key.value)" class="px-2.5 py-1.5 bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg text-sm font-mono transition-colors" x-text="key.label"></button>
                        </template>
                    </div>
                </div>

                {{-- Photo Input --}}
                <div x-show="inputTab === 'photo'" x-cloak>
                    <div x-show="!image" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center"
                         @dragover.prevent @drop.prevent="handleDrop($event)">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-gray-500 text-sm mb-3">Drag and drop a math problem image, or</p>
                        <button @click="triggerFileInput()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 transition-colors">Choose File</button>
                    </div>
                    <div x-show="image" x-cloak class="relative">
                        <img :src="image" class="max-h-48 rounded-xl mx-auto border border-gray-200">
                        <button @click="image = null" class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full hover:bg-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Mode Selector & Solve Button --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mt-4">
                    <select x-model="mode" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="step-by-step">Step-by-Step</option>
                        <option value="conceptual">Conceptual</option>
                        <option value="graph">Graph</option>
                    </select>
                    <button @click="solve()" :disabled="loading" class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span x-text="loading ? loadingText : 'Solve'"></span>
                    </button>
                </div>

                {{-- Preset Examples --}}
                <div class="mt-4">
                    <p class="text-xs text-gray-400 mb-2">Try an example:</p>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="preset in presets" :key="preset.title">
                            <button @click="problem = preset.problem; mode = preset.mode; solve()" class="px-3 py-1.5 bg-gray-100 hover:bg-indigo-50 text-gray-600 hover:text-indigo-700 rounded-lg text-xs transition-colors">
                                <span x-text="preset.title"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- Error Display --}}
        <div x-show="error" x-cloak class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-700 text-sm" x-text="error"></div>

        {{-- Results Section --}}
        <div x-show="response" x-cloak>
            {{-- Tabs --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="flex border-b border-gray-200 overflow-x-auto">
                    <button @click="activeTab = 'solution'" :class="activeTab === 'solution' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500'" class="px-5 py-3 text-sm font-medium whitespace-nowrap">Solution</button>
                    <button @click="activeTab = 'graph'" :class="activeTab === 'graph' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500'" class="px-5 py-3 text-sm font-medium whitespace-nowrap" x-show="response && response.graphable">Graph</button>
                    <button @click="activeTab = 'concepts'" :class="activeTab === 'concepts' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500'" class="px-5 py-3 text-sm font-medium whitespace-nowrap">Theorems</button>
                    <button @click="activeTab = 'chat'" :class="activeTab === 'chat' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-500'" class="px-5 py-3 text-sm font-medium whitespace-nowrap">AI Tutor</button>
                </div>

                {{-- Solution Tab --}}
                <div x-show="activeTab === 'solution'" class="p-6">
                    {{-- Final Answer --}}
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-5 mb-6 border border-indigo-100">
                        <div class="text-xs font-medium text-indigo-500 uppercase tracking-wider mb-1">Final Answer</div>
                        <div class="text-xl font-bold text-gray-900" x-text="response?.finalAnswer"></div>
                    </div>

                    {{-- Steps --}}
                    <div class="space-y-4">
                        <template x-for="(step, i) in response?.steps || []" :key="i">
                            <div class="border border-gray-100 rounded-xl p-4 hover:border-indigo-200 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" x-text="i + 1"></div>
                                    <div class="min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm" x-text="step.title"></h4>
                                        <p class="text-gray-600 text-sm mt-1 leading-relaxed" x-text="step.explanation"></p>
                                        <div x-show="step.formula" class="mt-2 bg-gray-50 rounded-lg px-3 py-2 font-mono text-sm text-gray-800 overflow-x-auto" x-text="step.formula"></div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Follow-up Questions --}}
                    <div x-show="response?.followUpQuestions?.length > 0" class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Related Questions</h4>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="q in response?.followUpQuestions || []" :key="q">
                                <button @click="problem = q; solve()" class="px-3 py-1.5 bg-gray-100 hover:bg-indigo-50 text-gray-600 hover:text-indigo-700 rounded-lg text-xs transition-colors" x-text="q"></button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Graph Tab --}}
                <div x-show="activeTab === 'graph'" x-cloak class="p-6">
                    <div x-show="response && response.graphable && response.graphFunctions" x-data="mathGraph()" x-init="$watch('$root.response', val => { if(val && val.graphFunctions) init(val.graphFunctions) })">
                        <div class="flex items-center gap-3 mb-4">
                            <button @click="zoomIn()" class="p-2 bg-gray-100 hover:bg-indigo-100 rounded-lg text-gray-600 hover:text-indigo-600 transition-colors" title="Zoom In">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </button>
                            <button @click="zoomOut()" class="p-2 bg-gray-100 hover:bg-indigo-100 rounded-lg text-gray-600 hover:text-indigo-600 transition-colors" title="Zoom Out">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
                            </button>
                            <button @click="resetView()" class="p-2 bg-gray-100 hover:bg-indigo-100 rounded-lg text-gray-600 hover:text-indigo-600 transition-colors" title="Reset View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            </button>
                        </div>
                        <div x-ref="graphContainer" class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden" style="height: 400px;"
                             @mousemove="handleMouseMove($event)" @mousedown="startPan($event)" @mouseup="stopPan()" @mouseleave="stopPan()" @wheel.prevent="handleWheel($event)">
                            <svg :width="width" :height="height" class="w-full h-full">
                                {{-- Grid Lines --}}
                                <template x-for="tick in gridTicksX" :key="'gx'+tick.val">
                                    <line :x1="tick.pos" y1="0" :x2="tick.pos" :y2="height" stroke="#e5e7eb" stroke-width="1"/>
                                </template>
                                <template x-for="tick in gridTicksY" :key="'gy'+tick.val">
                                    <line x1="0" :y1="tick.pos" :x2="width" :y2="tick.pos" stroke="#e5e7eb" stroke-width="1"/>
                                </template>

                                {{-- Axes --}}
                                <line x1="0" :y1="originY" :x2="width" :y2="originY" stroke="#9ca3af" stroke-width="1.5"/>
                                <line :x1="originX" y1="0" :x2="originX" :y2="height" stroke="#9ca3af" stroke-width="1.5"/>

                                {{-- Axis Labels --}}
                                <template x-for="tick in gridTicksX" :key="'lx'+tick.val">
                                    <text :x="tick.pos" :y="originY + 16" text-anchor="middle" fill="#6b7280" font-size="10" x-text="tick.label"></text>
                                </template>
                                <template x-for="tick in gridTicksY" :key="'ly'+tick.val">
                                    <text :x="originX - 8" :y="tick.pos + 4" text-anchor="end" fill="#6b7280" font-size="10" x-text="tick.label"></text>
                                </template>

                                {{-- Function Curves --}}
                                <template x-for="(path, idx) in paths" :key="'p'+idx">
                                    <path :d="path" fill="none" :stroke="colors[idx % colors.length]" stroke-width="2.5" stroke-linecap="round"/>
                                </template>

                                {{-- Hover Crosshair --}}
                                <template x-if="hoverCoord">
                                    <g>
                                        <line :x1="toScreenX(hoverCoord.x)" y1="0" :x2="toScreenX(hoverCoord.x)" :y2="height" stroke="#818cf8" stroke-width="1" stroke-dasharray="4"/>
                                        <line x1="0" :y1="toScreenY(hoverCoord.y)" :x2="width" :y2="toScreenY(hoverCoord.y)" stroke="#818cf8" stroke-width="1" stroke-dasharray="4"/>
                                        <circle :cx="toScreenX(hoverCoord.x)" :cy="toScreenY(hoverCoord.y)" r="4" fill="#4f46e5"/>
                                    </g>
                                </template>
                            </svg>
                        </div>
                        {{-- Hover Coordinates --}}
                        <div x-show="hoverCoord" x-cloak class="mt-2 text-xs text-gray-500 text-center">
                            x = <span x-text="hoverCoord ? hoverCoord.x.toFixed(2) : ''"></span>, y = <span x-text="hoverCoord ? hoverCoord.y.toFixed(2) : ''"></span>
                        </div>
                    </div>
                    <div x-show="!response?.graphable" class="text-center py-12 text-gray-500">
                        <p>This equation does not have a graphable function.</p>
                    </div>
                </div>

                {{-- Concepts/Theorems Tab --}}
                <div x-show="activeTab === 'concepts'" x-cloak class="p-6">
                    <div class="space-y-3">
                        <template x-for="(concept, i) in response?.concepts || []" :key="i">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 text-sm" x-text="concept.name"></h4>
                                <p class="text-gray-600 text-sm mt-1" x-text="concept.definition"></p>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- AI Tutor Chat Tab --}}
                <div x-show="activeTab === 'chat'" x-cloak class="flex flex-col" style="height: 500px;">
                    <div class="flex-1 overflow-y-auto p-4 space-y-3" x-ref="chatScroll">
                        <template x-for="(msg, i) in chatMessages" :key="i">
                            <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                                <div :class="msg.role === 'user' ? 'bg-gray-900 text-white rounded-br-none' : 'bg-gray-100 text-gray-800 rounded-bl-none'" class="max-w-[80%] rounded-2xl px-4 py-3 text-sm leading-relaxed" x-text="msg.text"></div>
                            </div>
                        </template>
                        <div x-show="chatLoading" x-cloak class="flex justify-start">
                            <div class="bg-gray-100 rounded-2xl rounded-bl-none px-4 py-3 text-sm text-gray-500">Thinking...</div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 p-4">
                        <form @submit.prevent="sendChat()" class="flex gap-2">
                            <input x-model="chatInput" type="text" placeholder="Ask a follow-up question..."
                                class="flex-1 px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <button type="submit" :disabled="chatLoading" class="p-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 disabled:opacity-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- History --}}
        <div x-show="history.length > 0" x-cloak class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-900">Recent Problems</h3>
                <button @click="clearHistory()" class="text-xs text-red-500 hover:text-red-700">Clear All</button>
            </div>
            <div class="space-y-2">
                <template x-for="(item, i) in history.slice(0, 5)" :key="item.id">
                    <button @click="problem = item.problem; mode = item.mode; response = item.response; activeTab = 'solution'" class="w-full text-left px-3 py-2 bg-gray-50 hover:bg-indigo-50 rounded-lg text-sm text-gray-700 hover:text-indigo-700 transition-colors truncate">
                        <span x-text="item.problem"></span>
                        <span class="text-xs text-gray-400 ml-2" x-text="item.timestamp"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    @include('components.adsense', ['slot' => 'tool-below'])

    {{-- Educational Content (SSR for SEO) --}}
    <div class="mt-16 max-w-4xl">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">What is the AI Math Solver?</h2>
        <p class="text-gray-600 leading-relaxed mb-6">
            The AI Math Solver is a powerful tool that helps you solve mathematical problems of all kinds. Whether you are working through algebra homework, studying calculus for an exam, or exploring trigonometric identities, this tool gives you clear, step-by-step solutions. Think of it as having a patient tutor sitting right next to you, ready to walk you through every problem at your own pace.
        </p>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">How Does It Work?</h2>
        <p class="text-gray-600 leading-relaxed mb-4">Using the solver is simple and straightforward:</p>
        <ol class="list-decimal list-inside text-gray-600 space-y-2 mb-6">
            <li><strong>Enter your problem</strong> by typing it in the text box, or upload a photo of handwritten equations.</li>
            <li><strong>Choose a solving mode</strong>: Step-by-Step for detailed breakdowns, Conceptual for understanding the underlying ideas, or Graph for visual representations.</li>
            <li><strong>Click "Solve"</strong> and the AI analyzes your problem, identifies the type of equation, and generates a complete solution with every step explained.</li>
            <li><strong>Explore the results</strong> through tabs: view the solution steps, see the graph, learn related theorems, or chat with the AI tutor for follow-up questions.</li>
        </ol>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Supported Problem Types</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-800 mb-2">Algebra</h3>
                <p class="text-sm text-gray-600">Linear equations, quadratic equations, systems of equations, polynomial factoring, inequalities.</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-800 mb-2">Calculus</h3>
                <p class="text-sm text-gray-600">Derivatives, integrals, limits, series and sequences, differential equations.</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-800 mb-2">Trigonometry</h3>
                <p class="text-sm text-gray-600">Trigonometric identities, equations, inverse functions, law of sines and cosines.</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-800 mb-2">Linear Algebra</h3>
                <p class="text-sm text-gray-600">Matrix operations, determinants, eigenvalues, vector spaces.</p>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Example: Solving a Quadratic Equation</h2>
        <p class="text-gray-600 leading-relaxed mb-3">
            Let us walk through solving $2x^2 + 5x - 3 = 0$ using the quadratic formula:
        </p>
        <div class="bg-gray-50 rounded-lg p-4 mb-3">
            <p class="formula-block text-center">$$x = \frac{-b \pm \sqrt{b^2 - 4ac}}{2a}$$</p>
        </div>
        <p class="text-gray-600 leading-relaxed mb-2">Where $a = 2$, $b = 5$, and $c = -3$:</p>
        <ol class="list-decimal list-inside text-gray-600 space-y-1 mb-6">
            <li>Calculate the discriminant: $D = 5^2 - 4(2)(-3) = 25 + 24 = 49$</li>
            <li>Since $D > 0$, there are two real roots.</li>
            <li>$x_1 = \frac{-5 + 7}{4} = 0.5$ and $x_2 = \frac{-5 - 7}{4} = -3$</li>
        </ol>

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
        <div class="space-y-4 mb-8">
            <details class="bg-gray-50 rounded-lg p-4 group">
                <summary class="font-semibold text-gray-800 cursor-pointer">How does the AI Math Solver work?</summary>
                <p class="text-sm text-gray-600 mt-2">Type or upload a math problem. The AI analyzes the equation, provides a step-by-step solution, generates interactive graphs when applicable, and offers an AI tutor for follow-up questions.</p>
            </details>
            <details class="bg-gray-50 rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">What types of math problems can it solve?</summary>
                <p class="text-sm text-gray-600 mt-2">The solver handles algebra, calculus, trigonometry, linear algebra, statistics, geometry, and more. It can solve equations, find derivatives, compute integrals, plot functions, and explain concepts.</p>
            </details>
            <details class="bg-gray-50 rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">Is the AI Math Solver free?</summary>
                <p class="text-sm text-gray-600 mt-2">Yes, the AI Math Solver is completely free to use with no sign-up required.</p>
            </details>
            <details class="bg-gray-50 rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">Can I upload a photo of my math problem?</summary>
                <p class="text-sm text-gray-600 mt-2">Yes! Switch to the "Upload Photo" tab, then drag and drop an image or click "Choose File". The AI will read the handwritten or printed math from the image.</p>
            </details>
        </div>

        {{-- Internal Links --}}
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Related Tools</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ config('site.url') }}/math/quadratic-equation-calculator" class="block bg-white border border-gray-200 hover:border-indigo-300 rounded-lg p-4 transition-colors">
                <h3 class="font-semibold text-gray-900 text-sm">Quadratic Equation Calculator</h3>
                <p class="text-xs text-gray-500 mt-1">Dedicated calculator for quadratic equations with graphing.</p>
            </a>
            <a href="{{ config('site.url') }}/math/percentage-calculator" class="block bg-white border border-gray-200 hover:border-indigo-300 rounded-lg p-4 transition-colors">
                <h3 class="font-semibold text-gray-900 text-sm">Percentage Calculator</h3>
                <p class="text-xs text-gray-500 mt-1">Quick percentage calculations with multiple modes.</p>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function mathSolver() {
    return {
        problem: '',
        mode: 'step-by-step',
        loading: false,
        error: null,
        response: null,
        activeTab: 'solution',
        inputTab: 'text',
        image: null,
        loadingText: 'Solving...',
        chatMessages: [{ role: 'model', text: 'Hi! Submit a math problem and I will help you understand the solution step by step.', timestamp: '' }],
        chatInput: '',
        chatLoading: false,
        history: JSON.parse(localStorage.getItem('ai_math_history') || '[]'),

        mathKeys: [
            { label: 'x', value: 'x' }, { label: 'y', value: 'y' },
            { label: '\u00b2', value: '^2' }, { label: '\u00b3', value: '^3' },
            { label: '^', value: '^' }, { label: '\u221a', value: 'sqrt(' },
            { label: '\u03c0', value: 'pi' }, { label: '+', value: ' + ' },
            { label: '-', value: ' - ' }, { label: '*', value: ' * ' },
            { label: '/', value: ' / ' }, { label: '=', value: ' = ' },
            { label: 'sin', value: 'sin(' }, { label: 'cos', value: 'cos(' },
            { label: '(', value: '(' }, { label: ')', value: ')' },
        ],

        presets: [
            { category: 'Algebra', title: 'Quadratic Equation', problem: 'Solve 2x^2 + 5x - 3 = 0', mode: 'step-by-step' },
            { category: 'Calculus', title: 'Derivative', problem: 'Find the derivative of f(x) = x^3 - 3*x + 2', mode: 'step-by-step' },
            { category: 'Trigonometry', title: 'Graph Plot', problem: 'Plot y = 2 * Math.sin(2 * x)', mode: 'graph' },
            { category: 'Linear Algebra', title: 'Linear System', problem: 'Solve system: 3x + 2y = 12 and x - y = 1', mode: 'conceptual' },
        ],

        insertSymbol(val) {
            const ta = this.$refs.problemInput;
            if (ta) {
                const start = ta.selectionStart;
                const end = ta.selectionEnd;
                this.problem = this.problem.substring(0, start) + val + this.problem.substring(end);
                this.$nextTick(() => {
                    ta.focus();
                    ta.setSelectionRange(start + val.length, start + val.length);
                });
            } else {
                this.problem += val;
            }
        },

        handleDrop(e) {
            const files = e.dataTransfer.files;
            if (files && files.length > 0) this.processFile(files[0]);
        },

        triggerFileInput() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = (e) => {
                if (e.target.files && e.target.files.length > 0) this.processFile(e.target.files[0]);
            };
            input.click();
        },

        processFile(file) {
            if (!file.type.startsWith('image/')) { this.error = 'Please select a valid image file.'; return; }
            const reader = new FileReader();
            reader.onload = () => { this.image = reader.result; };
            reader.readAsDataURL(file);
        },

        async solve() {
            const target = this.problem.trim();
            if (!target && !this.image) { this.error = 'Please type a question or upload an image.'; return; }

            this.loading = true;
            this.error = null;
            this.activeTab = 'solution';

            const texts = ['Analyzing equation...', 'Extracting coefficients...', 'Applying formulas...', 'Structuring solution...', 'Almost done...'];
            let ti = 0;
            const interval = setInterval(() => { this.loadingText = texts[ti % texts.length]; ti++; }, 1500);

            try {
                const res = await fetch('/api/solve', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ problem: target, mode: this.mode, image: this.image }),
                });
                if (!res.ok) throw new Error('Server error');
                this.response = await res.json();

                // Save to history
                const item = { id: Date.now().toString(), problem: target || 'Uploaded Image', mode: this.mode, timestamp: new Date().toLocaleString(), response: this.response };
                this.history = [item, ...this.history].slice(0, 10);
                localStorage.setItem('ai_math_history', JSON.stringify(this.history));

                // Reset tutor chat
                this.chatMessages = [{ role: 'model', text: `I have reviewed your problem: "${this.response.solvedProblem}". Ask me anything about the solution!`, timestamp: '' }];

                if (this.response.graphable && this.mode === 'graph') this.activeTab = 'graph';
            } catch (err) {
                this.error = 'Failed to solve the problem. Please try again.';
            } finally {
                clearInterval(interval);
                this.loading = false;
                this.loadingText = 'Solving...';
            }
        },

        async sendChat() {
            if (!this.chatInput.trim() || this.chatLoading) return;
            const text = this.chatInput.trim();
            this.chatMessages.push({ role: 'user', text, timestamp: '' });
            this.chatInput = '';
            this.chatLoading = true;

            this.$nextTick(() => { this.$refs.chatScroll?.scrollTo({ top: this.$refs.chatScroll.scrollHeight, behavior: 'smooth' }); });

            try {
                const res = await fetch('/api/chat', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                    body: JSON.stringify({ problemContext: this.response, chatHistory: this.chatMessages, newMessage: text }),
                });
                const data = await res.json();
                this.chatMessages.push({ role: 'model', text: data.text || 'I could not generate a response.', timestamp: '' });
            } catch {
                this.chatMessages.push({ role: 'model', text: 'Connection error. Please try again.', timestamp: '' });
            } finally {
                this.chatLoading = false;
                this.$nextTick(() => { this.$refs.chatScroll?.scrollTo({ top: this.$refs.chatScroll.scrollHeight, behavior: 'smooth' }); });
            }
        },

        clearHistory() {
            this.history = [];
            localStorage.removeItem('ai_math_history');
        },
    };
}

function mathGraph() {
    return {
        functions: [],
        zoom: 1,
        offsetX: 0,
        offsetY: 0,
        width: 800,
        height: 400,
        hoverCoord: null,
        panning: false,
        panStart: { x: 0, y: 0 },
        colors: ['#4f46e5', '#dc2626', '#059669', '#d97706', '#7c3aed'],

        get originX() { return this.width / 2 + this.offsetX; },
        get originY() { return this.height / 2 + this.offsetY; },
        get scaleX() { return (this.width / 20) * this.zoom; },
        get scaleY() { return (this.height / 20) * this.zoom; },

        get gridTicksX() {
            const ticks = [];
            let step = Math.max(1, Math.round(2 / this.zoom));
            for (let mx = Math.ceil(this.toMathX(0) / step) * step; mx <= this.toMathX(this.width); mx += step) {
                if (mx === 0) continue;
                ticks.push({ val: mx, pos: this.toScreenX(mx), label: String(mx) });
            }
            return ticks;
        },
        get gridTicksY() {
            const ticks = [];
            let step = Math.max(1, Math.round(2 / this.zoom));
            for (let my = Math.ceil(this.toMathY(this.height) / step) * step; my <= this.toMathY(0); my += step) {
                if (my === 0) continue;
                ticks.push({ val: my, pos: this.toScreenY(my), label: String(my) });
            }
            return ticks;
        },

        get paths() {
            const result = [];
            const stepSize = 0.05 / this.zoom;
            const xMin = this.toMathX(0);
            const xMax = this.toMathX(this.width);

            for (const expr of this.functions) {
                let d = '';
                let drawing = false;
                for (let mx = xMin; mx <= xMax; mx += stepSize) {
                    const my = this.evalFunc(expr, mx);
                    const sx = this.toScreenX(mx);
                    const sy = this.toScreenY(my);
                    if (!isNaN(my) && isFinite(my) && sy >= -this.height && sy <= this.height * 2) {
                        d += drawing ? ` L ${sx} ${sy}` : `M ${sx} ${sy}`;
                        drawing = true;
                    } else {
                        drawing = false;
                    }
                }
                result.push(d);
            }
            return result;
        },

        toScreenX(mx) { return this.originX + mx * this.scaleX; },
        toScreenY(my) { return this.originY - my * this.scaleY; },
        toMathX(sx) { return (sx - this.originX) / this.scaleX; },
        toMathY(sy) { return (this.originY - sy) / this.scaleY; },

        evalFunc(expr, x) {
            try {
                let s = expr.replace(/\bsin\b/gi, 'Math.sin').replace(/\bcos\b/gi, 'Math.cos').replace(/\btan\b/gi, 'Math.tan')
                    .replace(/\babs\b/gi, 'Math.abs').replace(/\bsqrt\b/gi, 'Math.sqrt').replace(/\bpi\b/gi, 'Math.PI')
                    .replace(/\be\b/gi, 'Math.E').replace(/(\d)x/g, '$1*x').replace(/\^/g, '**');
                const fn = new Function('x', `try { return ${s}; } catch { return NaN; }`);
                const r = fn(x);
                return typeof r === 'number' && !isNaN(r) ? r : NaN;
            } catch { return NaN; }
        },

        init(fns) {
            this.functions = (fns || []).filter(f => f && f.trim());
            const container = this.$refs.graphContainer;
            if (container) {
                this.width = container.clientWidth;
                this.height = container.clientHeight;
            }
        },

        zoomIn() { this.zoom = Math.min(this.zoom * 1.3, 20); },
        zoomOut() { this.zoom = Math.max(this.zoom / 1.3, 0.1); },
        resetView() { this.zoom = 1; this.offsetX = 0; this.offsetY = 0; },

        handleMouseMove(e) {
            const rect = this.$refs.graphContainer.getBoundingClientRect();
            const sx = e.clientX - rect.left;
            const sy = e.clientY - rect.top;
            if (this.panning) {
                this.offsetX += e.movementX;
                this.offsetY += e.movementY;
            }
            const mx = this.toMathX(sx);
            const my = this.functions.length > 0 ? this.evalFunc(this.functions[0], mx) : this.toMathY(sy);
            if (!isNaN(my) && isFinite(my)) {
                this.hoverCoord = { x: mx, y: my };
            }
        },
        startPan(e) { this.panning = true; },
        stopPan() { this.panning = false; },
        handleWheel(e) {
            if (e.deltaY < 0) this.zoomIn();
            else this.zoomOut();
        },
    };
}
</script>
@endsection
