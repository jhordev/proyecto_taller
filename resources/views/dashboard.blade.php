@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')

{{-- Cabecera --}}
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-xl font-bold text-slate-900">Dashboard</h1>
        <p class="text-slate-500 text-sm">Resumen del sistema · {{ now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
    </div>
    <a href="{{ route('ventas.create') }}"
       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-4 py-2 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nueva Venta
    </a>
</div>

{{-- ── KPI Cards ─────────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-5">

    {{-- Ingresos del mes --}}
    <div class="bg-white border border-slate-200 p-5 col-span-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider leading-none">Ingresos del Mes</p>
        <p class="text-2xl font-bold text-slate-900 mt-2 leading-none">S/ {{ number_format($ingresosMes, 2) }}</p>
        <p class="text-xs text-emerald-600 font-medium mt-1">{{ now()->locale('es')->isoFormat('MMMM YYYY') }}</p>
    </div>

    {{-- Ventas del mes --}}
    <div class="bg-white border border-slate-200 p-5 col-span-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider leading-none">Ventas del Mes</p>
        <p class="text-2xl font-bold text-slate-900 mt-2 leading-none">{{ number_format($ventasMes) }}</p>
        <p class="text-xs text-slate-400 mt-1">transacciones</p>
    </div>

    {{-- Ingresos hoy --}}
    <div class="bg-white border border-slate-200 p-5 col-span-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider leading-none">Ingresos Hoy</p>
        <p class="text-2xl font-bold text-slate-900 mt-2 leading-none">S/ {{ number_format($ingresosHoy, 2) }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ now()->format('d/m/Y') }}</p>
    </div>

    {{-- Ventas hoy --}}
    <div class="bg-white border border-slate-200 p-5 col-span-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider leading-none">Ventas Hoy</p>
        <p class="text-2xl font-bold text-slate-900 mt-2 leading-none">{{ $ventasHoy }}</p>
        <p class="text-xs text-slate-400 mt-1">transacciones</p>
    </div>

    {{-- Clientes activos --}}
    <div class="bg-white border border-slate-200 p-5 col-span-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider leading-none">Clientes Activos</p>
        <p class="text-2xl font-bold text-slate-900 mt-2 leading-none">{{ number_format($clientesActivos) }}</p>
        <p class="text-xs text-slate-400 mt-1">registrados</p>
    </div>

    {{-- Stock crítico --}}
    <div class="bg-white border border-slate-200 p-5 col-span-1 {{ $stockCriticoCount > 0 ? 'border-l-4 border-l-red-500' : '' }}">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider leading-none">Stock Crítico</p>
        <p class="text-2xl font-bold mt-2 leading-none {{ $stockCriticoCount > 0 ? 'text-red-600' : 'text-slate-900' }}">
            {{ $stockCriticoCount }}
        </p>
        <p class="text-xs mt-1 {{ $stockCriticoCount > 0 ? 'text-red-500 font-medium' : 'text-slate-400' }}">
            {{ $stockCriticoCount > 0 ? 'requieren atención' : 'sin alertas' }}
        </p>
    </div>

</div>

{{-- ── Fila 2: Área 30 días + Dona métodos de pago ─────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

    {{-- Chart 1: Área – ingresos últimos 30 días --}}
    <div class="lg:col-span-2 bg-white border border-slate-200 p-5">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h2 class="text-sm font-semibold text-slate-900">Ingresos — Últimos 30 días</h2>
                <p class="text-xs text-slate-400 mt-0.5">Ventas completadas · S/ acumulado</p>
            </div>
            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5">
                S/ {{ number_format(array_sum($ingresos30dias), 2) }}
            </span>
        </div>
        <div id="chart-area-30dias"></div>
    </div>

    {{-- Chart 2: Dona – métodos de pago --}}
    <div class="bg-white border border-slate-200 p-5">
        <div class="mb-4">
            <h2 class="text-sm font-semibold text-slate-900">Métodos de Pago</h2>
            <p class="text-xs text-slate-400 mt-0.5">Distribución por cantidad de ventas</p>
        </div>
        @if(count($metodosPagoValues) > 0)
            <div id="chart-donut-metodos"></div>
        @else
            <div class="flex items-center justify-center h-48 text-slate-400 text-sm">Sin datos aún</div>
        @endif
    </div>

</div>

{{-- ── Fila 3: Top productos + Ingresos mensuales ──────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

    {{-- Chart 3: Barras horizontales – top 10 productos --}}
    <div class="bg-white border border-slate-200 p-5">
        <div class="mb-4">
            <h2 class="text-sm font-semibold text-slate-900">Top 10 Productos Más Vendidos</h2>
            <p class="text-xs text-slate-400 mt-0.5">Por unidades vendidas · histórico</p>
        </div>
        @if(count($topProductosNombres) > 0)
            <div id="chart-bar-productos"></div>
        @else
            <div class="flex items-center justify-center h-64 text-slate-400 text-sm">Sin ventas registradas aún</div>
        @endif
    </div>

    {{-- Chart 4: Columnas – ingresos mensuales 12 meses --}}
    <div class="bg-white border border-slate-200 p-5">
        <div class="mb-4">
            <h2 class="text-sm font-semibold text-slate-900">Ingresos Mensuales</h2>
            <p class="text-xs text-slate-400 mt-0.5">Últimos 12 meses · S/ y n° de ventas</p>
        </div>
        @if(count($labelsMonthly) > 0)
            <div id="chart-col-mensual"></div>
        @else
            <div class="flex items-center justify-center h-64 text-slate-400 text-sm">Sin datos mensuales aún</div>
        @endif
    </div>

</div>

{{-- ── Fila 4: Movimientos de inventario (condicional) ────────────────────── --}}
@if(count($movimientosTipoValues) > 0)
<div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
    <div class="bg-white border border-slate-200 p-5">
        <div class="mb-4">
            <h2 class="text-sm font-semibold text-slate-900">Movimientos de Inventario</h2>
            <p class="text-xs text-slate-400 mt-0.5">Últimos 30 días por tipo</p>
        </div>
        <div id="chart-pie-movimientos"></div>
    </div>
    {{-- Resumen rápido de movimientos --}}
    <div class="lg:col-span-3 bg-white border border-slate-200 p-5">
        <h2 class="text-sm font-semibold text-slate-900 mb-4">Detalle por tipo de movimiento</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @php
                $iconosMov = ['ENTRADA' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'icon' => 'M5 10l7-7m0 0l7 7m-7-7v18'], 'SALIDA' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'icon' => 'M19 14l-7 7m0 0l-7-7m7 7V3'], 'AJUSTE' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'icon' => 'M12 4v16m8-8H4']];
            @endphp
            @foreach(array_combine($movimientosTipoLabels, $movimientosTipoValues) as $tipo => $total)
            @php $cfg = $iconosMov[$tipo] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'icon' => 'M13 16h-1v-4h-1m1-4h.01']; @endphp
            <div class="flex items-center gap-3 p-4 {{ $cfg['bg'] }}">
                <div class="shrink-0">
                    <svg class="w-5 h-5 {{ $cfg['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cfg['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $tipo }}</p>
                    <p class="text-xl font-bold {{ $cfg['text'] }}">{{ $total }}</p>
                    <p class="text-xs text-slate-400">movimientos</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ── Tabla: productos con stock crítico ──────────────────────────────────── --}}
@if($stockCritico->isNotEmpty())
<div class="bg-white border border-slate-200 mb-4">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-2">
        <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <h2 class="text-sm font-semibold text-slate-900">Productos con Stock Crítico</h2>
        <span class="ml-auto text-xs bg-red-100 text-red-700 font-semibold px-2 py-0.5">
            {{ $stockCriticoCount }} {{ Str::plural('producto', $stockCriticoCount) }}
        </span>
        <a href="{{ route('movimientos.create') }}"
           class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
            Registrar entrada →
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Código</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Producto</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Categoría</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Stock Actual</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Mínimo</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Déficit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stockCritico as $item)
                <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3 font-mono text-xs text-slate-400">{{ $item->codigo }}</td>
                    <td class="px-5 py-3 font-medium text-slate-900">{{ $item->nombre }}</td>
                    <td class="px-5 py-3 text-slate-500">{{ $item->categoria }}</td>
                    <td class="px-5 py-3 text-right font-bold
                        {{ $item->stock_actual == 0 ? 'text-red-600' : 'text-amber-600' }}">
                        {{ $item->stock_actual }}
                    </td>
                    <td class="px-5 py-3 text-right text-slate-400">{{ $item->stock_minimo }}</td>
                    <td class="px-5 py-3 text-right">
                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold bg-red-100 text-red-700">
                            −{{ $item->deficit }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

{{-- ── Scripts de inicialización de ApexCharts ─────────────────────────────── --}}
@push('scripts')
<script>
/**
 * Los scripts de módulo Vite (que exponen window.ApexCharts) se ejecutan después
 * de que el DOM está completamente parseado pero ANTES del evento DOMContentLoaded,
 * por lo que es seguro inicializar los charts aquí.
 */
document.addEventListener('DOMContentLoaded', function () {

    const PALETTE = ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#6366F1', '#14B8A6', '#F97316', '#8B5CF6'];

    const baseChart = {
        fontFamily: 'Inter, sans-serif',
        toolbar: { show: false },
        animations: { enabled: true, speed: 350 },
        zoom: { enabled: false },
    };

    // ── Chart 1: Área – ingresos + ventas últimos 30 días ────────────────────
    new ApexCharts(document.querySelector('#chart-area-30dias'), {
        chart: { ...baseChart, type: 'area', height: 220 },
        series: [
            { name: 'Ingresos (S/)', data: @json($ingresos30dias) },
            { name: 'N° Ventas',     data: @json($ventas30dias) },
        ],
        xaxis: {
            categories: @json($labels30dias),
            axisBorder: { show: false },
            axisTicks:  { show: false },
            labels:     { style: { colors: '#94A3B8', fontSize: '11px' }, rotate: 0 },
            tickAmount: 7,
        },
        yaxis: [
            {
                seriesName: 'Ingresos (S/)',
                labels: {
                    formatter: v => 'S/ ' + v.toFixed(0),
                    style: { colors: '#94A3B8', fontSize: '11px' },
                },
            },
            {
                seriesName: 'N° Ventas',
                opposite: true,
                labels: {
                    formatter: v => v.toFixed(0),
                    style: { colors: '#94A3B8', fontSize: '11px' },
                },
            },
        ],
        colors: ['#4F46E5', '#10B981'],
        fill: {
            type: ['gradient', 'solid'],
            gradient: { opacityFrom: 0.22, opacityTo: 0.02, shadeIntensity: 1 },
            opacity: [1, 0.15],
        },
        stroke:      { curve: 'smooth', width: [2.5, 2] },
        grid:        { borderColor: '#F1F5F9', strokeDashArray: 4 },
        dataLabels:  { enabled: false },
        legend:      { show: true, position: 'top', horizontalAlign: 'right', fontSize: '12px' },
        tooltip: {
            y: [
                { formatter: v => 'S/ ' + v.toFixed(2) },
                { formatter: v => v + ' venta(s)' },
            ],
        },
    }).render();

    // ── Chart 2: Dona – métodos de pago ──────────────────────────────────────
    @if(count($metodosPagoValues) > 0)
    new ApexCharts(document.querySelector('#chart-donut-metodos'), {
        chart:  { ...baseChart, type: 'donut', height: 220 },
        series: @json($metodosPagoValues),
        labels: @json($metodosPagoLabels),
        colors: PALETTE,
        dataLabels: {
            enabled: true,
            formatter: v => v.toFixed(1) + '%',
            style: { fontSize: '11px' },
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '62%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Ventas',
                            fontSize: '13px',
                            fontWeight: 600,
                            color: '#1E293B',
                            formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0),
                        },
                    },
                },
            },
        },
        legend:  { show: true, position: 'bottom', fontSize: '12px' },
        tooltip: { y: { formatter: v => v + ' ventas' } },
    }).render();
    @endif

    // ── Chart 3: Barras horizontales – top 10 productos ──────────────────────
    @if(count($topProductosNombres) > 0)
    new ApexCharts(document.querySelector('#chart-bar-productos'), {
        chart: { ...baseChart, type: 'bar', height: 300 },
        plotOptions: {
            bar: { horizontal: true, barHeight: '55%', borderRadius: 2, distributed: true },
        },
        series: [{ name: 'Unidades vendidas', data: @json($topProductosUnidades) }],
        xaxis: {
            categories: @json($topProductosNombres),
            labels: { style: { colors: '#94A3B8', fontSize: '11px' } },
        },
        yaxis: {
            labels: { style: { colors: '#475569', fontSize: '11px' }, maxWidth: 160 },
        },
        colors:      PALETTE,
        dataLabels:  { enabled: true, style: { colors: ['#fff'], fontSize: '11px', fontWeight: 600 } },
        legend:      { show: false },
        grid:        { borderColor: '#F1F5F9' },
        tooltip:     { y: { formatter: v => v + ' und.' } },
    }).render();
    @endif

    // ── Chart 4: Columnas – ingresos mensuales ────────────────────────────────
    @if(count($labelsMonthly) > 0)
    new ApexCharts(document.querySelector('#chart-col-mensual'), {
        chart: { ...baseChart, type: 'bar', height: 300 },
        plotOptions: { bar: { columnWidth: '55%', borderRadius: 2 } },
        series: [
            { name: 'Ingresos (S/)', data: @json($ingresosMonthly) },
            { name: 'N° Ventas',     data: @json($ventasMonthly) },
        ],
        xaxis: {
            categories: @json($labelsMonthly),
            axisBorder: { show: false },
            axisTicks:  { show: false },
            labels: {
                style: { colors: '#94A3B8', fontSize: '10px' },
                rotate: -35,
            },
        },
        yaxis: [
            {
                seriesName: 'Ingresos (S/)',
                labels: {
                    formatter: v => 'S/ ' + v.toFixed(0),
                    style: { colors: '#94A3B8', fontSize: '11px' },
                },
            },
            {
                seriesName: 'N° Ventas',
                opposite: true,
                labels: {
                    formatter: v => v.toFixed(0),
                    style: { colors: '#94A3B8', fontSize: '11px' },
                },
            },
        ],
        colors:      ['#4F46E5', '#10B981'],
        dataLabels:  { enabled: false },
        grid:        { borderColor: '#F1F5F9', strokeDashArray: 4 },
        legend:      { show: true, position: 'top', horizontalAlign: 'right', fontSize: '12px' },
        tooltip: {
            y: [
                { formatter: v => 'S/ ' + v.toFixed(2) },
                { formatter: v => v + ' venta(s)' },
            ],
        },
    }).render();
    @endif

    // ── Chart 5: Pie – movimientos de inventario ──────────────────────────────
    @if(count($movimientosTipoValues) > 0)
    new ApexCharts(document.querySelector('#chart-pie-movimientos'), {
        chart:  { ...baseChart, type: 'pie', height: 220 },
        series: @json($movimientosTipoValues),
        labels: @json($movimientosTipoLabels),
        colors: ['#10B981', '#EF4444', '#F59E0B', '#6366F1'],
        dataLabels: {
            enabled: true,
            formatter: v => v.toFixed(1) + '%',
            style: { fontSize: '11px' },
        },
        legend:  { show: true, position: 'bottom', fontSize: '12px' },
        tooltip: { y: { formatter: v => v + ' movimientos' } },
    }).render();
    @endif

});
</script>
@endpush
