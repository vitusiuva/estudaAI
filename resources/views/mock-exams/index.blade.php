<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Simulados</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Acompanhe seu desempenho em provas e simulados.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="document.getElementById('new-mock-modal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Novo Simulado
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($mockExams as $mock)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition-all group">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400">{{ \Carbon\Carbon::parse($mock->date)->format('d/m/Y') }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $mock->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $mock->exam_board ?? 'Banca não informada' }} • {{ $mock->exam_type ?? 'Tipo não informado' }}</p>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900/50 rounded-xl mb-6">
                        <div class="text-center">
                            <div class="text-xs font-bold text-gray-400 uppercase">Pontuação</div>
                            <div class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $mock->total_score ?? 0 }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs font-bold text-gray-400 uppercase">Disciplinas</div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $mock->results->count() }}</div>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <a href="{{ route('mock-exams.show', $mock) }}" class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white text-sm font-bold rounded-lg hover:bg-indigo-700 transition-all">Ver Detalhes</a>
                        <form action="{{ route('mock-exams.destroy', $mock) }}" method="POST" onsubmit="return confirm('Excluir simulado?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white dark:bg-gray-800 rounded-2xl p-12 text-center border border-gray-100 dark:border-gray-700">
                <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center text-gray-400 mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Nenhum simulado registrado</h3>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Registre seu primeiro simulado para começar a acompanhar sua evolução.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Modal Novo Simulado --}}
    <div id="new-mock-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="this.parentElement.parentElement.classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('mock-exams.store') }}" method="POST" class="p-6">
                    @csrf
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Novo Simulado</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título</label>
                            <input type="text" name="title" required placeholder="Ex: Simulado 01 - Receita Federal" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data</label>
                                <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Banca</label>
                                <input type="text" name="exam_board" placeholder="Ex: FGV, FCC, Cebraspe" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Prova</label>
                            <input type="text" name="exam_type" placeholder="Ex: Objetiva, Discursiva" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('new-mock-modal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-all">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all">Criar Simulado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
