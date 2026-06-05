<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Representa un cliente registrado que puede estar asociado a ventas
class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_doc',
        'nro_doc',
        'nro_tel_princ',
        'nro_tel_sec',
        'email',
        'estado',
    ];

    // Ventas realizadas por este cliente
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }
}
