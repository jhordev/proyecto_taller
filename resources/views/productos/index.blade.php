@extends('layouts.panel')

@section('title', 'Productos')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Productos</h1>
        <p class="text-slate-500 text-sm">Gestión de inventario y catálogo de productos del almacén.</p>
    </div>
    <a href="{{ route('productos.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Producto
    </a>
</div>

{{-- Barra de búsqueda + Filtros en línea --}}
<form action="{{ route('productos.index') }}" method="GET" class="flex gap-3 mb-5">
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
            placeholder="Buscar por nombre o código..."
            class="w-full border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            style="border-radius:0; padding: 10px 38px 10px 38px;"
        >
        @if(request('buscar'))
            <a href="{{ route('productos.index', array_filter(['categoria_id' => request('categoria_id'), 'estado' => request('estado')])) }}" title="Limpiar" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:#94a3b8; display:flex; align-items:center;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        @endif
    </div>
    <select name="categoria_id" onchange="this.form.submit()"
        class="border border-slate-300 bg-white text-sm text-slate-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
        style="border-radius:0; padding: 10px 12px; min-width:175px;">
        <option value="">Todas las Categorías</option>
        @foreach($categorias as $cat)
            <option value="{{ $cat->id_categoria }}" {{ request('categoria_id') == $cat->id_categoria ? 'selected' : '' }}>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>
    <select name="estado" onchange="this.form.submit()"
        class="border border-slate-300 bg-white text-sm text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
        style="border-radius:0; padding: 10px 12px; min-width:140px;">
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

{{-- Confirm Dialog --}}
<x-confirm-dialog
    id="dialog-eliminar-producto"
    title="Eliminar producto"
    message="¿Estás seguro de que deseas eliminar este producto? Esta acción también eliminará la imagen asociada."
    confirmText="Sí, eliminar"
    cancelText="Cancelar"
/>

@if($productos->count() > 0)
    <div class="bg-white border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Producto</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Categoría</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Stock</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">P. Venta</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Estado</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px] text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $prod)
                    <tr class="border-b border-slate-100 hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 shrink-0 bg-slate-100 border border-slate-200 overflow-hidden">
                                    @if($prod->imagen)
                                        <img src="{{ asset('storage/' . $prod->imagen) }}" alt="{{ $prod->nombre }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 truncate">{{ $prod->nombre }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">{{ $prod->codigo }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-600">{{ $prod->categoria->nombre }}</td>
                        <td class="px-5 py-3.5">
                            <span class="font-bold {{ $prod->stock <= $prod->stock_minimo ? 'text-red-600' : 'text-slate-800' }}">
                                {{ $prod->stock }} {{ $prod->unidad->abreviatura }}
                            </span>
                            @if($prod->stock <= $prod->stock_minimo)
                                <div class="text-[10px] text-red-500 font-bold uppercase">Stock bajo</div>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="font-bold text-indigo-600">S/ {{ number_format($prod->precio_venta, 2) }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2 py-0.5 text-[10px] font-bold {{ $prod->estado === 'activo' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ strtoupper($prod->estado) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('productos.edit', $prod->id_producto) }}" class="p-1.5 text-slate-400 hover:text-amber-500 transition-colors" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form id="form-delete-prod-{{ $prod->id_producto }}" action="{{ route('productos.destroy', $prod->id_producto) }}" method="POST" style="display:none">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button
                                    type="button"
                                    onclick="openConfirmDialog('dialog-eliminar-producto', document.getElementById('form-delete-prod-{{ $prod->id_producto }}'))"
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
        {{ $productos->links() }}
    </div>
@else
    <div class="bg-white border border-slate-200 p-16 text-center">
        <div class="w-12 h-12 bg-slate-100 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-slate-900 mb-1">Sin productos registrados</h2>
        <p class="text-slate-400 text-sm mb-6">Agrega tu primer producto para comenzar a gestionar tu inventario.</p>
        <a href="{{ route('productos.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
            Nuevo Producto
        </a>
    </div>
@endif
@endsection
