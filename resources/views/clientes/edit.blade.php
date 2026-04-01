@extends('layouts.panel')

@section('title', 'Editar Cliente')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('clientes.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900">Editar Cliente</h1>
        <p class="text-slate-500 text-sm">{{ $cliente->nombre }} {{ $cliente->apellido }}</p>
    </div>
</div>

<form action="{{ route('clientes.update', $cliente) }}" method="POST" class="space-y-6 max-w-6xl">
    @csrf
    @method('PUT')

    {{-- Datos Personales --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Datos Personales</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-5">
            <x-field label="Nombres" name="nombre" :value="old('nombre', $cliente->nombre)" />
            <x-field label="Apellidos" name="apellido" :value="old('apellido', $cliente->apellido)" />
        </div>
    </div>

    {{-- Identificación --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Identificación</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tipo de Documento</label>
                <select name="tipo_doc" class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" style="border-radius:0">
                    <option value="DNI" {{ old('tipo_doc', $cliente->tipo_doc) == 'DNI' ? 'selected' : '' }}>DNI</option>
                    <option value="RUC" {{ old('tipo_doc', $cliente->tipo_doc) == 'RUC' ? 'selected' : '' }}>RUC</option>
                    <option value="CARNET DE EXTRANJERÍA" {{ old('tipo_doc', $cliente->tipo_doc) == 'CARNET DE EXTRANJERÍA' ? 'selected' : '' }}>CARNET DE EXTRANJERÍA</option>
                </select>
            </div>
            <x-field label="Número de Documento" name="nro_doc" :value="old('nro_doc', $cliente->nro_doc)" />
        </div>
    </div>

    {{-- Contacto --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Contacto</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <x-field label="Teléfono Principal" name="nro_tel_princ" :value="old('nro_tel_princ', $cliente->nro_tel_princ)" />
            <x-field label="Teléfono Secundario" name="nro_tel_sec" :value="old('nro_tel_sec', $cliente->nro_tel_sec)" :required="false" />
            <x-field label="Email" name="email" type="email" :value="old('email', $cliente->email)" :required="false" />
        </div>
    </div>

    {{-- Otros --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Información Adicional</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Estado</label>
                <select name="estado" class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" style="border-radius:0">
                    <option value="ACTIVO" {{ old('estado', $cliente->estado) == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                    <option value="INACTIVO" {{ old('estado', $cliente->estado) == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                </select>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-colors">
            Actualizar Cliente
        </button>
        <a href="{{ route('clientes.index') }}" class="px-5 py-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
            Cancelar
        </a>
    </div>
</form>
@endsection
