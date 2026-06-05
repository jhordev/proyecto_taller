@extends('layouts.panel')

@section('title', 'Editar Proveedor')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('proveedores.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900">Editar Proveedor</h1>
        <p class="text-slate-500 text-sm">{{ $proveedor->razon_social }}</p>
    </div>
</div>

<form action="{{ route('proveedores.update', $proveedor) }}" method="POST" class="space-y-6 max-w-6xl">
    @csrf
    @method('PUT')

    {{-- Datos Generales --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Datos Generales</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <x-field label="RUC" name="ruc" :value="old('ruc', $proveedor->ruc)" placeholder="11 dígitos" />
            <x-field label="Razón Social" name="razon_social" class="md:col-span-2" :value="old('razon_social', $proveedor->razon_social)" />
            <x-field label="Nombre Comercial" name="nombre_comercial" class="md:col-span-2" :value="old('nombre_comercial', $proveedor->nombre_comercial)" :required="false" />
        </div>
    </div>

    {{-- Contacto --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Contacto</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <x-field label="Persona de Contacto" name="contacto" class="md:col-span-1" :value="old('contacto', $proveedor->contacto)" :required="false" />
            <x-field label="Teléfono" name="telefono" :value="old('telefono', $proveedor->telefono)" :required="false" />
            <x-field label="Celular" name="celular" :value="old('celular', $proveedor->celular)" :required="false" />
            <x-field label="Email" name="email" type="email" class="md:col-span-2" :value="old('email', $proveedor->email)" :required="false" />
        </div>
    </div>

    {{-- Ubicación --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Ubicación y Dirección</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <x-field label="Dirección" name="direccion" class="md:col-span-3" :value="old('direccion', $proveedor->direccion)" :required="false" />
            <x-field label="Departamento" name="departamento" :value="old('departamento', $proveedor->departamento)" :required="false" />
            <x-field label="Provincia" name="provincia" :value="old('provincia', $proveedor->provincia)" :required="false" />
            <x-field label="Distrito" name="distrito" :value="old('distrito', $proveedor->distrito)" :required="false" />
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
                    <option value="ACTIVO" {{ old('estado', $proveedor->estado) == 'ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                    <option value="INACTIVO" {{ old('estado', $proveedor->estado) == 'INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Observaciones</label>
                <textarea name="observaciones" rows="1" class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" style="border-radius:0">{{ old('observaciones', $proveedor->observaciones) }}</textarea>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-colors">
            Actualizar Proveedor
        </button>
        <a href="{{ route('proveedores.index') }}" class="px-5 py-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
            Cancelar
        </a>
    </div>
</form>
@endsection
