<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Sistema de Revisões</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gerencie suas revisões programadas (1, 7, 15, 30 e 60 dias).</p>
    </x-slot>

    <div class="py-6 space-y-6">
        {{-- Abas de Filtro --}}
        <div class="flex space-x-4 border-b border-gray-200 dark:border-gray-700">
            <button onclick="showTab(\'today\')" id="tab-today" class="px-4 py-2 text-sm font-bold border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400">Para Hoje ({{ $revisionsToday->count() }})</button>
            <button onclick="showTab(\'overdue\')" id="tab-overdue" class="px-4 py-2 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Atrasadas ({{ $revisionsOverdue->count() }})</button>
            <button onclick="showTab(\'completed\')" id="tab-completed" class="px-4 py-2 text-sm font-bold border-b-2 border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Concluídas</button>
        </div>

        {{-- Conteúdo das Abas --}}
        <div id="content-today" class="tab-content">
            @include(\'revisions.partials.list\', [\'revisions\' => $revisionsToday, \'emptyMessage\' => \'Nenhuma revisão para hoje. Bom trabalho!\'])
        </div>

        <div id="content-overdue" class="tab-content hidden">
            @include(\'revisions.partials.list\', [\'revisions\' => $revisionsOverdue, \'emptyMessage\' => \'Nenhuma revisão atrasada. Você está em dia!\'])
        </div>

        <div id="content-completed" class="tab-content hidden">
            @include(\'revisions.partials.list\', [\'revisions\' => $revisionsCompleted, \'isCompleted\' => true, \'emptyMessage\' => \'Nenhuma revisão concluída ainda.\'])
        </div>
    </div>

    @push(\'scripts\')
    <script>
        function showTab(tab) {
            document.querySelectorAll(\'.tab-content\').forEach(el => el.classList.add(\'hidden\'));
            document.getElementById(\'content-\' + tab).classList.remove(\'hidden\');
            
            document.querySelectorAll(\'[id^="tab-"]\').forEach(el => {
                el.classList.remove(\'border-indigo-500\', \'text-indigo-600\', \'dark:text-indigo-400\');
                el.classList.add(\'border-transparent\', \'text-gray-500\', \'dark:text-gray-400\');
            });
            
            const activeTab = document.getElementById(\'tab-\' + tab);
            activeTab.classList.remove(\'border-transparent\', \'text-gray-500\', \'dark:text-gray-400\');
            activeTab.classList.add(\'border-indigo-500\', \'text-indigo-600\', \'dark:text-indigo-400\');
        }
    </script>
    @endpush
</x-app-layout>
