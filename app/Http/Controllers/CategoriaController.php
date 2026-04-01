<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('buscar');
        $estado = $request->get('estado');

        $query = \App\Models\Categoria::query();

        if ($search) {
            $query->where('nombre', 'LIKE', "%{$search}%");
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        $categorias = $query->orderBy('id_categoria', 'desc')->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable',
            'estado' => 'required|in:activo,inactivo',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Este nombre de categoría ya está registrado.',
            'estado.required' => 'El estado es obligatorio.',
        ]);

        \App\Models\Categoria::create($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoria = \App\Models\Categoria::findOrFail($id);
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = \App\Models\Categoria::findOrFail($id);

        $request->validate([
            'nombre' => 'required|max:100|unique:categorias,nombre,' . $id . ',id_categoria',
            'descripcion' => 'nullable',
            'estado' => 'required|in:activo,inactivo',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Este nombre de categoría ya está registrado.',
            'estado.required' => 'El estado es obligatorio.',
        ]);

        $categoria->update($request->all());

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = \App\Models\Categoria::findOrFail($id);
        
        try {
            $categoria->delete();
            return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('categorias.index')->with('error', 'No se puede eliminar la categoría porque tiene productos asociados.');
        }
    }
}
