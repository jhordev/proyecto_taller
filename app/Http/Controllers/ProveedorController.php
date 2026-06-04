<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    // Lista todos los proveedores con búsqueda por RUC, razón social o contacto
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

    // Muestra el formulario para registrar un nuevo proveedor
    public function create()
    {
        return view('proveedores.create');
    }

    // Valida y guarda un nuevo proveedor en la base de datos
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

    // Muestra el formulario de edición con los datos del proveedor
    public function edit(Proveedor $proveedore)
    {
        return view('proveedores.edit', ['proveedor' => $proveedore]);
    }

    // Valida y actualiza los datos del proveedor
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

    // Elimina el proveedor de la base de datos
    public function destroy(Proveedor $proveedore)
    {
        $proveedore->delete();

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor eliminado satisfactoriamente.');
    }
}
