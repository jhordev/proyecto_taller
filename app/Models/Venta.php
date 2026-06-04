<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa una venta con su comprobante, totales y método de pago
class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'cliente_id',
        'nro_comprobante',
        'subtotal',
        'impuesto',
        'total',
        'metodo_pago',
        'notas',
        'estado',
    ];

    // Cliente asociado a la venta (puede ser nulo si es venta de mostrador)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Líneas de detalle con los productos incluidos en la venta
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}
