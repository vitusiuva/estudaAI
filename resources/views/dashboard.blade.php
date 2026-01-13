<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Bem-vindo de volta, {{ Auth::user()->name }}! 👋</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Aqui está o resumo do seu progresso nos estudos.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('plans.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                    Ver Meus Planos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Grid de Estatísticas Rápidas -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Tempo Total -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-50 dark:bg-blue-900/30 p-3 rounded-xl">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Tempo de Estudo</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ floor($totalStudyTime / 60) }}h {{ $totalStudyTime % 60 }}m</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Questões -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-50 dark:bg-green-900/30 p-3 rounded-xl">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Questões Totais</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalQuestions }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Precisão -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-50 dark:bg-purple-900/30 p-3 rounded-xl">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Precisão Média</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $accuracy }}%</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Planos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-amber-50 dark:bg-amber-900/30 p-3 rounded-xl">
                        <svg class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Planos Ativos</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $plans->count() }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
            <!-- Revisões Pendentes -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Revisões para Hoje</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                        {{ $pendingRevisions->count() }} pendentes
                    </span>
                </div>
                <div class="p-6">
                    @if($pendingRevisions->isEmpty())
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-400 mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">Tudo em dia! Nenhuma revisão para hoje.</p>
                        </div>
                    @else
                        <ul class="space-y-4">
                            @foreach($pendingRevisions as $revision)
                                <li class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50 border border-transparent hover:border-indigo-200 dark:hover:border-indigo-800 transition-all">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-indigo-500 mr-4"></div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $revision->topic->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $revision->topic->discipline->name }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('revisions.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium">Revisar</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Atividades Recentes -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Atividades Recentes</h3>
                </div>
                <div class="p-6">
                    @if($recentLogs->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Nenhum registro de estudo ainda.</p>
                        </div>
                    @else
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($recentLogs as $log)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                        <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $log->topic->name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->duration_minutes }} min • {{ ucfirst($log->type) }}</p>
                                                    </div>
                                                    <div class="text-right text-xs whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                        {{ $log->studied_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
