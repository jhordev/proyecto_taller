<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Representa un empleado de la empresa con datos personales y laborales
class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nac',
        'tipo_doc',
        'nro_doc',
        'direccion',
        'nro_tel_princ',
        'nro_tel_sec',
        'email',
        'cargo',
        'fecha_ingreso',
        'salario_anual',
    ];

    // Convierte fechas y salario a sus tipos nativos
    protected function casts(): array
    {
        return [
            'fecha_nac' => 'date',
            'fecha_ingreso' => 'date',
            'salario_anual' => 'decimal:2',
        ];
    }
}
