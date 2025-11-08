<?php

namespace App\Http\Controllers;

use App\Models\estadosAsistencia;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class EstadosAsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      try {
            $estadosAsistencia = estadosAsistencia::all();
            return response()->json($estadosAsistencia);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener estados de asistencias', 'detalle' => $e->getMessage()], 500);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($idEstados_Asist)
    {
        try {
            $estadosAsistencia = estadosAsistencia::findOrFail($idEstados_Asist);
            return response()->json($estadosAsistencia);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'estado de asistencia no encontrado', 'detalle' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al mostrar estado de asistencia', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(estadosAsistencia $estadosAsistencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, estadosAsistencia $estadosAsistencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(estadosAsistencia $estadosAsistencia)
    {
        //
    }
}
