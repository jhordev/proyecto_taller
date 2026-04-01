@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
<div class="animate-in">
    <!-- Welcome Section -->
    <div class="relative overflow-hidden bg-white border border-slate-200 rounded-[2.5rem] p-10 lg:p-14 shadow-2xl shadow-indigo-100/50">
        <!-- Decoration Accents -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-purple-50 rounded-full blur-3xl opacity-60"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-center gap-12">
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-indigo-600 text-white text-[0.65rem] font-bold uppercase tracking-[0.1em] mb-8 shadow-lg shadow-indigo-200">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                    </span>
                    Sistema en Línea
                </div>
                
                <h1 class="text-4xl lg:text-7xl font-black text-slate-900 mb-6 leading-[1.1] tracking-tight">
                    Hola de nuevo, <br/>
                    <span class="text-indigo-600 italic">
                        {{ Auth::user()->name }}
                    </span>
                </h1>
                
                <p class="text-xl text-slate-500 max-w-xl mb-10 leading-relaxed font-medium">
                    Estamos listos para continuar. Tu panel administrativo está actualizado con las últimas estadísticas y funciones.
                </p>

                <div class="flex flex-wrap gap-5 justify-center lg:justify-start">
                    <a href="#" class="px-10 py-5 rounded-2xl bg-indigo-600 hover:bg-slate-900 text-white font-bold transition-all duration-300 shadow-xl shadow-indigo-200 hover:shadow-slate-300 active:scale-95">
                        Explorar Funciones
                    </a>
                    <a href="#" class="px-10 py-5 rounded-2xl bg-white hover:bg-slate-50 border-2 border-slate-200 text-slate-900 font-bold transition-all duration-300 active:scale-95">
                        Ver Reportes
                    </a>
                </div>
            </div>

            <!-- Dashboard Quick Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 w-full lg:w-[420px]">
                <div class="group p-8 rounded-[2rem] bg-white border-2 border-slate-100 hover:border-indigo-600 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-indigo-100 cursor-default">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-3xl font-black text-slate-900 mb-1">42.5h</div>
                    <div class="text-sm font-bold text-slate-400 uppercase tracking-wider">Actividad Total</div>
                </div>

                <div class="group p-8 rounded-[2rem] bg-white border-2 border-slate-100 hover:border-purple-600 transition-all duration-300 shadow-sm hover:shadow-xl hover:shadow-purple-100 cursor-default">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-3xl font-black text-slate-900 mb-1">128</div>
                    <div class="text-sm font-bold text-slate-400 uppercase tracking-wider">Proyectos</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .animate-in {
        animation: premiumIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes premiumIn {
        from { opacity: 0; transform: translateY(30px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>
@endsection
