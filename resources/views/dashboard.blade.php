<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Tempo Total de Estudo</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ floor($totalStudyTime / 60) }}h {{ $totalStudyTime % 60 }}min</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Questões Resolvidas</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalQuestions }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-sm font-medium text-gray-500 uppercase">Precisão Média</div>
                    <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $accuracy }}%</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Revisões de Hoje -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Revisões para Hoje</h3>
                    @if($pendingRevisions->isEmpty())
                        <p class="text-gray-500">Nenhuma revisão pendente para hoje.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach($pendingRevisions as $revision)
                                <li class="py-3 flex justify-between items-center">
                                    <div>
                                        <span class="font-medium">{{ $revision->topic->name }}</span>
                                        <span class="text-xs text-gray-500 block">{{ $revision->topic->discipline->name }}</span>
                                    </div>
                                    <a href="{{ route('revisions.index') }}" class="text-blue-600 hover:underline text-sm">Ver</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Atividades Recentes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold mb-4">Atividades Recentes</h3>
                    @if($recentLogs->isEmpty())
                        <p class="text-gray-500">Nenhum registro de estudo encontrado.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach($recentLogs as $log)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <span class="font-medium">{{ $log->topic->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $log->studied_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $log->topic->discipline->name }} • {{ $log->duration_minutes }} min • {{ ucfirst($log->type) }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
