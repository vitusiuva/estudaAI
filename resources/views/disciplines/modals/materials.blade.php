<div id="material-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="this.parentElement.parentElement.classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4" id="material-topic-name">Materiais</h3>
                
                {{-- Formulário para novo material --}}
                <form action="{{ route('materials.store') }}" method="POST" class="mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                    @csrf
                    <input type="hidden" name="topic_id" id="material-topic-id">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Tipo</label>
                            <select name="type" required class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                                <option value="Link">Link</option>
                                <option value="PDF">PDF</option>
                                <option value="Video">Vídeo</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">URL</label>
                            <input type="url" name="url" required placeholder="https://..." class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase mb-1">Descrição</label>
                            <input type="text" name="description" placeholder="Ex: PDF da aula 01, Link do YouTube..." class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm">
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition-all">Adicionar Material</button>
                    </div>
                </form>

                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="document.getElementById('material-modal').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-all">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>
