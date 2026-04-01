@extends('layouts.panel')

@section('title', 'Proveedores')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Proveedores</h1>
        <p class="text-slate-500 text-sm">Gestión de proveedores y socios comerciales.</p>
    </div>
    <a href="{{ route('proveedores.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Proveedor
    </a>
</div>

{{-- Full-width Search Bar --}}
<form action="{{ route('proveedores.index') }}" method="GET" style="position:relative; margin-bottom:20px;">
    <input
        type="text"
        name="search"
        value="{{ $search ?? '' }}"
        placeholder="Buscar por RUC, Razón Social o Persona de Contacto..."
        class="w-full border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
        style="border-radius:0; padding: 10px 40px 10px 38px;"
    >
    <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); pointer-events:none; color:#94a3b8; display:flex; align-items:center;">
        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </span>
    @if($search)
        <a href="{{ route('proveedores.index') }}" title="Limpiar" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#94a3b8; display:flex; align-items:center;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </a>
    @else
        <button type="submit" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#94a3b8; display:flex; align-items:center; padding:0;" onmouseover="this.style.color='#4f46e5'" onmouseout="this.style.color='#94a3b8'">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    @endif
</form>

@if(session('success'))
    <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-300 text-emerald-700 text-sm font-semibold">
        {{ session('success') }}
    </div>
@endif

{{-- Confirm Dialog --}}
<x-confirm-dialog
    id="dialog-eliminar-proveedor"
    title="Eliminar proveedor"
    message="¿Estás seguro de que deseas eliminar este proveedor? Esta acción no se puede deshacer."
    confirmText="Sí, eliminar"
    cancelText="Cancelar"
/>

@if($proveedores->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($proveedores as $proveedor)
            <div class="bg-white border border-slate-200 p-5 hover:border-indigo-400 transition-colors">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="min-w-0">
                        <h3 class="text-base font-bold text-slate-900 truncate" title="{{ $proveedor->razon_social }}">
                            {{ $proveedor->razon_social }}
                        </h3>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">RUC: {{ $proveedor->ruc }}</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold {{ $proveedor->estado === 'ACTIVO' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $proveedor->estado }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <a href="{{ route('proveedores.edit', $proveedor) }}" class="p-1.5 text-slate-400 hover:text-amber-500 transition-colors" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        <form id="form-delete-{{ $proveedor->id }}" action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" style="display:none">
                            @csrf
                            @method('DELETE')
                        </form>

                        <button
                            type="button"
                            onclick="openConfirmDialog('dialog-eliminar-proveedor', document.getElementById('form-delete-{{ $proveedor->id }}'))"
                            class="p-1.5 text-slate-400 hover:text-red-500 transition-colors"
                            title="Eliminar"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="space-y-1.5 pt-3 border-t border-slate-100 text-sm text-slate-500">
                    <div class="flex gap-2">
                        <span class="font-medium text-slate-400 w-16 shrink-0">Contacto</span>
                        <span class="truncate text-slate-700">{{ $proveedor->contacto ?? '—' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-slate-400 w-16 shrink-0">Celular</span>
                        <span class="text-slate-700">{{ $proveedor->celular ?? '—' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-slate-400 w-16 shrink-0">Email</span>
                        <span class="truncate text-slate-700">{{ $proveedor->email ?? '—' }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $proveedores->links() }}
    </div>
@else
    <div class="bg-white border border-slate-200 p-16 text-center">
        <div class="w-12 h-12 bg-slate-100 flex items-center justify-center mx-auto mb-4" style="border-radius:0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-slate-900 mb-1">
            @if($search)
                No hay resultados para "{{ $search }}"
            @else
                Sin proveedores registrados
            @endif
        </h2>
        <p class="text-slate-400 text-sm mb-6">
            @if($search)
                Intenta con otros términos o limpia la búsqueda.
            @else
                Agrega tu primer proveedor para comenzar.
            @endif
        </p>
        @if($search)
            <a href="{{ route('proveedores.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
                Limpiar Búsqueda
            </a>
        @else
            <a href="{{ route('proveedores.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
                Registrar Proveedor
            </a>
        @endif
    </div>
@endif
@endsection
