<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $estado = $request->query('estado');

        $clientes = Cliente::when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('nro_doc', 'like', "%{$search}%");
            });
        })
        ->when($estado, function ($query, $estado) {
            return $query->where('estado', $estado);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('clientes.index', compact('clientes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'tipo_doc' => 'required|in:DNI,RUC,CARNET DE EXTRANJERÍA',
            'nro_doc' => 'required|string|max:20|unique:clientes',
            'nro_tel_princ' => 'required|string|max:40',
            'nro_tel_sec' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:40',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'unique' => 'El :attribute ya está registrado.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'email' => 'El formato del :attribute es inválido.',
            'in' => 'El :attribute seleccionado no es válido.',
        ], [
            'nombre' => 'nombre',
            'apellido' => 'apellido',
            'tipo_doc' => 'tipo de documento',
            'nro_doc' => 'número de documento',
            'nro_tel_princ' => 'teléfono principal',
            'nro_tel_sec' => 'teléfono secundario',
            'email' => 'correo electrónico',
            'estado' => 'estado',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente registrado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'tipo_doc' => 'required|in:DNI,RUC,CARNET DE EXTRANJERÍA',
            'nro_doc' => 'required|string|max:20|unique:clientes,nro_doc,' . $cliente->id,
            'nro_tel_princ' => 'required|string|max:40',
            'nro_tel_sec' => 'nullable|string|max:40',
            'email' => 'nullable|email|max:40',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'unique' => 'El :attribute ya está registrado.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'email' => 'El formato del :attribute es inválido.',
            'in' => 'El :attribute seleccionado no es válido.',
        ], [
            'nombre' => 'nombre',
            'apellido' => 'apellido',
            'tipo_doc' => 'tipo de documento',
            'nro_doc' => 'número de documento',
            'nro_tel_princ' => 'teléfono principal',
            'nro_tel_sec' => 'teléfono secundario',
            'email' => 'correo electrónico',
            'estado' => 'estado',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado satisfactoriamente.');
    }
}
