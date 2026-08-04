<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;

class ProductoController extends Controller
{

    /**
     * Sube una imagen a Cloudinary y devuelve la URL segura.
     */
    private function subirImagen($archivo)
    {
        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));

        $resultado = $cloudinary->uploadApi()->upload(
            $archivo->getRealPath(),
            ['folder' => 'productos']
        );

        return $resultado['secure_url'];
    }


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


    public function inactivo()
    {
        $productos = Producto::where('activo', 'inactivo')->get();

        return response()->json([
            'success' => true,
            'productos' => $productos
        ], 200);
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

            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);



        $imagen = null;



        if ($request->hasFile('image_path')) {

            try {

                $imagen = $this->subirImagen($request->file('image_path'));

            } catch (\Throwable $e) {

                return response()->json([
                    'success' => false,
                    'message' => 'Error al subir imagen a Cloudinary',
                    'error' => $e->getMessage()
                ], 500);

            }

        }



        try {

            $productoCreado = Producto::create([

                'nombre' => $request->nombre,

                'categoria' => $request->categoria,

                'descripcion' => $request->descripcion,

                'precio' => $request->precio,

                'precio_mayor' => $request->precio_mayor,

                'modal_id' => 'modal' . $request->nombre,

                'image_path' => $imagen,

                'activo' => 'activo'

            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el producto en la base de datos',
                'error' => $e->getMessage()
            ], 500);

        }




        return response()->json([

            'success' => true,

            'producto' => $productoCreado

        ], 201);

    }




    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {

        return response()->json([

            'success'=>true,

            'producto'=>$producto

        ]);

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
    public function update(Request $request, Producto $producto)
    {


        $request->validate([


            'nombre'=>'required',

            'categoria'=>'required',

            'descripcion'=>'nullable',

            'precio'=>'required|numeric',

            'precio_mayor'=>'required|numeric',

            'activo'=>'required',


            'image_path'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'


        ]);




        if($request->hasFile('image_path')){

            try {

                $imagen = $this->subirImagen($request->file('image_path'));

                $producto->image_path = $imagen;

            } catch (\Throwable $e) {

                return response()->json([
                    'success' => false,
                    'message' => 'Error al subir imagen a Cloudinary',
                    'error' => $e->getMessage()
                ], 500);

            }

        }





        try {

            $producto->nombre = $request->nombre;


            $producto->descripcion = $request->descripcion;


            $producto->categoria = $request->categoria;


            $producto->precio = $request->precio;


            $producto->precio_mayor = $request->precio_mayor;


            $producto->activo = $request->activo;



            $producto->save();

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage()
            ], 500);

        }




        return response()->json([

            'success'=>true,

            'producto'=>$producto

        ]);

    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $productos)
    {
        //
    }

}