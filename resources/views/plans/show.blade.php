<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $plan->name }}
            </h2>
            <button onclick="document.getElementById('new-discipline-modal').classList.remove('hidden')" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Adicionar Disciplina
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold">Disciplinas do Plano</h3>
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded">Progresso: 1%</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($plan->disciplines as $discipline)
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-800">{{ $discipline->name }}</h4>
                            <span class="text-xs text-gray-500">{{ $discipline->topics->count() }} tópicos</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                            <div class="bg-green-600 h-2.5 rounded-full" style="width: 0%"></div>
                        </div>
                        <a href="{{ route('disciplines.show', $discipline) }}" class="text-sm text-indigo-600 hover:underline">Gerenciar Tópicos</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nova Disciplina -->
    <div id="new-discipline-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Nova Disciplina</h3>
                <form action="{{ route('disciplines.store') }}" method="POST" class="mt-4 text-left">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nome da Disciplina</label>
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
