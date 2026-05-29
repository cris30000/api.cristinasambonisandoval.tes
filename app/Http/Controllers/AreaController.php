<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index()
    {
        // $category = Category::included()->findOrFail(2);
        // $categories=Category::included()->get();
      //  $categories=Category::included()->filter()->sort()->get();
      //$categories=Category::included()->filter()->get();
        //$categories = Category::all();
        //$categories = Category::with(['posts.user'])->get();

        $area=Area::included()
        ->filter()
        ->sort()
        ->getOrPaginate();
        

        //return response()->json($armyCorps);
        //version mejorarada
         return response()->json([
            'status' => true,
            'message' => 'Listado de cuerpos militares',
            'data' => $area
        ], 200);
    
    }

    /**
     * Ahora guardamos un nuevo armyCorp (o cuerpo de soldados) en la base de datos. Para esto, vamos a validar que el campo denominacion sea requerido y no tenga mas de 255 caracteres. Luego, creamos un nuevo armyCorp utilizando el método create() y pasamos todos los datos del request. Finalmente, devolvemos una respuesta JSON con el nuevo armyCorp creado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'nombrearea' => 'required|max:255',
        ]);

        $area = Area::create($request->all());

        //return response()->json($armyCorp,201);
        return response()->json([
            'status' => true,
            'message' => 'Empresa  creada correctamente',
            'data' => $area
        ], 201);
    }

    /**
     * MOSTRAR UN REGISTRO ESPECIFICO
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area) //si se pasa $id se utiliza la comentada
    {
       
     //si se pasa $id se utiliza la comentada
        // $armyCorp = ArmyCorp::with(['posts.user'])->findOrFail($id);
        // $armyCorp = ArmyCorp::with(['posts'])->findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Area encontrado correctamente',
            'data' => $area
        ], 200);
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'nombrearea' => 'required|max:255',
            
        ]);

        $area->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Area actualizado correctamente',
            'data' => $area
        ], 200);
    }

// eliminar registro
    public function destroy(Area $area)
    {
        $area->delete();
        return response()->json([
            'status' => true,
            'message' => 'Area eliminado correctamente'
        ], 200 );
    }
}