<div x-data="timer()" 
     class="fixed bottom-6 right-6 z-50"
     @keydown.window.escape="sidebarOpen = false">
    
    <!-- Botão do Cronômetro -->
    <button @click="open = !open" 
            class="flex items-center justify-center w-14 h-14 bg-indigo-600 text-white rounded-full shadow-lg hover:bg-indigo-700 transition-all duration-300 focus:outline-none">
        <svg x-show="!running" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span x-show="running" class="font-mono text-xs" x-text="formatTime(seconds)"></span>
    </button>

    <!-- Painel do Cronômetro -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
         class="absolute bottom-16 right-0 w-64 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 p-4">
        
        <div class="text-center">
            <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tempo de Estudo</h4>
            <div class="text-4xl font-mono font-bold text-gray-900 dark:text-white my-4" x-text="formatTime(seconds)"></div>
            
            <div class="flex justify-center space-x-3">
                <button @click="toggle()" 
                        :class="running ? 'bg-amber-100 text-amber-700 hover:bg-amber-200' : 'bg-green-100 text-green-700 hover:bg-green-200'"
                        class="px-4 py-2 rounded-lg font-medium transition-colors">
                    <span x-text="running ? 'Pausar' : 'Iniciar'"></span>
                </button>
                <button @click="reset()" 
                        class="px-4 py-2 bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    Zerar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function timer() {
        return {
            open: false,
            running: false,
            seconds: 0,
            interval: null,
            
            toggle() {
                if (this.running) {
                    clearInterval(this.interval);
                } else {
                    this.interval = setInterval(() => {
                        this.seconds++;
                    }, 1000);
                }
                this.running = !this.running;
            },
            
            reset() {
                clearInterval(this.interval);
                this.running = false;
                this.seconds = 0;
            },
            
            formatTime(s) {
                const h = Math.floor(s / 3600);
                const m = Math.floor((s % 3600) / 60);
                const sec = s % 60;
                return [h, m, sec].map(v => v < 10 ? '0' + v : v).filter((v, i) => v !== '00' || i > 0).join(':');
            }
        }
    }
</script>
