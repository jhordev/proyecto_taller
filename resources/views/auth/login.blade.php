<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Mi Proyecto</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,100%,98%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,100%,97%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,100%,97%,1) 0, transparent 50%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }
        .input-premium {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-premium:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            outline: none;
        }
        .btn-premium {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            transition: all 0.3s ease;
        }
        .btn-premium:hover {
            transform: translateY(-1px);
            box-shadow: 0 12px 20px -5px rgba(79, 70, 229, 0.3);
            filter: brightness(1.05);
        }
        .animate-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="h-full mesh-gradient flex items-center justify-center p-6 overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-[5%] left-[5%] w-72 h-72 bg-indigo-200/30 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[5%] right-[5%] w-96 h-96 bg-purple-200/30 rounded-full blur-3xl"></div>

    <div class="w-full max-w-md animate-in">
        <div class="mb-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 shadow-xl shadow-indigo-200 mb-6 transition-transform hover:scale-105 duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Bienvenido de nuevo</h1>
            <p class="text-slate-500 mt-2 font-medium">Ingresa tus credenciales para acceder</p>
        </div>

        <div class="glass-card rounded-[2rem] p-10">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                        class="w-full px-4 py-3.5 rounded-xl text-slate-900 input-premium placeholder-slate-400 @error('email') border-red-300 bg-red-50/30 @enderror" 
                        placeholder="tu@correo.com">
                    @error('email')
                        <p class="text-xs text-red-500 font-medium mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2 ml-1">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Contraseña</label>
                        <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors">¿La olvidaste?</a>
                    </div>
                    <input type="password" id="password" name="password" required 
                        class="w-full px-4 py-3.5 rounded-xl text-slate-900 input-premium placeholder-slate-400 @error('password') border-red-300 bg-red-50/30 @enderror" 
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-xs text-red-500 font-medium mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center ml-1">
                    <input type="checkbox" id="remember" name="remember" 
                        class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="remember" class="ml-2 block text-sm font-medium text-slate-600">Mantenerme conectado</label>
                </div>

                <button type="submit" 
                    class="w-full py-4 px-4 rounded-xl text-white font-bold text-sm btn-premium shadow-lg shadow-indigo-200">
                    Iniciar Sesión
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-500 font-medium">
                    ¿No tienes una cuenta? 
                    <a href="#" class="font-bold text-indigo-600 hover:text-indigo-700 transition-colors">Regístrate gratis</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
