@extends('layouts.panel')

@section('title', 'Nuevo Movimiento')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('movimientos.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900">Registrar Nuevo Movimiento</h1>
        <p class="text-slate-500 text-sm">Ingresa los datos para registrar un movimiento de inventario.</p>
    </div>
</div>

<form action="{{ route('movimientos.store') }}" method="POST" class="space-y-6 max-w-5xl">
    @csrf

    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Detalles del Movimiento</h2>
        </div>
        
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-5">
            {{-- Producto --}}
            <div>
                <label for="producto_id" class="block text-sm font-semibold text-slate-700 mb-1">Producto <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select name="producto_id" id="producto_id" required
                        class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('producto_id') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                        style="border-radius:0">
                        <option value="">Seleccione un producto...</option>
                        @foreach($productos as $prod)
                            <option value="{{ $prod->id_producto }}" {{ old('producto_id') == $prod->id_producto ? 'selected' : '' }}>
                                {{ $prod->nombre }} (Stock: {{ $prod->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('producto_id') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tipo de Movimiento --}}
            <div>
                <label for="tipo_movimiento" class="block text-sm font-semibold text-slate-700 mb-1">Tipo de Movimiento <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select name="tipo_movimiento" id="tipo_movimiento" required
                        class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('tipo_movimiento') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                        style="border-radius:0">
                        <option value="ENTRADA" {{ old('tipo_movimiento') == 'ENTRADA' ? 'selected' : '' }}>ENTRADA (Aumentar stock)</option>
                        <option value="SALIDA" {{ old('tipo_movimiento') == 'SALIDA' ? 'selected' : '' }}>SALIDA (Disminuir stock)</option>
                        <option value="AJUSTE" {{ old('tipo_movimiento') == 'AJUSTE' ? 'selected' : '' }}>AJUSTE (Corrección manual)</option>
                    </select>
                </div>
                @error('tipo_movimiento') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Cantidad --}}
            <div>
                <label for="cantidad" class="block text-sm font-semibold text-slate-700 mb-1">Cantidad <span class="text-red-500">*</span></label>
                <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad') }}" required min="1" placeholder="Ej: 10"
                    class="w-full px-3 py-2 border text-sm text-slate-900 font-bold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('cantidad') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('cantidad') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Motivo / Descripción --}}
            <div>
                <label for="motivo" class="block text-sm font-semibold text-slate-700 mb-1">Motivo / Descripción</label>
                <input type="text" name="motivo" id="motivo" value="{{ old('motivo') }}" placeholder="Ej: Compra de lote, Venta, etc."
                    class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('motivo') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('motivo') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-colors">
            Guardar Movimiento
        </button>
        <a href="{{ route('movimientos.index') }}" class="px-5 py-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
            Cancelar
        </a>
    </div>
</form>
@endsection
