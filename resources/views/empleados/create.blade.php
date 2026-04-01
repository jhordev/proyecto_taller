@extends('layouts.panel')

@section('title', 'Nuevo Empleado')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('empleados.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900">Nuevo Empleado</h1>
        <p class="text-slate-500 text-sm">Completa todos los campos requeridos.</p>
    </div>
</div>

<form action="{{ route('empleados.store') }}" method="POST" class="space-y-6 max-w-6xl">
    @csrf

    {{-- Personal --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Información Personal</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <x-field label="Nombre" name="nombre" />
            <x-field label="Apellido" name="apellido" />
            <x-field label="Fecha de Nacimiento" name="fecha_nac" type="date" />
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Tipo de Documento</label>
                <select name="tipo_doc" class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" style="border-radius:0">
                    <option value="DNI" {{ old('tipo_doc') == 'DNI' ? 'selected' : '' }}>DNI</option>
                    <option value="Pasaporte" {{ old('tipo_doc') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                    <option value="Cédula" {{ old('tipo_doc') == 'Cédula' ? 'selected' : '' }}>Cédula</option>
                </select>
                @error('tipo_doc')<p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p>@enderror
            </div>
            <x-field label="Nro. Documento" name="nro_doc" />
        </div>
    </div>

    {{-- Laboral --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Información Laboral</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <x-field label="Cargo / Puesto" name="cargo" />
            <x-field label="Fecha de Ingreso" name="fecha_ingreso" type="date" />
            <x-field label="Salario Anual" name="salario_anual" type="number" placeholder="0.00" />
        </div>
    </div>

    {{-- Contacto --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Contacto y Dirección</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <x-field label="Dirección" name="direccion" class="md:col-span-2" />
            <x-field label="Teléfono Principal" name="nro_tel_princ" />
            <x-field label="Teléfono Secundario" name="nro_tel_sec" :required="false" />
            <x-field label="Correo Electrónico" name="email" type="email" class="md:col-span-2" :required="false" />
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-colors">
            Guardar Empleado
        </button>
        <a href="{{ route('empleados.index') }}" class="px-5 py-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
            Cancelar
        </a>
    </div>
</form>
@endsection
