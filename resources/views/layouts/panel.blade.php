<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') | Mi Proyecto</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; }
    </style>
    @yield('styles')
</head>
<body class="h-full text-slate-800 antialiased">
    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-14">
                <!-- Logo + Nav -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-indigo-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-slate-900">MiProyecto</span>
                    </a>

                    <nav class="flex items-center gap-6">
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold pb-0.5 {{ request()->routeIs('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-900 border-b-2 border-transparent' }} transition-colors">
                            Inicio
                        </a>
                        <a href="{{ route('empleados.index') }}" class="text-sm font-semibold pb-0.5 {{ request()->routeIs('empleados.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-900 border-b-2 border-transparent' }} transition-colors">
                            Empleados
                        </a>
                    </nav>
                </div>

                <!-- User + Logout -->
                <div class="flex items-center gap-5">
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-sm font-semibold text-slate-900 leading-tight">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-slate-400">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="w-px h-8 bg-slate-200"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-red-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
