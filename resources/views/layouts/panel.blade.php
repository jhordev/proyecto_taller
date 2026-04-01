<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') | Mi Proyecto</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,100%,98%,1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, hsla(225,100%,97%,1) 0, transparent 50%);
            background-attachment: fixed;
        }
        .premium-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px -10px rgba(0, 0, 0, 0.05);
        }
    </style>
    @yield('styles')
</head>
<body class="h-full mesh-gradient text-slate-800 antialiased">
    <!-- Header -->
    <header class="premium-header sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-18 py-4">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold text-slate-900 tracking-tight">MiProyecto</span>
                </div>

                <!-- User Navigation -->
                <div class="flex items-center gap-8">
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</span>
                        <span class="text-xs font-medium text-slate-500">{{ Auth::user()->email }}</span>
                    </div>
                    
                    <div class="h-10 w-px bg-slate-200 hidden sm:block"></div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="group flex items-center gap-2.5 px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-red-50 text-slate-700 hover:text-red-600 border border-transparent hover:border-red-100 transition-all duration-300">
                            <span class="text-sm font-bold transition-colors">Salir</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-slate-500 group-hover:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
