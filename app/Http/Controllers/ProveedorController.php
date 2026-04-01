<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $proveedores = Proveedor::when($search, function ($query, $search) {
            return $query->where('ruc', 'like', "%{$search}%")
                ->orWhere('razon_social', 'like', "%{$search}%")
                ->orWhere('contacto', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('proveedores.index', compact('proveedores', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruc' => 'required|string|size:11|unique:proveedores',
            'razon_social' => 'required|string|max:150',
            'nombre_comercial' => 'nullable|string|max:150',
            'contacto' => 'nullable|string|max:120',
            'telefono' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:120',
            'direccion' => 'nullable|string|max:200',
            'departamento' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'distrito' => 'nullable|string|max:100',
            'estado' => 'required|in:ACTIVO,INACTIVO',
            'observaciones' => 'nullable|string',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'unique' => 'El :attribute ya está registrado.',
            'size' => 'El :attribute debe tener exactamente :size caracteres.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'email' => 'El formato del :attribute es inválido.',
            'in' => 'El :attribute seleccionado no es válido.',
        ], [
            'ruc' => 'RUC',
            'razon_social' => 'razón social',
            'nombre_comercial' => 'nombre comercial',
            'contacto' => 'contacto',
            'telefono' => 'teléfono',
            'celular' => 'celular',
            'email' => 'correo electrónico',
            'direccion' => 'dirección',
            'departamento' => 'departamento',
            'provincia' => 'provincia',
            'distrito' => 'distrito',
            'estado' => 'estado',
            'observaciones' => 'observaciones',
        ]);

        Proveedor::create($validated);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor registrado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedore)
    {
        // Note: Laravel uses plural name by default for route-model binding if resource is plural.
        // If I use Route::resource('proveedores', ...), the parameter name will likely be 'proveedore' (Laravel's default pluralization of 'proveedore' is strange sometimes, but usually it's the singular if the resource name is plural).
        // Let's check the route list if unsure, but I'll use '$proveedore' to match the likely parameter name from Route::resource('proveedores', ...).
        return view('proveedores.edit', ['proveedor' => $proveedore]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedore)
    {
        $validated = $request->validate([
            'ruc' => 'required|string|size:11|unique:proveedores,ruc,' . $proveedore->id,
            'razon_social' => 'required|string|max:150',
            'nombre_comercial' => 'nullable|string|max:150',
            'contacto' => 'nullable|string|max:120',
            'telefono' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:120',
            'direccion' => 'nullable|string|max:200',
            'departamento' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'distrito' => 'nullable|string|max:100',
            'estado' => 'required|in:ACTIVO,INACTIVO',
            'observaciones' => 'nullable|string',
        ], [
            'required' => 'El campo :attribute es obligatorio.',
            'unique' => 'El :attribute ya está registrado.',
            'size' => 'El :attribute debe tener exactamente :size caracteres.',
            'max' => 'El campo :attribute no debe exceder :max caracteres.',
            'email' => 'El formato del :attribute es inválido.',
            'in' => 'El :attribute seleccionado no es válido.',
        ], [
            'ruc' => 'RUC',
            'razon_social' => 'razón social',
            'nombre_comercial' => 'nombre comercial',
            'contacto' => 'contacto',
            'telefono' => 'teléfono',
            'celular' => 'celular',
            'email' => 'correo electrónico',
            'direccion' => 'dirección',
            'departamento' => 'departamento',
            'provincia' => 'provincia',
            'distrito' => 'distrito',
            'estado' => 'estado',
            'observaciones' => 'observaciones',
        ]);

        $proveedore->update($validated);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedore)
    {
        $proveedore->delete();

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado satisfactoriamente.');
    }
}
