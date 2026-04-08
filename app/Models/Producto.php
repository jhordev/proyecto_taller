<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'imagen',
        'categoria_id',
        'unidad_id',
        'precio_compra',
        'precio_venta',
        'stock',
        'stock_minimo',
        'estado',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    public function unidad()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_id', 'id_unidad');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'producto_id', 'id_producto');
    }

    public function detalle_ventas()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id', 'id_producto');
    }
}
