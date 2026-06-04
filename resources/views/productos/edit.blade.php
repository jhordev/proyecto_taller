@extends('layouts.panel')

@section('title', 'Editar Producto')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('productos.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h1 class="text-xl font-bold text-slate-900">Editar Producto</h1>
        <p class="text-slate-500 text-sm">Actualiza la información, precios o inventario del producto.</p>
    </div>
</div>

<form action="{{ route('productos.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-5xl">
    @csrf
    @method('PUT')

    {{-- Datos Generales --}}
    <div class="bg-white border border-slate-200">
        <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
            <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Datos del Producto</h2>
        </div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-3 gap-x-4 gap-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Código / SKU <span class="text-red-500">*</span></label>
                <input type="text" name="codigo" value="{{ old('codigo', $producto->codigo) }}" required
                    class="w-full px-3 py-2 border text-sm text-slate-900 font-mono focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('codigo') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('codigo') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre del Producto <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required
                    class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('nombre') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                @error('nombre') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Categoría <span class="text-red-500">*</span></label>
                <select name="categoria_id" required
                    class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('categoria_id') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id_categoria }}" {{ old('categoria_id', $producto->categoria_id) == $cat->id_categoria ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
                @error('categoria_id') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Unidad de Medida <span class="text-red-500">*</span></label>
                <select name="unidad_id" required
                    class="w-full px-3 py-2 border text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('unidad_id') border-red-400 bg-red-50 @else border-slate-300 @enderror"
                    style="border-radius:0">
                    @foreach($unidades as $un)
                        <option value="{{ $un->id_unidad }}" {{ old('unidad_id', $producto->unidad_id) == $un->id_unidad ? 'selected' : '' }}>{{ $un->nombre }} ({{ $un->abreviatura }})</option>
                    @endforeach
                </select>
                @error('unidad_id') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Estado</label>
                <select name="estado" class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" style="border-radius:0">
                    <option value="activo" {{ old('estado', $producto->estado) == 'activo' ? 'selected' : '' }}>ACTIVO</option>
                    <option value="inactivo" {{ old('estado', $producto->estado) == 'inactivo' ? 'selected' : '' }}>INACTIVO</option>
                </select>
            </div>

            <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-slate-700 mb-1">Descripción</label>
                <textarea name="descripcion" rows="2"
                    class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                    style="border-radius:0">{{ old('descripcion', $producto->descripcion) }}</textarea>
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
                <label class="block text-sm font-semibold text-slate-700 mb-1">Precio Compra</label>
                <input type="number" step="0.01" name="precio_compra" value="{{ old('precio_compra', $producto->precio_compra) }}" required
                    class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                    style="border-radius:0">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Precio Venta</label>
                <input type="number" step="0.01" name="precio_venta" value="{{ old('precio_venta', $producto->precio_venta) }}" required
                    class="w-full px-3 py-2 border border-slate-300 text-sm text-indigo-700 font-bold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                    style="border-radius:0">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Stock Actual</label>
                <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" required
                    class="w-full px-3 py-2 border border-slate-300 text-sm text-slate-900 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                    style="border-radius:0">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Stock Mínimo</label>
                <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $producto->stock_minimo) }}" required
                    class="w-full px-3 py-2 border border-slate-300 text-sm text-red-600 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                    style="border-radius:0">
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
                {{-- Contenedor de imagen fijo 112x112 --}}
                <div class="w-28 h-28 shrink-0 bg-slate-50 border border-slate-200 overflow-hidden" style="min-width:112px; min-height:112px;">
                    @if($producto->imagen)
                        <img id="preview" src="{{ asset('storage/' . $producto->imagen) }}"
                             class="w-full h-full object-cover object-center"
                             style="width:112px; height:112px; display:block;">
                    @else
                        <img id="preview" class="w-full h-full object-cover object-center"
                             style="width:112px; height:112px; display:none;">
                    @endif
                    <svg id="placeholder-icon" class="{{ $producto->imagen ? 'hidden' : '' }} h-8 w-8 text-slate-300 m-auto mt-9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Cambiar Imagen</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*"
                        class="w-full text-sm text-slate-600 border border-slate-300 bg-white focus:outline-none focus:ring-1 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-slate-100 file:text-slate-700 file:text-sm file:font-semibold hover:file:bg-slate-200"
                        style="border-radius:0"
                        onchange="const p=document.getElementById('preview'); p.src=URL.createObjectURL(this.files[0]); p.style.display='block'; document.getElementById('placeholder-icon').classList.add('hidden');">
                    <p class="text-xs text-slate-400 mt-2">Déjalo vacío para conservar la imagen actual. Formatos: JPG, PNG, WEBP. Máx. 2MB.</p>
                    @error('imagen') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition-colors">
            Actualizar Producto
        </button>
        <a href="{{ route('productos.index') }}" class="px-5 py-2 border border-slate-300 bg-white hover:bg-slate-50 text-slate-600 text-sm font-semibold transition-colors">
            Cancelar
        </a>
    </div>
</form>
@endsection
