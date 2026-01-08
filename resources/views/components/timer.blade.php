<div x-data="timer()" class="bg-gray-900 text-white p-4 rounded-lg shadow-lg flex items-center justify-between">
    <div class="text-2xl font-mono" x-text="formatTime(seconds)">00:00:00</div>
    <div class="flex space-x-2">
        <button @click="toggle()" class="bg-green-500 hover:bg-green-600 p-2 rounded-full">
            <svg x-show="!running" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4.5 3.5v13l11-6.5-11-6.5z"/></svg>
            <svg x-show="running" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4h3v12H5V4zm7 0h3v12h-3V4z"/></svg>
        </button>
        <button @click="reset()" class="bg-red-500 hover:bg-red-600 p-2 rounded-full">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4h12v12H4V4z"/></svg>
        </button>
    </div>
</div>

<script>
function timer() {
    return {
        seconds: 0,
        running: false,
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
            this.seconds = 0;
            this.running = false;
        },
        formatTime(s) {
            return new Date(s * 1000).toISOString().substr(11, 8);
        }
    }
}
</script>
