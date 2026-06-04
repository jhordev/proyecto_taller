<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa un producto del inventario con precios, stock e imagen
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

    // Categoría a la que pertenece el producto
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id_categoria');
    }

    // Unidad de medida del producto
    public function unidad()
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_id', 'id_unidad');
    }

    // Movimientos de entrada/salida registrados para este producto
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'producto_id', 'id_producto');
    }

    // Líneas de venta en las que aparece este producto
    public function detalle_ventas()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id', 'id_producto');
    }
}
