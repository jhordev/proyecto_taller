<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empleados = Empleado::latest()->paginate(10);
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'fecha_nac' => 'required|date',
            'tipo_doc' => 'required|string|max:50',
            'nro_doc' => 'required|string|max:20|unique:empleados',
            'direccion' => 'required|string|max:40',
            'nro_tel_princ' => 'required|string|max:40',
            'nro_tel_sec' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:40',
            'cargo' => 'required|string|max:40',
            'fecha_ingreso' => 'required|date',
            'salario_anual' => 'required|numeric|min:0',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'date' => 'El campo :attribute no es una fecha válida.',
            'unique' => 'El :attribute ya está en uso.',
            'email' => 'El formato del :attribute es inválido.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
        ], [
            'nombre' => 'nombre',
            'apellido' => 'apellido',
            'fecha_nac' => 'fecha de nacimiento',
            'tipo_doc' => 'tipo de documento',
            'nro_doc' => 'número de documento',
            'direccion' => 'dirección',
            'nro_tel_princ' => 'teléfono principal',
            'nro_tel_sec' => 'teléfono secundario',
            'email' => 'correo electrónico',
            'cargo' => 'cargo',
            'fecha_ingreso' => 'fecha de ingreso',
            'salario_anual' => 'salario anual',
        ]);

        Empleado::create($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado registrado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'fecha_nac' => 'required|date',
            'tipo_doc' => 'required|string|max:50',
            'nro_doc' => 'required|string|max:20|unique:empleados,nro_doc,' . $empleado->id,
            'direccion' => 'required|string|max:40',
            'nro_tel_princ' => 'required|string|max:40',
            'nro_tel_sec' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:40',
            'cargo' => 'required|string|max:40',
            'fecha_ingreso' => 'required|date',
            'salario_anual' => 'required|numeric|min:0',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'date' => 'El campo :attribute no es una fecha válida.',
            'unique' => 'El :attribute ya está en uso.',
            'email' => 'El formato del :attribute es inválido.',
            'numeric' => 'El campo :attribute debe ser un número.',
            'min' => 'El campo :attribute debe ser al menos :min.',
        ], [
            'nombre' => 'nombre',
            'apellido' => 'apellido',
            'fecha_nac' => 'fecha de nacimiento',
            'tipo_doc' => 'tipo de documento',
            'nro_doc' => 'número de documento',
            'direccion' => 'dirección',
            'nro_tel_princ' => 'teléfono principal',
            'nro_tel_sec' => 'teléfono secundario',
            'email' => 'correo electrónico',
            'cargo' => 'cargo',
            'fecha_ingreso' => 'fecha de ingreso',
            'salario_anual' => 'salario anual',
        ]);

        $empleado->update($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado satisfactoriamente.');
    }
}
