@extends('layouts.panel')

@section('title', 'Movimientos de Inventario')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Movimientos de Inventario</h1>
        <p class="text-slate-500 text-sm">Historial y registro de entradas, salidas y ajustes de productos.</p>
    </div>
    <a href="{{ route('movimientos.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Movimiento
    </a>
</div>

{{-- Barra de búsqueda --}}
<form action="{{ route('movimientos.index') }}" method="GET" class="flex gap-3 mb-5">
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
            placeholder="Buscar por producto o código..."
            class="w-full border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            style="border-radius:0; padding: 10px 38px 10px 38px;"
        >
        @if(request('buscar'))
            <a href="{{ route('movimientos.index') }}" title="Limpiar" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:#94a3b8; display:flex; align-items:center;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        @endif
    </div>
</form>

@if(session('success'))
    <div class="mb-5 px-4 py-3 bg-emerald-50 border border-emerald-300 text-emerald-700 text-sm font-semibold">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-5 px-4 py-3 bg-red-50 border border-red-300 text-red-700 text-sm font-semibold">
        {{ session('error') }}
    </div>
@endif

@if($movimientos->count() > 0)
    <div class="bg-white border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Fecha</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Producto</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Tipo</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Cantidad</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Stock Ant.</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Stock Nuevo</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Motivo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movimientos as $mov)
                    <tr class="border-b border-slate-100 hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-3 text-slate-500 text-[12px]">
                            {{ date('d/m/Y H:i', strtotime($mov->fecha)) }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="font-semibold text-slate-900">{{ $mov->producto->nombre }}</div>
                            <div class="text-[11px] text-slate-400 font-mono">{{ $mov->producto->codigo }}</div>
                        </td>
                        <td class="px-5 py-3">
                            @if($mov->tipo_movimiento === 'ENTRADA')
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-emerald-100 text-emerald-700">ENTRADA</span>
                            @elseif($mov->tipo_movimiento === 'SALIDA')
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-rose-100 text-rose-700">SALIDA</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-700">AJUSTE</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-bold text-slate-700">
                            {{ $mov->cantidad }}
                        </td>
                        <td class="px-5 py-3 text-slate-500">
                            {{ $mov->stock_anterior }}
                        </td>
                        <td class="px-5 py-3 font-bold text-indigo-600 text-base">
                            {{ $mov->stock_nuevo }}
                        </td>
                        <td class="px-5 py-3 text-slate-600 max-w-xs truncate" title="{{ $mov->motivo }}">
                            {{ $mov->motivo ?: '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $movimientos->links() }}
    </div>
@else
    <div class="bg-white border border-slate-200 p-16 text-center">
        <div class="w-12 h-12 bg-slate-100 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-slate-900 mb-1">Sin movimientos registrados</h2>
        <p class="text-slate-400 text-sm mb-6">Registra tu primer movimiento para ver el historial.</p>
        <a href="{{ route('movimientos.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
            Nuevo Movimiento
        </a>
    </div>
@endif
@endsection
