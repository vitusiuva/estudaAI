<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'estudaAI') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="h-full font-sans antialiased text-gray-900 dark:text-gray-100">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex overflow-hidden">
            
            <!-- Sidebar para Mobile -->
            <div x-show="sidebarOpen" class="fixed inset-0 z-40 flex md:hidden" role="dialog" aria-modal="true">
                <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
                
                <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex flex-col flex-1 w-full max-w-xs bg-white dark:bg-gray-800">
                    <div class="absolute top-0 right-0 pt-2 -mr-12">
                        <button @click="sidebarOpen = false" class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Fechar menu</span>
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                        <div class="flex items-center flex-shrink-0 px-4">
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">estudaAI</span>
                        </div>
                        <nav class="px-2 mt-5 space-y-1">
                            @include('layouts.sidebar-links')
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Sidebar Estática para Desktop -->
            <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0 border-r border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                <div class="flex flex-col flex-1 min-h-0">
                    <div class="flex items-center h-16 flex-shrink-0 px-6 border-b border-gray-200 dark:border-gray-700">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">estudaAI</span>
                    </div>
                    <div class="flex flex-col flex-1 overflow-y-auto">
                        <nav class="flex-1 px-4 py-4 space-y-2">
                            @include('layouts.sidebar-links')
                        </nav>
                        <!-- User Profile Mini -->
                        <div class="flex-shrink-0 flex border-t border-gray-200 dark:border-gray-700 p-4">
                            <div class="flex-shrink-0 w-full group block">
                                <div class="flex items-center">
                                    <div>
                                        <div class="h-9 w-9 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</p>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="text-xs font-medium text-gray-500 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300">Sair</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <div class="md:pl-64 flex flex-col flex-1 w-0 overflow-hidden">
                <div class="relative z-10 flex-shrink-0 flex h-16 bg-white dark:bg-gray-800 shadow md:hidden">
                    <button @click="sidebarOpen = true" class="px-4 border-r border-gray-200 dark:border-gray-700 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                        <span class="sr-only">Abrir menu</span>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>

                <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none">
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            @if (isset($header))
                                <header class="mb-8">
                                    {{ $header }}
                                </header>
                            @endif
                            
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Cronômetro Flutuante Moderno -->
        @include('components.timer-floating')

        @stack('scripts')
    </body>
</html>
