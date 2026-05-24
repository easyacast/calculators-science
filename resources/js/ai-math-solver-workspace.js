import { SCIENCE_BRANCHES, SYMBOLS_DATA } from './ai-math-solver-symbols.js';

const MATH_PRESETS = [
    { category: 'Algebra', title: 'Quadratic Equation', problem: 'Solve 2x^2 + 5x - 3 = 0', mode: 'step-by-step' },
    { category: 'Calculus', title: 'Derivative Rule', problem: 'Find the derivative of f(x) = x^3 - 3*x + 2', mode: 'step-by-step' },
    { category: 'Trigonometry', title: 'Graph Plot', problem: 'Plot y = 2 * Math.sin(2 * x)', mode: 'graph' },
    { category: 'Linear Algebra', title: 'Linear System', problem: 'Solve system: 3x + 2y = 12 and x - y = 1', mode: 'conceptual' },
];

const LOADING_STEPS = [
    'Analyzing equation constants...',
    'Processing uploaded math imagery...',
    'Cross-verifying with multiple solvers...',
    'Building step-by-step breakdown...',
];

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

function renderMathEl(el) {
    if (typeof renderMathInElement === 'function' && el) {
        renderMathInElement(el, {
            delimiters: [
                { left: '$$', right: '$$', display: true },
                { left: '$', right: '$', display: false },
            ],
        });
    }
}

function evalGraphExpr(expr, x, params = { a: 2, b: 1, c: 0 }) {
    try {
        let sanitized = expr
            .replace(/\bax\b/gi, 'a*x')
            .replace(/\bbx\b/gi, 'b*x')
            .replace(/\bcx\b/gi, 'c*x')
            .replace(/\bsin\b/gi, 'Math.sin')
            .replace(/\bcos\b/gi, 'Math.cos')
            .replace(/\btan\b/gi, 'Math.tan')
            .replace(/\babs\b/gi, 'Math.abs')
            .replace(/\bsqrt\b/gi, 'Math.sqrt')
            .replace(/\bpow\b/gi, 'Math.pow')
            .replace(/\bpi\b/gi, 'Math.PI')
            .replace(/\be\b/gi, 'Math.E')
            .replace(/(\d+)x/g, '$1*x')
            .replace(/\^/g, '**');
        const fn = new Function('x', 'a', 'b', 'c', 'Math', `try { return ${sanitized}; } catch(e) { return NaN; }`);
        const result = fn(x, params.a, params.b, params.c, Math);
        return typeof result === 'number' && isFinite(result) ? result : NaN;
    } catch {
        return NaN;
    }
}

function buildGraphPaths(functions, zoom = 1, width = 500, height = 380, offset = { x: 0, y: 0 }, params = { a: 2, b: 1, c: 0 }) {
    const scaleX = (width / 20) * zoom;
    const scaleY = (height / 20) * zoom;
    const originX = width / 2 + offset.x;
    const originY = height / 2 + offset.y;
    const toScreenX = (mx) => originX + mx * scaleX;
    const toScreenY = (my) => originY - my * scaleY;
    const mathXMin = (0 - originX) / scaleX;
    const mathXMax = (width - originX) / scaleX;
    const step = 0.05 / zoom;

    return (functions || []).filter(Boolean).map((expr) => {
        let d = '';
        let drawing = false;
        for (let mx = mathXMin; mx <= mathXMax; mx += step) {
            const my = evalGraphExpr(expr, mx, params);
            const sx = toScreenX(mx);
            const sy = toScreenY(my);
            if (!isNaN(my) && isFinite(my) && sy >= -height && sy <= height * 2) {
                d += (drawing ? ' L ' : 'M ') + sx + ' ' + sy;
                drawing = true;
            } else {
                drawing = false;
            }
        }
        return d;
    }).filter(Boolean);
}

async function compressImage(dataUrl, maxDim = 1280, quality = 0.82) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => {
            let { width, height } = img;
            const scale = Math.min(1, maxDim / Math.max(width, height));
            width = Math.round(width * scale);
            height = Math.round(height * scale);
            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            if (!ctx) return reject(new Error('Canvas not supported'));
            ctx.drawImage(img, 0, 0, width, height);
            resolve(canvas.toDataURL('image/jpeg', quality));
        };
        img.onerror = () => reject(new Error('Failed to load image'));
        img.src = dataUrl;
    });
}

window.aiMathSolverWorkspace = function (config) {
    return {
        problem: config.query || '',
        mode: config.mode || 'step-by-step',
        solveUrl: config.solveUrl,
        response: config.initialResponse || null,
        inputTab: 'text',
        showScientificKeyboard: false,
        keyboardTab: 'math',
        keyboardSearch: '',
        scienceBranches: SCIENCE_BRANCHES,
        symbolsData: SYMBOLS_DATA,
        presets: MATH_PRESETS,
        loading: false,
        loadingText: LOADING_STEPS[0],
        error: null,
        activeTab: 'solution',
        selectedEngine: 'consensus',
        image: null,
        imagePreview: null,
        isCameraActive: false,
        cameraStream: null,
        history: [],
        copied: false,
        chatMessages: [],
        chatInput: '',
        chatLoading: false,
        graphZoom: 1,
        graphOffset: { x: 0, y: 0 },
        graphParams: { a: 2, b: 1, c: 0 },
        graphPaths: [],
        graphColors: ['#10B981', '#F59E0B', '#3B82F6', '#EC4899', '#8B5CF6'],

        init() {
            this.loadHistory();
            if (this.response) {
                this.syncEngine();
                this.activeTab = 'solution';
                this.initChat();
                this.refreshGraph();
                this.$nextTick(() => renderMathEl(this.$refs.resultsPanel));
            }
        },

        loadHistory() {
            try {
                this.history = JSON.parse(localStorage.getItem('ai-math-solver-history') || '[]');
            } catch {
                this.history = [];
            }
        },

        saveHistory(entry) {
            this.history = [entry, ...this.history.filter((h) => h.problem !== entry.problem)].slice(0, 20);
            localStorage.setItem('ai-math-solver-history', JSON.stringify(this.history));
        },

        syncEngine() {
            if (!this.response) return;
            if (this.response.synthesis) this.selectedEngine = 'consensus';
            else if (this.response.alphaResponse) this.selectedEngine = 'alpha';
            else if (this.response.gammaResponse) this.selectedEngine = 'gamma';
            else if (this.response.betaResponse) this.selectedEngine = 'beta';
        },

        get engineCount() {
            if (!this.response) return 0;
            return [this.response.alphaResponse, this.response.betaResponse, this.response.gammaResponse].filter(Boolean).length;
        },

        get hasMultipleEngines() {
            return this.engineCount >= 2;
        },

        get activePayload() {
            if (!this.response) return null;
            if (this.selectedEngine === 'alpha' && this.response.alphaResponse) return this.response.alphaResponse;
            if (this.selectedEngine === 'beta' && this.response.betaResponse) return this.response.betaResponse;
            if (this.selectedEngine === 'gamma' && this.response.gammaResponse) return this.response.gammaResponse;
            return this.response;
        },

        get activeSteps() {
            return this.activePayload?.steps || [];
        },

        get activeConcepts() {
            return this.activePayload?.concepts || [];
        },

        get activeFinalAnswer() {
            return this.activePayload?.finalAnswer || '';
        },

        get activeGraphFunctions() {
            return this.activePayload?.graphFunctions || [];
        },

        get canSolve() {
            if (this.inputTab === 'photo') return !!this.image;
            return this.problem.trim().length > 0;
        },

        get keyboardItems() {
            if (this.keyboardSearch.trim()) {
                const q = this.keyboardSearch.toLowerCase();
                const all = Object.values(this.symbolsData).flat();
                return all.filter(
                    (item) =>
                        item.label.toLowerCase().includes(q) ||
                        item.description.toLowerCase().includes(q) ||
                        item.category.toLowerCase().includes(q)
                );
            }
            return this.symbolsData[this.keyboardTab] || [];
        },

        get groupedKeyboardItems() {
            const groups = {};
            for (const item of this.keyboardItems) {
                if (!groups[item.category]) groups[item.category] = [];
                groups[item.category].push(item);
            }
            return groups;
        },

        insertSymbol(val) {
            const ta = this.$refs.problemInput;
            if (!ta) {
                this.problem += val;
                return;
            }
            const start = ta.selectionStart;
            const end = ta.selectionEnd;
            this.problem = this.problem.substring(0, start) + val + this.problem.substring(end);
            this.$nextTick(() => {
                ta.focus();
                const pos = start + val.length;
                ta.setSelectionRange(pos, pos);
            });
        },

        handleBackspace() {
            const ta = this.$refs.problemInput;
            if (!ta) {
                this.problem = this.problem.slice(0, -1);
                return;
            }
            const start = ta.selectionStart;
            const end = ta.selectionEnd;
            if (start !== end) {
                this.problem = this.problem.substring(0, start) + this.problem.substring(end);
            } else if (start > 0) {
                this.problem = this.problem.substring(0, start - 1) + this.problem.substring(start);
                this.$nextTick(() => ta.setSelectionRange(start - 1, start - 1));
            }
            ta.focus();
        },

        clearProblem() {
            this.problem = '';
            this.$refs.problemInput?.focus();
        },

        applyPreset(preset) {
            this.problem = preset.problem;
            this.mode = preset.mode;
            this.inputTab = 'text';
        },

        loadHistoryItem(item) {
            this.problem = item.problem;
            this.mode = item.mode || 'step-by-step';
            this.inputTab = 'text';
            if (item.response) {
                this.response = item.response;
                this.syncEngine();
                this.initChat();
                this.refreshGraph();
                this.$nextTick(() => renderMathEl(this.$refs.resultsPanel));
            }
        },

        clearHistory() {
            this.history = [];
            localStorage.removeItem('ai-math-solver-history');
        },

        async handleFile(event) {
            const file = event.target.files?.[0];
            if (!file) return;
            if (!file.type.startsWith('image/')) {
                this.error = 'Please select a valid image file (PNG, JPG, JPEG, WEBP).';
                return;
            }
            this.error = null;
            const reader = new FileReader();
            reader.onload = async () => {
                try {
                    this.image = await compressImage(reader.result);
                    this.imagePreview = this.image;
                } catch {
                    this.error = 'Failed to process selected image file.';
                }
            };
            reader.readAsDataURL(file);
        },

        triggerFileInput() {
            this.$refs.fileInput?.click();
        },

        clearImage() {
            this.image = null;
            this.imagePreview = null;
            this.stopCamera();
        },

        async startCamera() {
            try {
                this.isCameraActive = true;
                await this.$nextTick();
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } });
                this.cameraStream = stream;
                if (this.$refs.cameraVideo) {
                    this.$refs.cameraVideo.srcObject = stream;
                }
            } catch {
                this.error = 'Camera access denied or unavailable.';
                this.isCameraActive = false;
            }
        },

        stopCamera() {
            if (this.cameraStream) {
                this.cameraStream.getTracks().forEach((t) => t.stop());
                this.cameraStream = null;
            }
            this.isCameraActive = false;
        },

        capturePhoto() {
            const video = this.$refs.cameraVideo;
            if (!video) return;
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d')?.drawImage(video, 0, 0);
            this.image = canvas.toDataURL('image/jpeg', 0.82);
            this.imagePreview = this.image;
            this.stopCamera();
        },

        handleDrop(event) {
            event.preventDefault();
            const file = event.dataTransfer?.files?.[0];
            if (file) this.handleFile({ target: { files: [file] } });
        },

        refreshGraph() {
            this.graphPaths = buildGraphPaths(
                this.activeGraphFunctions,
                this.graphZoom,
                500,
                380,
                this.graphOffset,
                this.graphParams
            );
        },

        graphZoomIn() {
            this.graphZoom = Math.min(this.graphZoom * 1.3, 15);
            this.refreshGraph();
        },

        graphZoomOut() {
            this.graphZoom = Math.max(this.graphZoom / 1.3, 0.15);
            this.refreshGraph();
        },

        graphReset() {
            this.graphZoom = 1;
            this.graphOffset = { x: 0, y: 0 };
            this.graphParams = { a: 2, b: 1, c: 0 };
            this.refreshGraph();
        },

        initChat() {
            if (!this.response) {
                this.chatMessages = [{
                    role: 'assistant',
                    text: 'Hi there! Submit an equation in the left panel and I will help explain the solution step by step.',
                }];
                return;
            }
            this.chatMessages = [{
                role: 'assistant',
                text: `Hello! I'm your AI Tutoring Assistant. I have reviewed your problem: "${this.response.solvedProblem}". How can I help you understand this better?`,
            }];
        },

        async sendChat() {
            const text = this.chatInput.trim();
            if (!text || this.chatLoading || !this.response) return;
            this.chatMessages.push({ role: 'user', text });
            this.chatInput = '';
            this.chatLoading = true;
            try {
                const res = await fetch('/api/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        problemContext: this.response,
                        chatHistory: this.chatMessages.filter((m) => m.role === 'user' || m.role === 'assistant').slice(0, -1),
                        newMessage: text,
                    }),
                });
                const data = await res.json();
                this.chatMessages.push({ role: 'assistant', text: data.text || 'No response received.' });
            } catch {
                this.chatMessages.push({ role: 'assistant', text: 'Could not reach the tutor. Please try again.' });
            } finally {
                this.chatLoading = false;
                this.$nextTick(() => this.$refs.chatEnd?.scrollIntoView({ behavior: 'smooth' }));
            }
        },

        copyResult() {
            const text = [
                this.response?.solvedProblem,
                'Answer: ' + this.activeFinalAnswer,
                ...(this.activeSteps || []).map((s, i) => `${i + 1}. ${s.title}: ${s.explanation}${s.formula ? ' [' + s.formula + ']' : ''}`),
            ].filter(Boolean).join('\n');
            navigator.clipboard.writeText(text).then(() => {
                this.copied = true;
                setTimeout(() => { this.copied = false; }, 2000);
            });
        },

        setResponse(data) {
            this.response = data;
            this.error = null;
            this.activeTab = 'solution';
            this.syncEngine();
            this.initChat();
            this.refreshGraph();
            this.saveHistory({
                id: Date.now(),
                problem: this.problem || data.solvedProblem,
                mode: this.mode,
                timestamp: new Date().toLocaleString(),
                response: data,
            });
            this.$nextTick(() => renderMathEl(this.$refs.resultsPanel));
        },

        async solve() {
            this.error = null;

            if (this.inputTab === 'photo' && this.image) {
                this.loading = true;
                let stepIdx = 0;
                this.loadingText = LOADING_STEPS[0];
                const interval = setInterval(() => {
                    stepIdx = (stepIdx + 1) % LOADING_STEPS.length;
                    this.loadingText = LOADING_STEPS[stepIdx];
                }, 2200);
                try {
                    const res = await fetch('/api/solve', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': csrfToken(),
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            problem: this.problem.trim(),
                            mode: this.mode,
                            image: this.image,
                            mimeType: this.image.split(';')[0].replace('data:', ''),
                        }),
                    });
                    const data = await res.json();
                    if (!res.ok) throw new Error(data.message || 'Solve request failed.');
                    this.setResponse(data);
                } catch (e) {
                    this.error = e.message || 'Something went wrong. Please try again.';
                } finally {
                    clearInterval(interval);
                    this.loading = false;
                }
                return;
            }

            if (!this.problem.trim()) {
                this.error = 'Please enter a math problem.';
                return;
            }

            const url = new URL(this.solveUrl, window.location.origin);
            url.searchParams.set('q', this.problem.trim());
            url.searchParams.set('mode', this.mode);
            window.location.href = url.toString();
        },
    };
};
