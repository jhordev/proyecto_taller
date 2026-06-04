<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }
}
