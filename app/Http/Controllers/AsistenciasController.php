<?php

namespace App\Http\Controllers;

use App\Models\asistencias;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $asistencias = asistencias::all();
            return response()->json($asistencias);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener aistencias', 'detalle' => $e->getMessage()], 500);
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
                'asisFecha' => 'required',
                'asisJustificada' => 'required|boolean',
                'idEstadoAsist' => 'required|int',
                'idInscripcion'=> 'required|int',
            ]);
            $asistencia = asistencias::create($request->all());
            return response()->json($asistencia, 201);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['error' => 'Error de validación', 'detalle' => $ve->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear asistencia', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $asistencia = asistencias::findOrFail($id);
            return response()->json($asistencia);
        
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'La asistencia no existe', 'detalle' => $e->getMessage()], 404);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al mostrar asistencia', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(asistencias $asistencias)
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
                'asisFecha' => 'required',
                'asisJustificada' => 'required|boolean',
                'idEstadoAsist' => 'required|int',
                'idInscripcion'=> 'required|int',
            ]);
            $asistencia = asistencias::find($id);
            if (!$asistencia) {
                return response()->json(['error' => 'Asistencia no encontrada'], 404);
            }
            $asistencia->update($request->all());
            return response()->json($asistencia, 200);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['error' => 'Error de validación', 'detalle' => $ve->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar asistencia', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $asistencia = asistencias::find($id);
            if (!$asistencia) {
                return response()->json(['error' => 'Asistencia no encontrada'], 404);
            }
            $asistencia->delete();
            return response()->json(['mensaje' => 'Asistencia eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar asistencia', 'detalle' => $e->getMessage()], 500);
        }
    }
}
