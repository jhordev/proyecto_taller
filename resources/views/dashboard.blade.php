@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-900">Dashboard</h1>
    <p class="text-slate-500 text-sm">Resumen del sistema.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="bg-white border border-slate-200 p-6">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Actividad Total</div>
        <div class="text-3xl font-bold text-slate-900">42.5h</div>
        <div class="text-xs text-slate-400 mt-1">Este mes</div>
    </div>
    <div class="bg-white border border-slate-200 p-6">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Proyectos</div>
        <div class="text-3xl font-bold text-slate-900">128</div>
        <div class="text-xs text-slate-400 mt-1">Total registrados</div>
    </div>
    <div class="bg-white border border-slate-200 p-6">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Sesión</div>
        <div class="text-base font-bold text-slate-900">{{ Auth::user()->name }}</div>
        <div class="text-xs text-slate-400 mt-1">{{ Auth::user()->email }}</div>
    </div>
</div>
@endsection
