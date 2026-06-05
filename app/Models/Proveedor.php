<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa un proveedor con datos fiscales y de contacto
class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'ruc',
        'razon_social',
        'nombre_comercial',
        'contacto',
        'telefono',
        'celular',
        'email',
        'direccion',
        'departamento',
        'provincia',
        'distrito',
        'estado',
        'observaciones',
    ];

    // Convierte los campos de fecha y estado a sus tipos correspondientes
    protected function casts(): array
    {
        return [
            'estado' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
