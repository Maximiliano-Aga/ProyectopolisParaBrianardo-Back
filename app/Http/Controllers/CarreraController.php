<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $carreras = Carrera::all();
            return response()->json($carreras);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener carreras', 'detalle' => $e->getMessage()], 500);
        }
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
        try {
            $request->validate([
                'carNombre' => 'required|string|max:255|regex:/^[\pL\s]+$/u'
            ]);
            $carrera = Carrera::create([
                "carNombre" => $request->carNombre
            ]);
            return response()->json($carrera, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al crear carrera', 'detalle' => $e->getMessage()], 500);
        }catch (ValidationException $ve) {
            return response()->json(['error' => 'Error de validación', 'detalle' => $ve->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $carrera = Carrera::findOrFail($id);
            return response()->json($carrera);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Carrera no encontrada', 'detalle' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al mostrar carrera', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carrera $carrera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'carNombre' => 'required|string|max:255|regex:/^[\pL\s]+$/u'
            ]);
            $carrera = Carrera::find($id);
            if (!$carrera) {
                return response()->json(['error' => 'Carrera no encontrada'], 404);
            }
            $carrera->update($request->all());
            return response()->json($carrera, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al actualizar carrera', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $carrera = Carrera::find($id);
            if (!$carrera) {
                return response()->json(['error' => 'Carrera no encontrada'], 404);
            }
            $carrera->delete();
            return response()->json(['mensaje' => 'Carrera eliminada'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al eliminar carrera', 'detalle' => $e->getMessage()], 500);
        }
    }

    public function carrerasConMaterias()
    {
        try {
            $carreras = Carrera::with("materias")->get();
            return response()->json($carreras);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener carreras con materias', 'detalle' => $e->getMessage()], 500);
        }
    }
}
