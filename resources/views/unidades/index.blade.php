@extends('layouts.panel')

@section('title', 'Unidades de Medida')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Unidades de Medida</h1>
        <p class="text-slate-500 text-sm">Gestión de unidades para cuantificar los productos del almacén.</p>
    </div>
    <a href="{{ route('unidades.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Nueva Unidad
    </a>
</div>

{{-- Barra de búsqueda + Filtro Estado en línea --}}
<form action="{{ route('unidades.index') }}" method="GET" class="flex gap-3 mb-5">
    <div class="relative flex-1">
        <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); pointer-events:none; color:#94a3b8; display:flex; align-items:center;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        <input
            type="text"
            name="buscar"
            value="{{ request('buscar') }}"
            placeholder="Buscar por nombre o abreviatura..."
            class="w-full border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            style="border-radius:0; padding: 10px 38px 10px 38px;"
        >
        @if(request('buscar'))
            <a href="{{ route('unidades.index', array_filter(['estado' => request('estado')])) }}" title="Limpiar" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:#94a3b8; display:flex; align-items:center;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        @endif
    </div>
    <select name="estado" onchange="this.form.submit()"
        class="border border-slate-300 bg-white text-sm text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
        style="border-radius:0; padding: 10px 14px; min-width:160px;">
        <option value="">Todos los estados</option>
        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>ACTIVO</option>
        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>INACTIVO</option>
    </select>
</form>

@if(session('success'))
    <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-300 text-emerald-700 text-sm font-semibold">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-5 px-4 py-3 bg-red-50 border border-red-300 text-red-700 text-sm font-semibold">
        {{ session('error') }}
    </div>
@endif

{{-- Confirm Dialog --}}
<x-confirm-dialog
    id="dialog-eliminar-unidad"
    title="Eliminar unidad de medida"
    message="¿Estás seguro de que deseas eliminar esta unidad? Si tiene productos asociados, la operación será rechazada."
    confirmText="Sí, eliminar"
    cancelText="Cancelar"
/>

@if($unidades->count() > 0)
    <div class="bg-white border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Unidad de Medida</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Abreviatura</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Estado</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px] text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unidades as $unidad)
                    <tr class="border-b border-slate-100 hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-3">
                            <span class="font-semibold text-slate-900">{{ $unidad->nombre }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 font-bold text-xs">{{ $unidad->abreviatura }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="px-2 py-0.5 text-[10px] font-bold {{ $unidad->estado === 'activo' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ strtoupper($unidad->estado) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('unidades.edit', $unidad->id_unidad) }}" class="p-1.5 text-slate-400 hover:text-amber-500 transition-colors" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form id="form-delete-unidad-{{ $unidad->id_unidad }}" action="{{ route('unidades.destroy', $unidad->id_unidad) }}" method="POST" style="display:none">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button
                                    type="button"
                                    onclick="openConfirmDialog('dialog-eliminar-unidad', document.getElementById('form-delete-unidad-{{ $unidad->id_unidad }}'))"
                                    class="p-1.5 text-slate-400 hover:text-red-500 transition-colors"
                                    title="Eliminar"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $unidades->links() }}
    </div>
@else
    <div class="bg-white border border-slate-200 p-16 text-center">
        <div class="w-12 h-12 bg-slate-100 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-slate-900 mb-1">Sin unidades registradas</h2>
        <p class="text-slate-400 text-sm mb-6">Agrega unidades de medida para cuantificar tus productos.</p>
        <a href="{{ route('unidades.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
            Nueva Unidad
        </a>
    </div>
@endif
@endsection
