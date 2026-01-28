<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex items-center">
                <a href="{{ route('plans.show', $discipline->plan) }}" class="mr-4 p-2 rounded-full bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $discipline->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Edital Verticalizado</p>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button onclick="openNewTopicModal()" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Novo Tópico
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tópico / Assunto</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Concluído</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estudado</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Revisões</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($discipline->topics->where('parent_id', null) as $topic)
                            {{-- Tópico Principal --}}
                            <tr class="bg-gray-50/50 dark:bg-gray-900/20">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $topic->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('topics.toggle-complete', $topic) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="focus:outline-none">
                                            <div class="w-6 h-6 rounded border-2 {{ $topic->is_completed ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 dark:border-gray-600' }} flex items-center justify-center transition-all">
                                                @if($topic->is_completed)
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                @endif
                                            </div>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($topic->is_studied)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Sim</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400">Não</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-1">
                                        <div class="w-5 h-5 rounded-full border {{ $topic->is_revised_1x ? 'bg-indigo-500 border-indigo-500' : 'border-gray-300 dark:border-gray-600' }}"></div>
                                        <div class="w-5 h-5 rounded-full border {{ $topic->is_revised_2x ? 'bg-indigo-500 border-indigo-500' : 'border-gray-300 dark:border-gray-600' }}"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <button onclick="openNewTopicModal({{ $topic->id }})" class="text-gray-400 hover:text-indigo-600" title="Adicionar Subtópico">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                                        </button>
                                        <button onclick="openStudyModal({{ $topic->id }}, '{{ $topic->name }}')" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 font-bold">Estudar</button>
                                        <button onclick="openMaterialModal({{ $topic->id }}, '{{ $topic->name }}')" class="text-gray-400 hover:text-amber-500" title="Materiais">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Subtópicos --}}
                            @foreach($topic->subtopics as $subtopic)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap pl-12">
                                    <div class="flex items-center">
                                        <div class="text-sm text-gray-600 dark:text-gray-300">{{ $subtopic->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <form action="{{ route('topics.toggle-complete', $subtopic) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="focus:outline-none">
                                            <div class="w-5 h-5 rounded border {{ $subtopic->is_completed ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 dark:border-gray-600' }} flex items-center justify-center transition-all">
                                                @if($subtopic->is_completed)
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                @endif
                                            </div>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($subtopic->is_studied)
                                        <span class="text-xs font-medium text-green-600 dark:text-green-400">Sim</span>
                                    @else
                                        <span class="text-xs font-medium text-gray-400">Não</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-1">
                                        <div class="w-4 h-4 rounded-full border {{ $subtopic->is_revised_1x ? 'bg-indigo-400 border-indigo-400' : 'border-gray-200 dark:border-gray-700' }}"></div>
                                        <div class="w-4 h-4 rounded-full border {{ $subtopic->is_revised_2x ? 'bg-indigo-400 border-indigo-400' : 'border-gray-200 dark:border-gray-700' }}"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <button onclick="openStudyModal({{ $subtopic->id }}, '{{ $subtopic->name }}')" class="text-indigo-500 hover:text-indigo-700">Estudar</button>
                                        <button onclick="openMaterialModal({{ $subtopic->id }}, '{{ $subtopic->name }}')" class="text-gray-400 hover:text-amber-500">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <p class="text-gray-500 dark:text-gray-400">Nenhum tópico cadastrado.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modais --}}
    @include('disciplines.modals.new-topic')
    @include('disciplines.modals.study-log')
    @include('disciplines.modals.materials')

    @push('scripts')
    <script>
        function openNewTopicModal(parentId = null) {
            document.getElementById('parent_id').value = parentId;
            document.getElementById('new-topic-modal').classList.remove('hidden');
        }
        function openStudyModal(id, name) {
            document.getElementById('modal-topic-id').value = id;
            document.getElementById('modal-topic-name').innerText = 'Registrar Estudo: ' + name;
            document.getElementById('study-modal').classList.remove('hidden');
        }
        function openMaterialModal(id, name) {
            document.getElementById('material-topic-id').value = id;
            document.getElementById('material-topic-name').innerText = 'Materiais: ' + name;
            document.getElementById('material-modal').classList.remove('hidden');
        }
    </script>
    @endpush
</x-app-layout>
