<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentaController extends Controller
{
    // Lista todas las ventas con búsqueda por comprobante/cliente y filtros por estado y método de pago
    public function index(Request $request)
    {
        $query = Venta::with('cliente')->latest();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nro_comprobante', 'like', "%{$buscar}%")
                  ->orWhereHas('cliente', function ($c) use ($buscar) {
                      $c->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%")
                        ->orWhere('nro_doc', 'like', "%{$buscar}%");
                  });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('metodo_pago')) {
            $query->where('metodo_pago', $request->metodo_pago);
        }

        $ventas = $query->paginate(10)->withQueryString();
        return view('ventas.index', compact('ventas'));
    }

    // Muestra la pantalla del Punto de Venta con productos activos en stock y lista de clientes
    public function create()
    {
        $productos = Producto::where('estado', 'activo')->where('stock', '>', 0)->get();
        $clientes = Cliente::all();
        return view('ventas.create', compact('productos', 'clientes'));
    }

    // Procesa la venta, crea los detalles y registra movimientos de inventario en una transacción
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'metodo_pago' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.producto_id' => 'required|exists:productos,id_producto',
            'items.*.cantidad' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Generar nro de comprobante simple
            $ultimoId = Venta::max('id') ?? 0;
            $nro_comprobante = 'VNT-' . date('Ymd') . '-' . str_pad($ultimoId + 1, 4, '0', STR_PAD_LEFT);

            $subtotal = 0;
            foreach ($request->items as $item) {
                $producto = Producto::find($item['producto_id']);
                $subtotal += $producto->precio_venta * $item['cantidad'];
            }

            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'nro_comprobante' => $nro_comprobante,
                'subtotal' => $subtotal,
                'impuesto' => 0, // Podría calcularse
                'total' => $subtotal,
                'metodo_pago' => $request->metodo_pago,
                'notas' => $request->notas,
                'estado' => 'completada'
            ]);

            foreach ($request->items as $item) {
                $producto = Producto::find($item['producto_id']);
                
                // 1. Crear detalle
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $producto->precio_venta * $item['cantidad']
                ]);

                // 2. Crear movimiento de inventario (esto activará el trigger de stock)
                MovimientoInventario::create([
                    'producto_id' => $item['producto_id'],
                    'tipo_movimiento' => 'SALIDA',
                    'cantidad' => $item['cantidad'],
                    'motivo' => "Venta #" . $venta->nro_comprobante
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada correctamente',
                'comprobante' => $venta->nro_comprobante,
                'redirect' => route('ventas.index')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la venta: ' . $e->getMessage()
            ], 500);
        }
    }

    // Muestra el detalle completo de una venta con cliente y productos vendidos
    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'detalles.producto']);
        return view('ventas.show', compact('venta'));
    }
}
