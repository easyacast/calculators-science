@php
    $solveUrl = config('site.url') . '/math/ai-math-solver';
@endphp

<div
    x-data="aiMathSolverWorkspace(@js([
        'query' => $solverQuery ?? '',
        'mode' => $solverMode ?? 'step-by-step',
        'initialResponse' => $solution ?? null,
        'solveUrl' => $solveUrl,
    ]))"
    class="space-y-6 font-sans text-slate-900"
    id="ai-math-solver-workspace"
>
    <main class="grid grid-cols-1 lg:grid-cols-12 gap-6" id="workspace-grid">

        {{-- LEFT PANEL --}}
        <div class="lg:col-span-5 flex flex-col gap-6" id="left-workspace-panel">

            {{-- Problem Input --}}
            <section class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col gap-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Problem Input</span>
                    <div class="flex bg-slate-100 p-1 rounded-xl">
                        <button type="button" @click="inputTab = 'text'; stopCamera()"
                            :class="inputTab === 'text' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                            class="px-3 py-1 text-xs font-bold rounded-lg transition-all">Text Query</button>
                        <button type="button" @click="inputTab = 'photo'"
                            :class="inputTab === 'photo' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                            class="px-3 py-1 text-xs font-bold rounded-lg transition-all flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Snap / Upload Photo
                        </button>
                    </div>
                </div>

                {{-- Text input --}}
                <div x-show="inputTab === 'text'">
                    <div class="bg-slate-50 rounded-2xl p-4 border border-dashed border-slate-300">
                        <textarea x-ref="problemInput" x-model="problem" rows="4"
                            placeholder="Type an equation or ask a math question, e.g., Solve 2x^2 + 5x - 3 = 0"
                            class="w-full min-h-[100px] bg-transparent text-sm leading-relaxed text-slate-800 outline-none resize-none placeholder-slate-400 font-mono"
                            id="equation-input-textarea"></textarea>
                    </div>
                </div>

                {{-- Photo input --}}
                <div x-show="inputTab === 'photo'" x-cloak class="space-y-4">
                    <template x-if="imagePreview">
                        <div class="relative group border border-slate-200 rounded-2xl overflow-hidden bg-slate-900 aspect-video flex items-center justify-center">
                            <img :src="imagePreview" alt="Captured equation" class="max-h-full max-w-full object-contain">
                            <button type="button" @click="clearImage()" class="absolute top-3 right-3 p-1.5 bg-slate-900/60 hover:bg-slate-950/80 rounded-lg text-white border border-white/10">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                    <template x-if="!imagePreview && isCameraActive">
                        <div class="relative border border-slate-300 rounded-2xl overflow-hidden aspect-video bg-black">
                            <video x-ref="cameraVideo" autoplay playsinline class="absolute inset-0 w-full h-full object-cover"></video>
                            <div class="camera-scan-line"></div>
                            <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-slate-950/80 to-transparent flex items-center justify-between z-10">
                                <button type="button" @click="stopCamera()" class="px-3 py-1.5 bg-slate-800 text-xs text-white font-semibold rounded-lg">Cancel</button>
                                <button type="button" @click="capturePhoto()" class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-slate-800/40">
                                    <div class="w-5 h-5 bg-rose-600 rounded-full"></div>
                                </button>
                                <div class="w-12"></div>
                            </div>
                        </div>
                    </template>
                    <template x-if="!imagePreview && !isCameraActive">
                        <div @dragover.prevent @drop="handleDrop($event)"
                            class="border-2 border-dashed border-slate-200 hover:border-indigo-400 rounded-2xl p-6 flex flex-col items-center text-center bg-slate-50/50 hover:bg-slate-50 transition-all">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            </div>
                            <p class="text-xs font-bold text-slate-800">Drag & drop math picture here</p>
                            <p class="text-[10px] text-slate-400 mt-1">Or browse folder or camera</p>
                            <div class="flex gap-2.5 mt-4">
                                <button type="button" @click="triggerFileInput()" class="px-3 py-1.5 bg-white text-slate-700 font-bold text-xs rounded-xl border border-slate-200 shadow-sm">Browse Folder</button>
                                <button type="button" @click="startCamera()" class="px-3 py-1.5 bg-indigo-600 text-white font-bold text-xs rounded-xl shadow-sm flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/></svg>
                                    Camera Snap
                                </button>
                            </div>
                            <input x-ref="fileInput" type="file" accept="image/*" class="hidden" @change="handleFile($event)">
                        </div>
                    </template>
                    <div class="bg-slate-50 rounded-2xl p-3 border border-slate-200">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide block mb-1">Optional Instructions</span>
                        <textarea x-model="problem" rows="2" placeholder="E.g., Solve for y, or calculate the limit."
                            class="w-full min-h-[50px] bg-transparent text-xs text-slate-800 outline-none resize-none placeholder-slate-400 font-mono"></textarea>
                    </div>
                </div>

                {{-- Scientific Keyboard --}}
                <div x-show="inputTab === 'text'" class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Insert Tools</span>
                        <button type="button" @click="showScientificKeyboard = !showScientificKeyboard"
                            :class="showScientificKeyboard ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-indigo-50 text-indigo-700 border-indigo-200'"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-xl border shadow-sm transition-all"
                            id="toggle-scientific-keyboard">
                            <span>🔬</span>
                            <span x-text="showScientificKeyboard ? 'Close Scientific Keyboard' : 'Scientific Keyboard'"></span>
                        </button>
                    </div>

                    {{-- Full Scientific Keyboard --}}
                    <div x-show="showScientificKeyboard" x-cloak
                        class="bg-slate-50 border border-slate-200 rounded-2xl p-4 shadow-inner flex flex-col gap-4"
                        id="scientific-keyboard-widget">
                        <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-extrabold text-slate-700 tracking-wider uppercase">Scientific Dashboard</span>
                                <span class="text-[10px] bg-indigo-50 text-indigo-700 font-semibold px-2 py-0.5 rounded-full border border-indigo-100">Smart Insert</span>
                            </div>
                            <div class="relative w-full sm:w-60">
                                <input type="text" x-model="keyboardSearch" placeholder="Search formulas (e.g., kinetic, pH, integral)..."
                                    class="w-full pl-3 pr-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 outline-none focus:border-indigo-500 font-medium">
                            </div>
                        </div>

                        <div x-show="!keyboardSearch.trim()" class="grid grid-cols-2 sm:flex sm:flex-wrap gap-1 bg-slate-100/70 p-1 rounded-xl">
                            <template x-for="tab in scienceBranches" :key="tab.id">
                                <button type="button" @click="keyboardTab = tab.id"
                                    :class="keyboardTab === tab.id ? 'bg-white text-slate-900 border-slate-200 shadow-sm font-extrabold' : 'text-slate-500 border-transparent hover:text-slate-800'"
                                    class="flex-1 min-w-[80px] text-center text-[11px] font-bold py-1.5 rounded-lg border transition-all"
                                    x-text="tab.label"></button>
                            </template>
                        </div>

                        <div class="max-h-[220px] overflow-y-auto space-y-3.5 pr-1">
                            <template x-for="(items, category) in groupedKeyboardItems" :key="category">
                                <div class="space-y-1.5">
                                    <span class="text-[10px] text-slate-400 font-bold tracking-wide flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                        <span x-text="category"></span>
                                    </span>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-1.5">
                                        <template x-for="(sym, idx) in items" :key="category + idx">
                                            <button type="button" @click="insertSymbol(sym.value)" :title="sym.description"
                                                class="p-2 bg-white hover:bg-slate-900 hover:text-white rounded-xl text-[11px] font-bold text-slate-700 border border-slate-200/80 transition-all text-left flex flex-col gap-1 shadow-sm active:scale-95">
                                                <span class="font-mono text-[12px] font-extrabold text-indigo-700 group-hover:text-indigo-300" x-text="sym.label"></span>
                                                <span class="text-[9px] text-slate-400 leading-tight line-clamp-2 font-medium" x-text="sym.description"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <p class="text-[11px] text-slate-500 bg-white border border-slate-200/50 rounded-xl px-3 py-2">
                            Click any key above to insert at your cursor. Use search to filter across all sciences.
                        </p>
                    </div>

                    {{-- Compact keypad when keyboard closed --}}
                    <div x-show="!showScientificKeyboard" class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex flex-col gap-3 shadow-inner" id="interactive-keypad-console">
                        <div>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest pl-1">Scientific variables</span>
                            <div class="grid grid-cols-5 gap-1.5 mt-1.5">
                                <template x-for="b in [{l:'x',v:'x'},{l:'y',v:'y'},{l:'x²',v:'^2'},{l:'^',v:'^'},{l:'√',v:'sqrt('},{l:'π',v:'pi'},{l:'e',v:'e'},{l:'θ',v:'θ'},{l:'(',v:'('},{l:')',v:')'}]" :key="b.l">
                                    <button type="button" @click="insertSymbol(b.v)" class="p-2 rounded-xl text-xs font-bold border bg-indigo-50/70 border-indigo-100 text-indigo-700 hover:bg-indigo-600 hover:text-white transition-all" x-text="b.l"></button>
                                </template>
                            </div>
                        </div>
                        <div>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest pl-1">Numeric Keypad</span>
                            <div class="grid grid-cols-4 gap-1.5 mt-1.5">
                                <button type="button" @click="clearProblem()" class="p-3 bg-red-50 hover:bg-red-600 hover:text-white text-red-600 font-extrabold text-xs rounded-xl border border-red-100">C</button>
                                <button type="button" @click="handleBackspace()" class="p-3 bg-slate-100 hover:bg-slate-800 hover:text-white text-slate-600 font-extrabold text-xs rounded-xl border border-slate-200">⌫</button>
                                <button type="button" @click="insertSymbol(' / ')" class="p-3 bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-extrabold text-sm rounded-xl border border-indigo-100">÷</button>
                                <button type="button" @click="insertSymbol(' * ')" class="p-3 bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-extrabold text-sm rounded-xl border border-indigo-100">×</button>
                                <template x-for="n in ['7','8','9']" :key="n">
                                    <button type="button" @click="insertSymbol(n)" class="p-3 bg-white hover:bg-slate-100 text-slate-800 font-extrabold text-sm rounded-xl border border-slate-200" x-text="n"></button>
                                </template>
                                <button type="button" @click="insertSymbol(' - ')" class="p-3 bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-extrabold text-sm rounded-xl border border-indigo-100">-</button>
                                <template x-for="n in ['4','5','6']" :key="'r2'+n">
                                    <button type="button" @click="insertSymbol(n)" class="p-3 bg-white hover:bg-slate-100 text-slate-800 font-extrabold text-sm rounded-xl border border-slate-200" x-text="n"></button>
                                </template>
                                <button type="button" @click="insertSymbol(' + ')" class="p-3 bg-indigo-50 hover:bg-indigo-600 hover:text-white text-indigo-700 font-extrabold text-sm rounded-xl border border-indigo-100">+</button>
                                <template x-for="n in ['1','2','3']" :key="'r3'+n">
                                    <button type="button" @click="insertSymbol(n)" class="p-3 bg-white hover:bg-slate-100 text-slate-800 font-extrabold text-sm rounded-xl border border-slate-200" x-text="n"></button>
                                </template>
                                <button type="button" @click="solve()" class="p-3 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-xs rounded-xl border border-indigo-700">Enter</button>
                                <button type="button" @click="insertSymbol('0')" class="p-3 bg-white hover:bg-slate-100 text-slate-800 font-extrabold text-sm rounded-xl border border-slate-200">0</button>
                                <button type="button" @click="insertSymbol('.')" class="p-3 bg-white hover:bg-slate-100 text-slate-800 font-extrabold text-sm rounded-xl border border-slate-200">.</button>
                                <button type="button" @click="insertSymbol('sin(')" class="p-3 bg-purple-50 hover:bg-purple-600 hover:text-white text-purple-700 font-bold text-xs rounded-xl border border-purple-100">sin</button>
                                <button type="button" @click="insertSymbol('cos(')" class="p-3 bg-purple-50 hover:bg-purple-600 hover:text-white text-purple-700 font-bold text-xs rounded-xl border border-purple-100">cos</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mode selector --}}
                <div class="space-y-2 border-t border-slate-100 pt-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Tutoring Focus Objective</span>
                    <div class="grid grid-cols-2 gap-2">
                        <template x-for="m in [{mode:'step-by-step',title:'Step Solution'},{mode:'conceptual',title:'Concept Focus'},{mode:'graph',title:'Coordinate Graph'}]" :key="m.mode">
                            <button type="button" @click="mode = m.mode"
                                :class="mode === m.mode ? 'bg-slate-900 border-slate-900 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100'"
                                class="px-3 py-2 text-xs font-semibold rounded-xl border transition-all" x-text="m.title"></button>
                        </template>
                    </div>
                </div>

                <button type="button" @click="solve()" :disabled="loading || !canSolve"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm py-3.5 rounded-xl transition-all flex items-center justify-center gap-2 shadow-md shadow-indigo-100 disabled:opacity-40"
                    id="solve-submit-btn">
                    <span x-show="loading" class="w-4 h-4 rounded-full border-2 border-slate-100 border-t-indigo-300 animate-spin"></span>
                    <span x-text="loading ? 'AI Modeling Constants...' : 'Solve Math Step-By-Step'"></span>
                </button>
            </section>

            {{-- Reference card --}}
            <section class="bg-slate-900 rounded-3xl p-6 shadow-xl flex flex-col gap-4">
                <div>
                    <h3 class="text-white text-base font-bold">Reference Tool</h3>
                    <p class="text-xs text-slate-400 mt-1">Standard mathematical formulas & rules</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-slate-800 rounded-xl border border-slate-700">
                        <p class="text-[10px] uppercase text-slate-400 font-bold mb-1">Power Rule</p>
                        <p class="text-xs text-slate-200 font-serif italic">∫ xⁿ dx = xⁿ⁺¹/(n+1)</p>
                    </div>
                    <div class="p-3 bg-slate-800 rounded-xl border border-slate-700">
                        <p class="text-[10px] uppercase text-slate-400 font-bold mb-1">Derivative Rule</p>
                        <p class="text-xs text-slate-200 font-serif italic">d/dx(xⁿ) = n·xⁿ⁻¹</p>
                    </div>
                </div>
            </section>

            {{-- Presets --}}
            <section class="bg-white border border-slate-200 rounded-3xl p-5 shadow-sm space-y-3">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">Select A Sample</h3>
                <div class="space-y-2">
                    <template x-for="(p, idx) in presets" :key="idx">
                        <button type="button" @click="applyPreset(p)"
                            class="w-full text-left p-3 rounded-xl border border-slate-100 hover:border-indigo-300 hover:bg-slate-50 transition-all">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded" x-text="p.category"></span>
                            <p class="text-xs font-mono font-bold text-slate-800 mt-1 truncate" x-text="p.problem"></p>
                        </button>
                    </template>
                </div>
            </section>

            {{-- History --}}
            <section x-show="history.length > 0" x-cloak class="bg-white border border-slate-200 rounded-3xl p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Recent History</h3>
                    <button type="button" @click="clearHistory()" class="text-[10px] font-bold text-slate-400 hover:text-indigo-600">Clear All</button>
                </div>
                <div class="space-y-1.5 max-h-[160px] overflow-y-auto">
                    <template x-for="h in history" :key="h.id">
                        <button type="button" @click="loadHistoryItem(h)" class="w-full text-left p-2.5 hover:bg-slate-50 border border-slate-100 rounded-xl transition-all">
                            <p class="text-xs font-mono font-semibold text-slate-700 truncate" x-text="h.problem"></p>
                            <span class="text-[9px] text-slate-400 block mt-0.5" x-text="h.timestamp"></span>
                        </button>
                    </template>
                </div>
            </section>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="lg:col-span-7 flex flex-col min-h-[550px]" id="right-workspace-panel" x-ref="resultsPanel">

            <div x-show="error" x-cloak class="mb-6 p-5 bg-rose-50 border border-rose-200 rounded-3xl text-sm text-slate-800">
                <h4 class="font-bold text-rose-950">Something went wrong</h4>
                <p class="mt-0.5 text-xs text-slate-600" x-text="error"></p>
            </div>

            {{-- Loading --}}
            <section x-show="loading" x-cloak class="flex-1 bg-white border border-slate-200 rounded-3xl p-8 shadow-sm flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 relative flex items-center justify-center">
                    <div class="absolute inset-0 border-4 border-indigo-100 rounded-full animate-ping opacity-60"></div>
                    <div class="absolute inset-0 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
                    <span class="text-2xl text-indigo-600 relative z-10 font-bold">∑</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 mt-6">MathMind Compute Engine Active</h3>
                <p class="text-xs text-slate-500 mt-1 font-mono" x-text="loadingText"></p>
            </section>

            {{-- Results --}}
            <section x-show="response && !loading" class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex-1 flex flex-col gap-6">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-600">Step-by-step solution</span>
                        <h2 class="text-xl font-bold mt-1 text-indigo-950" x-text="response?.solvedProblem"></h2>
                        @if(!empty($solverQuery))
                            <p class="text-sm text-gray-500 mt-1">Problem: <span>{{ $solverQuery }}</span></p>
                        @else
                            <p x-show="problem" class="text-sm text-gray-500 mt-1">Problem: <span x-text="problem"></span></p>
                        @endif
                    </div>
                    <div class="bg-indigo-50 border border-indigo-100 px-4 py-2.5 rounded-2xl sm:max-w-[45%]">
                        <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider block">Final answer</span>
                        <span class="text-sm font-mono font-extrabold text-indigo-700 block mt-1 break-words" x-text="activeFinalAnswer"></span>
                    </div>
                </div>

                {{-- Image OCR info --}}
                <div x-show="response?.extractedText || response?.extractedLatex" class="bg-slate-50 border border-slate-200 rounded-2xl p-3.5 text-sm text-slate-600">
                    <p x-show="response?.extractedText"><strong>Read from image:</strong> <span x-text="response.extractedText"></span></p>
                    <p x-show="response?.extractedLatex" class="formula-block text-center my-2">$$<span x-text="response.extractedLatex"></span>$$</p>
                </div>

                {{-- Engine selector --}}
                <div x-show="hasMultipleEngines" class="p-3 bg-slate-50 border border-slate-200 rounded-2xl flex flex-wrap items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Verification Solvers:</span>
                    <div class="flex bg-slate-200/60 p-1 rounded-xl gap-1 flex-wrap">
                        <button type="button" @click="selectedEngine = 'consensus'"
                            :class="selectedEngine === 'consensus' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500'"
                            class="px-3 py-1 text-xs font-bold rounded-lg">Consensus</button>
                        <button type="button" x-show="response?.alphaResponse" @click="selectedEngine = 'alpha'"
                            :class="selectedEngine === 'alpha' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500'"
                            class="px-3 py-1 text-xs font-bold rounded-lg">Solver Alpha</button>
                        <button type="button" x-show="response?.betaResponse" @click="selectedEngine = 'beta'"
                            :class="selectedEngine === 'beta' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500'"
                            class="px-3 py-1 text-xs font-bold rounded-lg">Solver Beta</button>
                        <button type="button" x-show="response?.gammaResponse" @click="selectedEngine = 'gamma'"
                            :class="selectedEngine === 'gamma' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-500'"
                            class="px-3 py-1 text-xs font-bold rounded-lg">Solver Gamma</button>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="flex items-center gap-1 border-b border-slate-200 flex-wrap">
                    <button type="button" @click="activeTab = 'solution'"
                        :class="activeTab === 'solution' ? 'border-indigo-600 text-indigo-600 font-extrabold' : 'border-transparent text-slate-400'"
                        class="px-4 py-2.5 text-xs font-bold border-b-2 transition-all">Steps Solution</button>
                    <button type="button" x-show="response?.graphable" @click="activeTab = 'graph'; refreshGraph()"
                        :class="activeTab === 'graph' ? 'border-indigo-600 text-indigo-600 font-extrabold' : 'border-transparent text-slate-400'"
                        class="px-4 py-2.5 text-xs font-bold border-b-2 transition-all">Coordinate Graph</button>
                    <button type="button" @click="activeTab = 'theorems'"
                        :class="activeTab === 'theorems' ? 'border-indigo-600 text-indigo-600 font-extrabold' : 'border-transparent text-slate-400'"
                        class="px-4 py-2.5 text-xs font-bold border-b-2 transition-all">Applied Formulas</button>
                    <button type="button" @click="activeTab = 'chat'"
                        :class="activeTab === 'chat' ? 'border-indigo-600 text-indigo-600 font-extrabold' : 'border-transparent text-slate-400'"
                        class="px-4 py-2.5 text-xs font-bold border-b-2 transition-all">AI Tutor Helper</button>
                </div>

                <div class="flex-1 overflow-y-auto pr-1 min-h-[300px]">

                    {{-- Solution tab --}}
                    <div x-show="activeTab === 'solution'" class="space-y-6">
                        <div x-show="selectedEngine === 'consensus' && response?.synthesis?.comparisonMarkdown"
                            class="mb-6 bg-indigo-50/50 border border-indigo-100 rounded-2xl p-5">
                            <h4 class="font-bold text-indigo-950 text-sm mb-2">AI Referee Peer Review Analysis</h4>
                            <div class="text-sm text-slate-700 whitespace-pre-wrap" x-text="response.synthesis.comparisonMarkdown"></div>
                        </div>
                        <template x-for="(step, idx) in activeSteps" :key="idx">
                            <div class="flex gap-4 border border-gray-100 rounded-xl p-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm border border-indigo-100" x-text="idx + 1"></div>
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-800 text-sm" x-text="step.title"></p>
                                    <p class="text-sm text-slate-600 mt-1 leading-relaxed" x-text="step.explanation"></p>
                                    <p x-show="step.formula" class="text-xs font-mono mt-2 bg-slate-50 p-2.5 rounded-xl border border-slate-200/50 text-slate-700" x-text="step.formula"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Graph tab --}}
                    <div x-show="activeTab === 'graph'" class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <h4 class="text-sm font-extrabold text-slate-900">Dynamic Coordinate Grapher</h4>
                            <div class="flex gap-1">
                                <button type="button" @click="graphZoomIn()" class="p-1.5 bg-white border border-slate-200 rounded-lg text-xs">Zoom +</button>
                                <button type="button" @click="graphZoomOut()" class="p-1.5 bg-white border border-slate-200 rounded-lg text-xs">Zoom −</button>
                                <button type="button" @click="graphReset()" class="p-1.5 bg-white border border-slate-200 rounded-lg text-xs">Reset</button>
                            </div>
                        </div>
                        <svg viewBox="0 0 500 380" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl">
                            <line x1="0" y1="190" x2="500" y2="190" stroke="#94A3B8" stroke-width="1.5"/>
                            <line x1="250" y1="0" x2="250" y2="380" stroke="#94A3B8" stroke-width="1.5"/>
                            <template x-for="(path, index) in graphPaths" :key="index">
                                <path :d="path" fill="none" :stroke="graphColors[index % graphColors.length]" stroke-width="3" stroke-linecap="round"/>
                            </template>
                        </svg>
                    </div>

                    {{-- Theorems tab --}}
                    <div x-show="activeTab === 'theorems'" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="(concept, idx) in activeConcepts" :key="idx">
                            <div class="bg-slate-50 border border-slate-200 p-5 rounded-2xl shadow-sm">
                                <h4 class="text-sm font-bold text-slate-900" x-text="concept.name"></h4>
                                <p class="text-xs text-slate-600 mt-2 leading-relaxed" x-text="concept.definition"></p>
                            </div>
                        </template>
                    </div>

                    {{-- Chat tab (single tutor) --}}
                    <div x-show="activeTab === 'chat'" class="flex flex-col min-h-[380px]">
                        <div class="flex-1 space-y-3 mb-4 max-h-80 overflow-y-auto">
                            <template x-for="(msg, index) in chatMessages" :key="index">
                                <div :class="msg.role === 'user' ? 'text-right' : 'text-left'">
                                    <span :class="msg.role === 'user' ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-800'"
                                        class="inline-block px-4 py-2 rounded-xl text-sm max-w-[90%] whitespace-pre-wrap" x-text="msg.text"></span>
                                </div>
                            </template>
                            <div x-ref="chatEnd"></div>
                        </div>
                        <div class="flex gap-2 border-t border-slate-100 pt-4">
                            <input type="text" x-model="chatInput" @keydown.enter.prevent="sendChat()" placeholder="Ask a question about this solution…"
                                class="flex-1 px-4 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <button type="button" @click="sendChat()" :disabled="chatLoading || !chatInput.trim()"
                                class="px-5 py-2 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 disabled:opacity-50 text-sm">Send</button>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Calculated with Advanced Verification Engines</span>
                    <button type="button" @click="copyResult()" class="hover:text-indigo-600 font-medium" x-text="copied ? 'Copied!' : 'Copy Result'"></button>
                </div>
            </section>

            {{-- Empty state --}}
            <section x-show="!response && !loading" class="bg-white border border-slate-200 rounded-3xl p-8 flex flex-col items-center justify-center text-center py-12 shadow-sm">
                <div class="w-16 h-16 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-center text-indigo-600 mb-6 font-mono text-3xl font-bold">∑</div>
                <h2 class="text-lg font-bold text-slate-900">AI Mathematics Playground</h2>
                <p class="text-sm text-slate-500 mt-2 leading-relaxed max-w-md">
                    Enter algebraic expressions, derivatives, or trigonometric structures. Get step-by-step breakdowns, graphs, applied formulas, and AI tutoring.
                </p>
            </section>
        </div>
    </main>
</div>
