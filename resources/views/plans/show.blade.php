<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Plano: {{ $plan->name }}
            </h2>
            <button onclick="document.getElementById('new-discipline-modal').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Adicionar Disciplina
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                    <div>
                        <span class="text-gray-500 text-sm block">Objetivo</span>
                        <span class="font-bold">{{ $plan->target_exam ?? 'Não definido' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm block">Data da Prova</span>
                        <span class="font-bold">{{ $plan->exam_date ? $plan->exam_date->format('d/m/Y') : 'Não definida' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 text-sm block">Disciplinas</span>
                        <span class="font-bold">{{ $plan->disciplines->count() }}</span>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-bold mb-4">Disciplinas do Plano</h3>
            
            @if($plan->disciplines->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <p class="text-gray-500">Nenhuma disciplina adicionada a este plano.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($plan->disciplines as $discipline)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex justify-between items-center">
                            <div>
                                <h4 class="text-lg font-bold">{{ $discipline->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $discipline->topics->count() }} tópicos cadastrados</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('disciplines.show', $discipline) }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200 text-sm">Edital Verticalizado</a>
                                <form action="{{ route('disciplines.destroy', $discipline) }}" method="POST" onsubmit="return confirm('Excluir disciplina?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Nova Disciplina -->
    <div id="new-discipline-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">Adicionar Disciplina</h3>
                <form action="{{ route('disciplines.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nome da Disciplina (ex: Direito Constitucional)</label>
                        <input type="text" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <button type="button" onclick="document.getElementById('new-discipline-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">Cancelar</button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
