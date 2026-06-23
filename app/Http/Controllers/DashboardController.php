<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy         = Carbon::today();
        $inicioMes   = $hoy->copy()->startOfMonth();
        $hace30dias  = $hoy->copy()->subDays(29);
        $hace12meses = $hoy->copy()->subMonths(11)->startOfMonth();

        // ── KPIs ────────────────────────────────────────────────────────────────

        $ingresosMes = (float) DB::table('ventas')
            ->where('estado', 'completada')
            ->where('created_at', '>=', $inicioMes)
            ->sum('total');

        $ventasMes = DB::table('ventas')
            ->where('estado', 'completada')
            ->where('created_at', '>=', $inicioMes)
            ->count();

        $ingresosHoy = (float) DB::table('ventas')
            ->where('estado', 'completada')
            ->whereDate('created_at', $hoy)
            ->sum('total');

        $ventasHoy = DB::table('ventas')
            ->where('estado', 'completada')
            ->whereDate('created_at', $hoy)
            ->count();

        $clientesActivos   = DB::table('clientes')->where('estado', 'activo')->count();
        $stockCriticoCount = DB::table('v_stock_critico')->count();

        // ── Chart 1: Ingresos últimos 30 días (área) ────────────────────────────

        $ventasDiariasRaw = DB::table('v_ventas_diarias')
            ->where('fecha', '>=', $hace30dias->toDateString())
            ->orderBy('fecha')
            ->get(['fecha', 'total_ingresos', 'total_ventas'])
            ->keyBy('fecha');

        $labels30dias  = [];
        $ingresos30dias = [];
        $ventas30dias  = [];

        for ($i = 29; $i >= 0; $i--) {
            $fecha         = $hoy->copy()->subDays($i)->toDateString();
            $reg           = $ventasDiariasRaw->get($fecha);
            $labels30dias[]  = Carbon::parse($fecha)->format('d/m');
            $ingresos30dias[] = $reg ? round((float) $reg->total_ingresos, 2) : 0;
            $ventas30dias[]   = $reg ? (int) $reg->total_ventas : 0;
        }

        // ── Chart 2: Top 10 productos más vendidos (barras horizontales) ────────

        $topProductos = DB::table('v_productos_mas_vendidos')
            ->orderByDesc('total_unidades')
            ->limit(10)
            ->get(['producto', 'categoria', 'total_unidades', 'total_ingresos']);

        $topProductosNombres  = $topProductos->pluck('producto')->values()->all();
        $topProductosUnidades = $topProductos->map(fn ($r) => (int) $r->total_unidades)->values()->all();

        // ── Chart 3: Métodos de pago (dona) ─────────────────────────────────────

        $metodosPago = DB::table('v_ventas_por_metodo_pago')
            ->orderByDesc('total_ventas')
            ->get(['metodo_pago', 'total_ventas', 'total_ingresos']);

        $metodosPagoLabels = $metodosPago->pluck('metodo_pago')->values()->all();
        $metodosPagoValues = $metodosPago->map(fn ($r) => (int) $r->total_ventas)->values()->all();

        // ── Chart 4: Ingresos por mes – últimos 12 meses (columnas) ─────────────

        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        $ventasMensualesRaw = DB::table('v_ventas_mensuales')
            ->where(function ($q) use ($hace12meses) {
                $q->where('anio', '>', $hace12meses->year)
                  ->orWhere(function ($q2) use ($hace12meses) {
                      $q2->where('anio', $hace12meses->year)
                         ->where('mes', '>=', $hace12meses->month);
                  });
            })
            ->orderBy('anio')
            ->orderBy('mes')
            ->get();

        $labelsMonthly   = $ventasMensualesRaw->map(fn ($r) => $meses[$r->mes - 1] . ' ' . $r->anio)->values()->all();
        $ingresosMonthly = $ventasMensualesRaw->map(fn ($r) => round((float) $r->total_ingresos, 2))->values()->all();
        $ventasMonthly   = $ventasMensualesRaw->map(fn ($r) => (int) $r->total_ventas)->values()->all();

        // ── Chart 5: Movimientos de inventario últimos 30 días (pie) ────────────

        $movRaw = DB::table('movimientos_inventario')
            ->where('fecha', '>=', $hace30dias)
            ->select('tipo_movimiento', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo_movimiento')
            ->get()
            ->pluck('total', 'tipo_movimiento');

        $movimientosTipoLabels = $movRaw->keys()->values()->all();
        $movimientosTipoValues = $movRaw->values()->map(fn ($v) => (int) $v)->values()->all();

        // ── Tabla: stock crítico (top 10 más urgentes) ──────────────────────────

        $stockCritico = DB::table('v_stock_critico')
            ->orderByDesc('deficit')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'ingresosMes', 'ventasMes', 'ingresosHoy', 'ventasHoy',
            'clientesActivos', 'stockCriticoCount',
            'labels30dias', 'ingresos30dias', 'ventas30dias',
            'topProductosNombres', 'topProductosUnidades', 'topProductos',
            'metodosPagoLabels', 'metodosPagoValues',
            'labelsMonthly', 'ingresosMonthly', 'ventasMonthly',
            'movimientosTipoLabels', 'movimientosTipoValues',
            'stockCritico'
        ));
    }
}
