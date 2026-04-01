<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnidadMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('buscar');
        $estado = $request->get('estado');

        $query = \App\Models\UnidadMedida::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('abreviatura', 'LIKE', "%{$search}%");
            });
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        $unidades = $query->orderBy('id_unidad', 'desc')->paginate(10);

        return view('unidades.index', compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:50',
            'abreviatura' => 'required|max:10',
            'estado' => 'required|in:activo,inactivo',
        ], [
            'nombre.required' => 'El nombre de la unidad es obligatorio.',
            'abreviatura.required' => 'La abreviatura es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
        ]);

        \App\Models\UnidadMedida::create($request->all());

        return redirect()->route('unidades.index')->with('success', 'Unidad de medida creada correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unidad = \App\Models\UnidadMedida::findOrFail($id);
        return view('unidades.edit', compact('unidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unidad = \App\Models\UnidadMedida::findOrFail($id);

        $request->validate([
            'nombre' => 'required|max:50',
            'abreviatura' => 'required|max:10',
            'estado' => 'required|in:activo,inactivo',
        ], [
            'nombre.required' => 'El nombre de la unidad es obligatorio.',
            'abreviatura.required' => 'La abreviatura es obligatoria.',
            'estado.required' => 'El estado es obligatorio.',
        ]);

        $unidad->update($request->all());

        return redirect()->route('unidades.index')->with('success', 'Unidad de medida actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unidad = \App\Models\UnidadMedida::findOrFail($id);
        
        try {
            $unidad->delete();
            return redirect()->route('unidades.index')->with('success', 'Unidad de medida eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('unidades.index')->with('error', 'No se puede eliminar la unidad porque tiene productos asociados.');
        }
    }
}
