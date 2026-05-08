<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa una unidad de medida (ej: kg, litros, unidades) usada en productos
class UnidadMedida extends Model
{
    use HasFactory;

    protected $table = 'unidades_medida';
    protected $primaryKey = 'id_unidad';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'abreviatura',
        'estado',
    ];

    // Una unidad de medida puede estar asignada a muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'unidad_id', 'id_unidad');
    }
}
