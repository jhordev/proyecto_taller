@extends('layouts.panel')

@section('title', 'Historial de Ventas')

@section('content')
<div class="flex items-center justify-between mb-4">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Historial de Ventas</h1>
        <p class="text-slate-500 text-sm">Consulta y gestiona todos los comprobantes emitidos.</p>
    </div>
    <a href="{{ route('ventas.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
        </svg>
        Nueva Venta
    </a>
</div>

{{-- Barra de búsqueda + Filtros en línea --}}
<form action="{{ route('ventas.index') }}" method="GET" class="flex gap-3 mb-5">
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
            placeholder="Buscar por comprobante, cliente o documento..."
            class="w-full border border-slate-300 bg-white text-sm text-slate-900 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
            style="border-radius:0; padding: 10px 38px 10px 38px;"
        >
        @if(request('buscar'))
            <a href="{{ route('ventas.index', array_filter(['estado' => request('estado'), 'metodo_pago' => request('metodo_pago')])) }}" title="Limpiar" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); color:#94a3b8; display:flex; align-items:center;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
        @endif
    </div>
    <select name="metodo_pago" onchange="this.form.submit()"
        class="border border-slate-300 bg-white text-sm text-slate-700 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
        style="border-radius:0; padding: 10px 12px; min-width:160px;">
        <option value="">Todos los métodos</option>
        <option value="efectivo" {{ request('metodo_pago') == 'efectivo' ? 'selected' : '' }}>EFECTIVO</option>
        <option value="tarjeta" {{ request('metodo_pago') == 'tarjeta' ? 'selected' : '' }}>TARJETA</option>
        <option value="yape" {{ request('metodo_pago') == 'yape' ? 'selected' : '' }}>YAPE</option>
        <option value="plin" {{ request('metodo_pago') == 'plin' ? 'selected' : '' }}>PLIN</option>
        <option value="transferencia" {{ request('metodo_pago') == 'transferencia' ? 'selected' : '' }}>TRANSFERENCIA</option>
    </select>
    <select name="estado" onchange="this.form.submit()"
        class="border border-slate-300 bg-white text-sm text-slate-700 font-semibold focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
        style="border-radius:0; padding: 10px 12px; min-width:140px;">
        <option value="">Todos los estados</option>
        <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>COMPLETADA</option>
        <option value="anulada" {{ request('estado') == 'anulada' ? 'selected' : '' }}>ANULADA</option>
    </select>
</form>

@if($ventas->count() > 0)
    <div class="bg-white border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Comprobante</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Cliente</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Fecha</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px]">Método</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px] text-right">Total</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px] text-center">Estado</th>
                    <th class="px-5 py-3 font-bold text-slate-600 uppercase tracking-wider text-[11px] text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr class="border-b border-slate-100 hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 shrink-0 bg-indigo-50 border border-indigo-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 truncate">{{ $venta->nro_comprobante }}</div>
                                    <div class="text-[11px] text-slate-400 font-mono">ID #{{ $venta->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            @if($venta->cliente)
                                <div class="font-semibold text-slate-700">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $venta->cliente->nro_doc }}</div>
                            @else
                                <span class="text-xs font-semibold text-slate-400 italic">Cliente Ocasional</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-slate-600">
                            {{ $venta->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="font-bold text-slate-600 uppercase text-xs">{{ $venta->metodo_pago }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <span class="font-bold text-indigo-600">S/ {{ number_format($venta->total, 2) }}</span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2 py-0.5 text-[10px] font-bold {{ $venta->estado === 'completada' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ strtoupper($venta->estado) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('ventas.show', $venta) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 transition-colors" title="Ver detalle">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $ventas->links() }}
    </div>
@else
    <div class="bg-white border border-slate-200 p-16 text-center">
        <div class="w-12 h-12 bg-slate-100 flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h2 class="text-lg font-bold text-slate-900 mb-1">No hay ventas registradas</h2>
        <p class="text-slate-400 text-sm mb-6">Comienza a vender desde el Punto de Venta.</p>
        <a href="{{ route('ventas.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
            Nueva Venta
        </a>
    </div>
@endif
@endsection
