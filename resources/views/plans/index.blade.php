<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Planos de Estudo') }}
            </h2>
            <button onclick="document.getElementById('new-plan-modal').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Criar Novo Plano
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($plans as $plan)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-indigo-500">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $plan->target_exam ?? 'Objetivo não definido' }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">{{ $plan->disciplines->count() }} Disciplinas</span>
                        <a href="{{ route('plans.show', $plan) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Ver Detalhes →</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Simples para Novo Plano -->
    <div id="new-plan-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Novo Plano de Estudo</h3>
                <form action="{{ route('plans.store') }}" method="POST" class="mt-4 text-left">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nome do Plano (ex: ENEM 2026)</label>
                        <input type="text" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Concurso/Exame Alvo</label>
                        <input type="text" name="target_exam" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <button type="button" onclick="document.getElementById('new-plan-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">Cancelar</button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Criar Plano</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
