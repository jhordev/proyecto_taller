<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa una categoría que agrupa productos del inventario
class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    // Una categoría puede tener muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id', 'id_categoria');
    }
}
