<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa una línea de producto dentro de una venta (cantidad, precio y subtotal)
class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_ventas';

    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    // Venta a la que pertenece este detalle
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }

    // Producto vendido en esta línea
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_producto');
    }
}
