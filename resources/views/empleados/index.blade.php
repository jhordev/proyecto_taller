@extends('layouts.panel')

@section('title', 'Empleados')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Empleados</h1>
        <p class="text-slate-500 text-sm">Listado de colaboradores registrados.</p>
    </div>
    <a href="{{ route('empleados.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Empleado
    </a>
</div>

@if(session('success'))
    <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-300 text-emerald-700 text-sm font-semibold">
        {{ session('success') }}
    </div>
@endif

{{-- Confirm Dialog --}}
<x-confirm-dialog
    id="dialog-eliminar"
    title="Eliminar empleado"
    message="¿Estás seguro de que deseas eliminar este empleado? Esta acción no se puede deshacer."
    confirmText="Sí, eliminar"
    cancelText="Cancelar"
/>

@if($empleados->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($empleados as $empleado)
            <div class="bg-white border border-slate-200 p-5 hover:border-indigo-400 transition-colors">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div class="min-w-0">
                        <h3 class="text-base font-bold text-slate-900 truncate">{{ $empleado->nombre }} {{ $empleado->apellido }}</h3>
                        <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wide">{{ $empleado->cargo }}</span>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <a href="{{ route('empleados.edit', $empleado) }}" class="p-1.5 text-slate-400 hover:text-amber-500 transition-colors" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        {{-- Hidden delete form --}}
                        <form id="form-delete-{{ $empleado->id }}" action="{{ route('empleados.destroy', $empleado) }}" method="POST" style="display:none">
                            @csrf
                            @method('DELETE')
                        </form>

                        <button
                            type="button"
                            onclick="openConfirmDialog('dialog-eliminar', document.getElementById('form-delete-{{ $empleado->id }}'))"
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
                        <span class="font-medium text-slate-400 w-16 shrink-0">Email</span>
                        <span class="truncate">{{ $empleado->email ?? '—' }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-slate-400 w-16 shrink-0">Teléfono</span>
                        <span>{{ $empleado->nro_tel_princ }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="font-medium text-slate-400 w-16 shrink-0">Doc.</span>
                        <span>{{ $empleado->tipo_doc }} {{ $empleado->nro_doc }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $empleados->links() }}
    </div>
@else
    <div class="bg-white border border-slate-200 p-16 text-center">
        <div class="w-12 h-12 bg-slate-100 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-slate-900 mb-1">Sin empleados registrados</h2>
        <p class="text-slate-400 text-sm mb-6">Agrega el primero para comenzar.</p>
        <a href="{{ route('empleados.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
            Registrar Empleado
        </a>
    </div>
@endif
@endsection
