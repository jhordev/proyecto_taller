<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Registra cada entrada, salida o ajuste de stock de un producto
class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'tipo_movimiento',
        'cantidad',
        'stock_anterior',
        'stock_nuevo',
        'motivo',
    ];

    // Producto al que corresponde este movimiento de inventario
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_producto');
    }
}
