<div id="floating-timer" class="fixed bottom-6 right-6 z-50 transition-all duration-300 transform translate-y-0 opacity-100">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700 p-4 w-64">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center space-x-2">
                <div id="timer-status-dot" class="w-2 h-2 rounded-full bg-gray-400"></div>
                <span id="timer-label" class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cronômetro</span>
            </div>
            <button onclick="toggleTimerSettings()" class="text-gray-400 hover:text-indigo-500 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </button>
        </div>

        <div class="text-center mb-4">
            <div id="timer-display" class="text-4xl font-black text-gray-900 dark:text-white tabular-nums">00:00:00</div>
        </div>

        <div class="flex items-center justify-center space-x-3">
            <button id="timer-start-btn" onclick="startTimer()" class="p-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200 dark:shadow-none transition-all">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            </button>
            <button id="timer-pause-btn" onclick="pauseTimer()" class="hidden p-3 rounded-xl bg-amber-500 text-white hover:bg-amber-600 shadow-lg shadow-amber-200 dark:shadow-none transition-all">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
            </button>
            <button onclick="resetTimer()" class="p-3 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
            </button>
        </div>

        <div id="timer-settings" class="hidden mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500 dark:text-gray-400">Modo Pomodoro</span>
                <button onclick="togglePomodoroMode()" id="pomodoro-toggle" class="w-10 h-5 bg-gray-200 dark:bg-gray-700 rounded-full relative transition-colors">
                    <div id="pomodoro-dot" class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full transition-transform"></div>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let timerInterval;
    let seconds = 0;
    let isRunning = false;
    let isPomodoro = false;
    let pomodoroTime = 25 * 60;

    function updateDisplay() {
        const h = Math.floor(seconds / 3600).toString().padStart(2, '0');
        const m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
        const s = (seconds % 60).toString().padStart(2, '0');
        document.getElementById('timer-display').innerText = `${h}:${m}:${s}`;
        
        // Atualizar título da página
        document.title = `${h}:${m}:${s} - estudaAI`;
    }

    function startTimer() {
        if (isRunning) return;
        isRunning = true;
        document.getElementById('timer-start-btn').classList.add('hidden');
        document.getElementById('timer-pause-btn').classList.remove('hidden');
        document.getElementById('timer-status-dot').classList.replace('bg-gray-400', 'bg-green-500');
        
        timerInterval = setInterval(() => {
            if (isPomodoro) {
                if (seconds > 0) seconds--;
                else {
                    pauseTimer();
                    alert('Tempo esgotado! Hora de uma pausa.');
                }
            } else {
                seconds++;
            }
            updateDisplay();
        }, 1000);
    }

    function pauseTimer() {
        isRunning = false;
        clearInterval(timerInterval);
        document.getElementById('timer-start-btn').classList.remove('hidden');
        document.getElementById('timer-pause-btn').classList.add('hidden');
        document.getElementById('timer-status-dot').classList.replace('bg-green-500', 'bg-amber-500');
    }

    function resetTimer() {
        pauseTimer();
        seconds = isPomodoro ? pomodoroTime : 0;
        document.getElementById('timer-status-dot').className = 'w-2 h-2 rounded-full bg-gray-400';
        updateDisplay();
    }

    function toggleTimerSettings() {
        document.getElementById('timer-settings').classList.toggle('hidden');
    }

    function togglePomodoroMode() {
        isPomodoro = !isPomodoro;
        const dot = document.getElementById('pomodoro-dot');
        const toggle = document.getElementById('pomodoro-toggle');
        const label = document.getElementById('timer-label');
        
        if (isPomodoro) {
            dot.style.transform = 'translateX(20px)';
            toggle.classList.replace('bg-gray-200', 'bg-indigo-600');
            label.innerText = 'Pomodoro';
            seconds = pomodoroTime;
        } else {
            dot.style.transform = 'translateX(0)';
            toggle.classList.replace('bg-indigo-600', 'bg-gray-200');
            label.innerText = 'Cronômetro';
            seconds = 0;
        }
        resetTimer();
    }
</script>
