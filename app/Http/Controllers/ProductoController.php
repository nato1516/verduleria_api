<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::where('activo', 'activo')->get();
        return response()->json([
            'success' => true,
            'productos' => $productos
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric',
            'precio_mayor' => 'required|numeric',
            'image_path' => 'nullable|mimes:jpg,jpeg,png|max:2024'
        ]);


        $imagen = null;

        if ($request->hasFile('image_path')) {

            $imagen = $request->file('image_path')->store('productos', 'public');
        }


        $productoCreado = Producto::create([

            'nombre' => $request->nombre,

            'categoria' => $request->categoria,

            'descripcion' => $request->descripcion,

            'precio' => $request->precio,

            'precio_mayor' => $request->precio_mayor,

            'modal_id' => 'modal' . $request->nombre,

            'image_path' => $imagen

        ]);


        return response()->json([
            'success' => true,
            'producto' => $productoCreado
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Producto $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $productos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $productos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $productos)
    {
        //
    }
}
