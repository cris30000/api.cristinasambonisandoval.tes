<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
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

        $department=Department::included()
        ->filter()
        ->sort()
        ->getOrPaginate();
        

        //return response()->json($armyCorps);
        //version mejorarada
         return response()->json([
            'status' => true,
            'message' => 'Listado de departamentos',
            'data' => $department
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
            'nombreempresa' => 'required|max:255',
        ]);

        $department = Department::create($request->all());

        //return response()->json($armyCorp,201);
        return response()->json([
            'status' => true,
            'message' => 'Departamento creado correctamente',
            'data' => $department
        ], 201);
    }

    /**
     * MOSTRAR UN REGISTRO ESPECIFICO
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department) //si se pasa $id se utiliza la comentada
    {
       
     //si se pasa $id se utiliza la comentada
        // $armyCorp = ArmyCorp::with(['posts.user'])->findOrFail($id);
        // $armyCorp = ArmyCorp::with(['posts'])->findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Departamento encontrado correctamente',
            'data' => $department
        ], 200);
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'nombreempresa' => 'required|max:255',
            
        ]);

        $department->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Departamento actualizado correctamente',
            'data' => $department
        ], 200);
    }

// eliminar registro
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([
            'status' => true,
            'message' => 'Departamento eliminado correctamente'
        ], 200 );
    }
}