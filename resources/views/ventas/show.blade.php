@extends('layouts.panel')

@section('title', 'Detalle de Venta')

@section('content')
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('ventas.index') }}" class="text-slate-400 hover:text-slate-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-slate-900 uppercase tracking-tight">Venta #{{ $venta->nro_comprobante }}</h1>
            <p class="text-slate-500 text-sm font-medium">Visualización detallada del comprobante de venta.</p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <button onclick="window.print()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[12px] font-black uppercase tracking-widest transition-all">
            Imprimir Comprobante
        </button>
        @if($venta->estado === 'completada')
            <button class="px-5 py-2.5 bg-rose-100 hover:bg-rose-200 text-rose-700 text-[12px] font-black uppercase tracking-widest transition-all">
                Anular Venta
            </button>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Info General -->
    <div class="lg:col-span-2 flex flex-col gap-6">
        <div class="bg-white border border-slate-200 h-full">
            <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Productos Vendidos</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Producto</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Cantidad</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Precio Unit.</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($venta->detalles as $detalle)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-slate-900 uppercase truncate max-w-[200px]">{{ $detalle->producto->nombre }}</span>
                                        <span class="text-[10px] font-semibold text-slate-400 mt-0.5">{{ $detalle->producto->codigo }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="text-xs font-black text-slate-700">{{ $detalle->cantidad }}</span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <span class="text-xs font-semibold text-slate-600">$ {{ number_format($detalle->precio_unitario, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <span class="text-xs font-black text-slate-900">$ {{ number_format($detalle->subtotal, 2) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-50">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-[11px] font-black text-slate-500 uppercase tracking-widest">Total de la Venta</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-lg font-black text-indigo-600">$ {{ number_format($venta->total, 2) }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Info del Cliente y Venta -->
    <div class="flex flex-col gap-6">
        <div class="bg-white border border-slate-200">
            <div class="px-5 py-3 border-b border-slate-200 bg-slate-50">
                <h2 class="text-sm font-bold text-slate-700 uppercase tracking-wider">Resumen Informativo</h2>
            </div>
            <div class="p-6 space-y-6">
                <!-- Cliente -->
                <div class="space-y-3">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Información del Cliente</span>
                    @if($venta->cliente)
                        <div class="flex items-start gap-4 p-3 bg-slate-50 border border-slate-100">
                            <div class="w-10 h-10 bg-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xs shrink-0">
                                {{ substr($venta->cliente->nombre, 0, 1) }}{{ substr($venta->cliente->apellido, 0, 1) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-800">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</span>
                                <span class="text-[10px] font-semibold text-slate-500">{{ $venta->cliente->tipo_doc }}: {{ $venta->cliente->nro_doc }}</span>
                                <span class="text-[10px] font-semibold text-slate-500">{{ $venta->cliente->email ?? 'Sin correo' }}</span>
                            </div>
                        </div>
                    @else
                        <div class="p-3 border border-dashed border-slate-200 text-center">
                            <span class="text-[10px] font-bold text-slate-400 italic uppercase">CLIENTE OCASIONAL</span>
                        </div>
                    @endif
                </div>

                <!-- Pago y Fecha -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Método de Pago</span>
                        <div class="text-xs font-black text-slate-700 uppercase">{{ $venta->metodo_pago }}</div>
                    </div>
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Estado</span>
                        <div>
                            <span class="px-2 py-0.5 text-[9px] font-black uppercase tracking-wider {{ $venta->estado === 'completada' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $venta->estado }}
                            </span>
                        </div>
                    </div>
                    <div class="space-y-1.5 col-span-2 pt-2 border-t border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Fecha y Hora de Emisión</span>
                        <div class="text-xs font-bold text-slate-700">{{ $venta->created_at->format('l, d \d\e F \d\e Y - H:i') }}</div>
                    </div>
                </div>

                <!-- Notas -->
                @if($venta->notas)
                    <div class="space-y-1.5 pt-4 border-t border-slate-100">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Notas / Observaciones</span>
                        <div class="text-[11px] font-medium text-slate-600 bg-slate-50 p-3 italic border border-slate-100">
                            "{{ $venta->notas }}"
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
