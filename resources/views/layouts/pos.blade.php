<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS') | Mi Proyecto</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; background: #f1f5f9; }
        [x-cloak] { display: none !important; }
    </style>
    @yield('styles')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body style="height:100vh; overflow:hidden; display:flex; flex-direction:column; color:#1e293b; -webkit-font-smoothing:antialiased;">

    <!-- Header mínimo -->
    <header style="height:42px; min-height:42px; background:#1e293b; display:flex; align-items:center; justify-content:space-between; padding:0 16px; flex-shrink:0;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:24px; height:24px; background:#6366f1; display:flex; align-items:center; justify-content:center;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;color:#fff;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span style="font-size:13px; font-weight:800; color:#fff; letter-spacing:0.03em;">PUNTO DE VENTA</span>
        </div>
        <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; gap:6px; font-size:11px; font-weight:600; color:#94a3b8; text-decoration:none; padding:5px 12px; border:1px solid #334155; transition:all 0.2s;"
           onmouseover="this.style.color='#fff';this.style.borderColor='#6366f1';this.style.background='#6366f1';"
           onmouseout="this.style.color='#94a3b8';this.style.borderColor='#334155';this.style.background='transparent';">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:13px;height:13px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Ir al Panel
        </a>
    </header>

    <!-- Contenido principal: ocupa todo el resto -->
    <main style="flex:1; display:flex; overflow:hidden;">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
