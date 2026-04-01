<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Mi Proyecto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f1f5f9; }
        .input-flat {
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 0;
            transition: border-color 0.2s;
        }
        .input-flat:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 2px rgba(79,70,229,0.15);
            outline: none;
        }
        .input-flat.is-invalid { border-color: #ef4444; }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-600 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Iniciar Sesión</h1>
            <p class="text-slate-500 text-sm mt-1">Ingresa tus credenciales para acceder</p>
        </div>

        <div class="bg-white border border-slate-200 p-8">
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="input-flat w-full px-3 py-2.5 text-sm text-slate-900 @error('email') is-invalid @enderror" placeholder="tu@correo.com" required>
                    @error('email')<p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <label class="block text-sm font-semibold text-slate-700">Contraseña</label>
                        <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">¿La olvidaste?</a>
                    </div>
                    <input type="password" name="password" class="input-flat w-full px-3 py-2.5 text-sm text-slate-900 @error('password') is-invalid @enderror" placeholder="••••••••" required>
                    @error('password')<p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 border border-slate-300 text-indigo-600">
                    <label for="remember" class="text-sm text-slate-600">Mantenerme conectado</label>
                </div>
                <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-colors">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</body>
</html>
