@extends('layouts.panel')

@section('title', 'Nuevo Producto')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('productos.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900">Nuevo Producto</h1>
        <p class="text-slate-500 text-sm">Registra un nuevo producto en el inventario del almacén.</p>
    </div>
</div>

<form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-5xl">
    @csrf

    {{-- Datos Generales --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Datos del Producto</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Código / SKU <span class="text-red-500">*</span></label>
                <input type="text" name="codigo" value="{{ old('codigo') }}" required placeholder="Ej: PROD-001"
                    class="w-full px-3 py-2 border text-sm text-slate-900 font-mono focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('codigo') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('codigo') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre del Producto <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej: Jabón Líquido 1L"
                    class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('nombre') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Categoría <span class="text-red-500">*</span></label>
                <select name="categoria_id" required
                    class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('categoria_id') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                    <option value="">Seleccionar...</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id_categoria }}" {{ old('categoria_id') == $cat->id_categoria ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
                @error('categoria_id') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Unidad de Medida <span class="text-red-500">*</span></label>
                <select name="unidad_id" required
                    class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('unidad_id') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                    <option value="">Seleccionar...</option>
                    @foreach($unidades as $un)
                        <option value="{{ $un->id_unidad }}" {{ old('unidad_id') == $un->id_unidad ? 'selected' : '' }}>{{ $un->nombre }} ({{ $un->abreviatura }})</option>
                    @endforeach
                </select>
                @error('unidad_id') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Estado</label>
                <select name="estado" class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" style="border-radius:0">
                    <option value="activo" {{ old('estado') != 'inactivo' ? 'selected' : '' }}>ACTIVO</option>
                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>INACTIVO</option>
                </select>
            </div>

            <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="2" placeholder="Especificaciones técnicas, marca, etc."
                    class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    style="border-radius:0">{{ old('descripcion') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Precios e Inventario --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Precios e Inventario</h2>
        </div>
        <div class="p-5 grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Precio Compra <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="precio_compra" value="{{ old('precio_compra', '0.00') }}" required
                    class="w-full px-3 py-2 border text-sm text-slate-900 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('precio_compra') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('precio_compra') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Precio Venta <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="precio_venta" value="{{ old('precio_venta', '0.00') }}" required
                    class="w-full px-3 py-2 border text-sm text-indigo-700 font-bold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('precio_venta') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('precio_venta') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Stock Inicial <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" required
                    class="w-full px-3 py-2 border text-sm text-slate-900 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('stock') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('stock') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Stock Mínimo <span class="text-red-500">*</span></label>
                <input type="number" name="stock_minimo" value="{{ old('stock_minimo', 5) }}" required
                    class="w-full px-3 py-2 border text-sm text-red-600 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('stock_minimo') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('stock_minimo') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Imagen --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Imagen del Producto</h2>
        </div>
        <div class="p-5">
            <div class="flex items-start gap-5">
                <div class="w-28 h-28 shrink-0 bg-slate-50 border border-slate-200 flex items-center justify-center overflow-hidden">
                    <img id="preview" class="hidden w-full h-full object-cover">
                    <svg id="placeholder-icon" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Seleccionar Imagen</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*"
                        class="w-full text-sm text-slate-600 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-slate-100 file:text-slate-700 file:text-sm file:font-semibold hover:file:bg-slate-200"
                        style="border-radius:0"
                        onchange="const p=document.getElementById('preview'); p.src=URL.createObjectURL(this.files[0]); p.classList.remove('hidden'); document.getElementById('placeholder-icon').classList.add('hidden');">
                    <p class="text-xs text-slate-400 mt-2">Formatos: JPG, PNG, WEBP. Máximo 2MB.</p>
                    @error('imagen') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-colors">
            Guardar Producto
        </button>
        <a href="{{ route('productos.index') }}" class="px-5 py-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
            Cancelar
        </a>
    </div>
</form>
@endsection
