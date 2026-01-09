<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $discipline->name }} - Edital Verticalizado
            </h2>
            <button onclick="document.getElementById('new-topic-modal').classList.remove('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Adicionar Tópico
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tópico</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estudado</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Revisão 1x</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Revisão 2x</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($discipline->topics as $topic)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $topic->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 rounded text-xs {{ $topic->is_studied ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $topic->is_studied ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 rounded text-xs {{ $topic->is_revised_1x ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $topic->is_revised_1x ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 py-1 rounded text-xs {{ $topic->is_revised_2x ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $topic->is_revised_2x ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="openStudyModal({{ $topic->id }}, '{{ $topic->name }}')" class="text-indigo-600 hover:text-indigo-900">Registrar Estudo</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhum tópico cadastrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Novo Tópico -->
    <div id="new-topic-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">Novo Tópico</h3>
                <form action="{{ route('topics.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="discipline_id" value="{{ $discipline->id }}">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nome do Tópico</label>
                        <input type="text" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <button type="button" onclick="document.getElementById('new-topic-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">Cancelar</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Registro de Estudo -->
    <div id="study-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center" id="modal-topic-name">Registrar Estudo</h3>
                <form action="{{ route('study-logs.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="topic_id" id="modal-topic-id">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo</label>
                            <select name="type" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                                <option value="teoria">Teoria</option>
                                <option value="questoes">Questões</option>
                                <option value="videoaula">Videoaula</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Duração (minutos)</label>
                            <input type="number" name="duration_minutes" required class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Acertos</label>
                            <input type="number" name="questions_correct" value="0" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Total Questões</label>
                            <input type="number" name="questions_total" value="0" class="shadow border rounded w-full py-2 px-3 text-gray-700">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Comentários</label>
                        <textarea name="comments" class="shadow border rounded w-full py-2 px-3 text-gray-700"></textarea>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="button" onclick="document.getElementById('study-modal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">Cancelar</button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Salvar Estudo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openStudyModal(id, name) {
            document.getElementById('modal-topic-id').value = id;
            document.getElementById('modal-topic-name').innerText = 'Registrar Estudo: ' + name;
            document.getElementById('study-modal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
