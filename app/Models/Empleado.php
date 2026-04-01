<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    /** @use HasFactory<\Database\Factories\EmpleadoFactory> */
    use HasFactory;

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array<int, string>
     */
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

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_nac' => 'date',
            'fecha_ingreso' => 'date',
            'salario_anual' => 'decimal:2',
        ];
    }
}
