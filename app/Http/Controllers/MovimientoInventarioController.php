<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MovimientoInventario;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class MovimientoInventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = MovimientoInventario::with('producto')->orderBy('fecha', 'desc');

        if ($request->has('buscar')) {
            $buscar = $request->buscar;
            $query->whereHas('producto', function($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                  ->orWhere('codigo', 'like', "%$buscar%");
            });
        }

        $movimientos = $query->paginate(15);
        return view('movimientos.index', compact('movimientos'));
    }

    public function create()
    {
        $productos = Producto::where('estado', 'activo')->get();
        return view('movimientos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id_producto',
            'tipo_movimiento' => 'required|in:ENTRADA,SALIDA,AJUSTE',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:100',
        ]);

        try {
            // Ya no calculamos nada aquí, el Trigger tr_actualizar_stock_productos lo hará.
            // Solo creamos el registro base.
            MovimientoInventario::create([
                'producto_id' => $request->producto_id,
                'tipo_movimiento' => $request->tipo_movimiento,
                'cantidad' => $request->cantidad,
                'motivo' => $request->motivo,
                // stock_anterior y stock_nuevo serán llenados por el trigger
            ]);

            return redirect()->route('movimientos.index')->with('success', 'Movimiento registrado correctamente (Stock actualizado automáticamente).');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar el movimiento: ' . $e->getMessage())->withInput();
        }
    }
}
