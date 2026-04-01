<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('buscar');
        $categoria_id = $request->get('categoria_id');
        $estado = $request->get('estado');

        $query = \App\Models\Producto::with(['categoria', 'unidad']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhere('codigo', 'LIKE', "%{$search}%");
            });
        }

        if ($categoria_id) {
            $query->where('categoria_id', $categoria_id);
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        $productos = $query->orderBy('id_producto', 'desc')->paginate(10);
        $categorias = \App\Models\Categoria::where('estado', 'activo')->get();

        return view('productos.index', compact('productos', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = \App\Models\Categoria::where('estado', 'activo')->get();
        $unidades = \App\Models\UnidadMedida::where('estado', 'activo')->get();
        return view('productos.create', compact('categorias', 'unidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|max:50|unique:productos,codigo',
            'nombre' => 'required|max:150',
            'categoria_id' => 'required|exists:categorias,id_categoria',
            'unidad_id' => 'required|exists:unidades_medida,id_unidad',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Este código ya está registrado.',
            'nombre.required' => 'El nombre es obligatorio.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'unidad_id.required' => 'La unidad de medida es obligatoria.',
            'precio_compra.required' => 'El precio de compra es obligatorio.',
            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'stock.required' => 'El stock inicial es obligatorio.',
            'imagen.image' => 'El archivo debe ser una imagen.',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('products', 'public');
            $data['imagen'] = $path;
        }

        \App\Models\Producto::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = \App\Models\Producto::findOrFail($id);
        $categorias = \App\Models\Categoria::where('estado', 'activo')->get();
        $unidades = \App\Models\UnidadMedida::where('estado', 'activo')->get();
        return view('productos.edit', compact('producto', 'categorias', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = \App\Models\Producto::findOrFail($id);

        $request->validate([
            'codigo' => 'required|max:50|unique:productos,codigo,' . $id . ',id_producto',
            'nombre' => 'required|max:150',
            'categoria_id' => 'required|exists:categorias,id_categoria',
            'unidad_id' => 'required|exists:unidades_medida,id_unidad',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Este código ya está registrado.',
            'nombre.required' => 'El nombre es obligatorio.',
            'categoria_id.required' => 'La categoría es obligatoria.',
            'unidad_id.required' => 'La unidad de medida es obligatoria.',
            'precio_compra.required' => 'El precio de compra es obligatorio.',
            'precio_venta.required' => 'El precio de venta es obligatorio.',
            'stock.required' => 'El stock inicial es obligatorio.',
            'imagen.image' => 'El archivo debe ser una imagen.',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($producto->imagen);
            }
            $path = $request->file('imagen')->store('products', 'public');
            $data['imagen'] = $path;
        }

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = \App\Models\Producto::findOrFail($id);
        
        if ($producto->imagen) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
