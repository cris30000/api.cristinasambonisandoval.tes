<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
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

        $title=Title::included()
        ->filter()
        ->sort()
        ->getOrPaginate();
        

        //return response()->json($armyCorps);
        //version mejorarada
         return response()->json([
            'status' => true,
            'message' => 'Listado de cuerpos militares',
            'data' => $title
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
            'title' => 'required|max:255',
        ]);

        $title = Title::create($request->all());

        //return response()->json($armyCorp,201);
        return response()->json([
            'status' => true,
            'message' => 'Título creado correctamente',
            'data' => $title
        ], 201);
    }

    /**
     * MOSTRAR UN REGISTRO ESPECIFICO
     *
     * @param  \App\Models\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function show(Title $title) //si se pasa $id se utiliza la comentada
    {
       
     //si se pasa $id se utiliza la comentada
        // $armyCorp = ArmyCorp::with(['posts.user'])->findOrFail($id);
        // $armyCorp = ArmyCorp::with(['posts'])->findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Título encontrado correctamente',
            'data' => $title
        ], 200);
    }

    public function update(Request $request, Title $title)
    {
        $request->validate([
            'title' => 'required|max:255',
            
        ]);

        $title->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Título actualizado correctamente',
            'data' => $title
        ], 200);
    }

// eliminar registro
    public function destroy(Title $title)
    {
        $title->delete();
        return response()->json([
            'status' => true,
            'message' => 'Título eliminado correctamente'
        ], 200 );
    }
}