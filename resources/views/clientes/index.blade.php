@extends('layouts.panel')

@section('title', 'Clientes')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Clientes</h1>
        <p class="text-slate-500 text-sm">Gestión de la base de clientes del sistema.</p>
    </div>
    <a href="{{ route('clientes.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Cliente
    </a>
</div>

{{-- Search and Filter Bar --}}
<form action="{{ route('clientes.index') }}" method="GET" class="flex items-center gap-2 mb-5">
    <div class="relative flex-1">
        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Buscar por Nombre, Apellido o Número de Documento..."
            class="w-full border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            style="border-radius:0; padding: 10px 40px 10px 38px;"
        >
        <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); pointer-events:none; color:#94a3b8; display:flex; align-items:center;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>
        @if($search || request('estado'))
            <a href="{{ route('clientes.index') }}" title="Limpiar" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#94a3b8; display:flex; align-items:center;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        @endif
    </div>
    <select 
        name="estado" 
        onchange="this.form.submit()"
        class="w-48 border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
        style="border-radius:0; padding: 10px 12px;"
    >
        <option value="">TODOS LOS ESTADOS</option>
        <option value="ACTIVO" {{ request('estado') === 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
        <option value="INACTIVO" {{ request('estado') === 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
    </select>
</form>

@if(session('success'))
    <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-300 text-emerald-700 text-sm font-semibold">
        {{ session('success') }}
    </div>
@endif

{{-- Confirm Dialog --}}
<x-confirm-dialog
    id="dialog-eliminar-cliente"
    title="Eliminar cliente"
    message="¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer."
    confirmText="Sí, eliminar"
    cancelText="Cancelar"
/>

@if($clientes->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($clientes as $cliente)
            <div class="bg-white border border-slate-200 p-5 hover:border-indigo-400 transition-colors">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="min-w-0">
                        <h3 class="text-base font-bold text-slate-900 truncate" title="{{ $cliente->nombre }} {{ $cliente->apellido }}">
                            {{ $cliente->nombre }} {{ $cliente->apellido }}
                        </h3>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wide">{{ $cliente->tipo_doc }}: {{ $cliente->nro_doc }}</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-bold {{ $cliente->estado === 'ACTIVO' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $cliente->estado }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <a href="{{ route('clientes.edit', $cliente) }}" class="p-1.5 text-slate-400 hover:text-amber-500 transition-colors" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        <form id="form-delete-{{ $cliente->id }}" action="{{ route('clientes.destroy', $cliente) }}" method="POST" style="display:none">
                            @csrf
                            @method('DELETE')
                        </form>

                        <button
                            type="button"
                            onclick="openConfirmDialog('dialog-eliminar-cliente', document.getElementById('form-delete-{{ $cliente->id }}'))"
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
                        <span class="font-medium text-slate-400 w-24 shrink-0">Tel. Principal</span>
                        <span class="truncate text-slate-700">{{ $cliente->nro_tel_princ ?? '—' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-slate-400 w-24 shrink-0">Tel. Secundario</span>
                        <span class="text-slate-700">{{ $cliente->nro_tel_sec ?? '—' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-slate-400 w-24 shrink-0">Email</span>
                        <span class="truncate text-slate-700">{{ $cliente->email ?? '—' }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $clientes->links() }}
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
                Sin clientes registrados
            @endif
        </h2>
        <p class="text-slate-400 text-sm mb-6">
            @if($search)
                Intenta con otros términos o limpia la búsqueda.
            @else
                Agrega tu primer cliente para comenzar.
            @endif
        </p>
        @if($search)
            <a href="{{ route('clientes.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
                Limpiar Búsqueda
            </a>
        @else
            <a href="{{ route('clientes.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
                Registrar Cliente
            </a>
        @endif
    </div>
@endif
@endsection
