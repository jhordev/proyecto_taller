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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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

                        {{-- Dropdown: Personas --}}
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button" class="flex items-center gap-1 text-sm font-semibold pb-0.5 {{ request()->routeIs('empleados.*', 'proveedores.*', 'clientes.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-900 border-b-2 border-transparent' }} transition-colors">
                                Personas
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 top-full mt-0 w-44 bg-white border border-slate-200 shadow-lg z-50" style="border-radius:0" @click.away="open = false">
                                <a href="{{ route('empleados.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('empleados.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('empleados.*') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Empleados
                                </a>
                                <a href="{{ route('proveedores.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('proveedores.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('proveedores.*') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Proveedores
                                </a>
                                <a href="{{ route('clientes.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('clientes.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('clientes.*') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Clientes
                                </a>
                            </div>
                        </div>

                        {{-- Dropdown: Almacén --}}
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button" class="flex items-center gap-1 text-sm font-semibold pb-0.5 {{ request()->routeIs('productos.*', 'categorias.*', 'unidades.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-900 border-b-2 border-transparent' }} transition-colors">
                                Almacén
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 top-full mt-0 w-48 bg-white border border-slate-200 shadow-lg z-50" style="border-radius:0" @click.away="open = false">
                                <a href="{{ route('productos.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('productos.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('productos.*') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Productos
                                </a>
                                <a href="{{ route('categorias.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('categorias.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('categorias.*') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                                    Categorías
                                </a>
                                <a href="{{ route('unidades.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('unidades.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('unidades.*') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                    Unidades de Medida
                                </a>
                                <a href="{{ route('movimientos.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('movimientos.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('movimientos.*') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    Movimientos
                                </a>
                            </div>
                        </div>
                        {{-- Dropdown: Ventas --}}
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button type="button" class="flex items-center gap-1 text-sm font-semibold pb-0.5 {{ request()->routeIs('ventas.*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-slate-500 hover:text-slate-900 border-b-2 border-transparent' }} transition-colors">
                                Ventas
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute left-0 top-full mt-0 w-44 bg-white border border-slate-200 shadow-lg z-50" style="border-radius:0" @click.away="open = false">
                                <a href="{{ route('ventas.create') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('ventas.create') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('ventas.create') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Nueva Venta
                                </a>
                                <a href="{{ route('ventas.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm {{ request()->routeIs('ventas.index') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-slate-700 hover:bg-slate-50 font-medium' }} transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 {{ request()->routeIs('ventas.index') ? 'text-indigo-500' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    Historial
                                </a>
                            </div>
                        </div>
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
