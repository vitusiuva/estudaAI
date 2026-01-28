<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Olá, {{ Auth::user()->name }}! 👋</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Aqui está o resumo do seu progresso nos estudos.</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route(\'plans.index\') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition-all">
                    Ver Meus Planos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-6">
        {{-- Cards de Estatísticas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalHours }}h</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Tempo Total</div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-green-50 dark:bg-green-900/30 rounded-lg text-green-600 dark:text-green-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $precision }}%</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Precisão Média</div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-amber-50 dark:bg-amber-900/30 rounded-lg text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingRevisionsCount }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Revisões Pendentes</div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-2 bg-rose-50 dark:bg-rose-900/30 rounded-lg text-rose-600 dark:text-rose-400">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">7 dias</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Maior Streak</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Gráfico de Horas (Simulado com CSS/SVG) --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Horas Estudadas (Últimos 7 dias)</h3>
                <div class="flex items-end justify-between h-48 px-2">
                    @foreach($last7Days as $data)
                    <div class="flex flex-col items-center w-full">
                        <div class="w-8 bg-indigo-500 rounded-t-lg transition-all hover:bg-indigo-600 relative group" style="height: {{ ($data[\'hours\'] / max($last7Days->pluck(\'hours\')->max(), 1)) * 100 }}%">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                {{ $data[\'hours\'] }}h
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 mt-2">{{ $data[\'day\'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Desempenho por Disciplina --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Top Disciplinas</h3>
                <div class="space-y-4">
                    @foreach($disciplineStats as $stat)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="font-bold text-gray-700 dark:text-gray-300">{{ $stat->name }}</span>
                            <span class="text-gray-500">{{ round($stat->total_minutes / 60, 1) }}h</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: {{ ($stat->total_minutes / max($disciplineStats->max(\'total_minutes\'), 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Atividades Recentes --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Atividades Recentes</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentLogs as $log)
                    <div class="p-4 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <div class="mr-4 p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $log->topic->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $log->topic->discipline->name }} • {{ $log->duration_minutes }} min</div>
                        </div>
                        <div class="text-xs text-gray-400">{{ $log->studied_at->diffForHumans() }}</div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">Nenhuma atividade recente.</div>
                    @endforelse
                </div>
            </div>

            {{-- Próximas Revisões --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Próximas Revisões</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($upcomingRevisions as $rev)
                    <div class="p-4 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <div class="mr-4 p-2 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $rev->topic->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $rev->topic->discipline->name }} • {{ $rev->interval_days }} dias</div>
                        </div>
                        <div class="text-xs font-bold {{ $rev->scheduled_date->isToday() ? \'text-amber-500\' : \'text-gray-400\' }}">
                            {{ $rev->scheduled_date->isToday() ? \'Hoje\' : $rev->scheduled_date->format(\'d/m\') }}
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">Nenhuma revisão agendada.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
