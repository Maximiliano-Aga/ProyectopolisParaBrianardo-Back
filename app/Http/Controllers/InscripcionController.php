<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $inscripciones = Inscripcion::all();
            return response()->json($inscripciones);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener inscripciones', 'detalle' => $e->getMessage()], 500);
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
                'cicloLectivo' => 'required|date_format:Y',
                'estadoInscrip' => 'required|in:aprobada,rechazada,pendiente',
                'idUsuario' => 'required|int',
                'idMateria'=> 'required|int',
            ]);
            $inscripcion = Inscripcion::create($request->all());
            return response()->json($inscripcion, 201);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['error' => 'Error de validación', 'detalle' => $ve->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear inscripción', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $inscripcion = Inscripcion::findOrFail($id);
            return response()->json($inscripcion);
        
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'La inscripcion no existe', 'detalle' => $e->getMessage()], 404);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al mostrar inscripcion', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscripcion $inscripcion)
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
                'cicloLectivo' => 'required|date_format:Y',
                'estadoInscrip' => 'required|in:aprobada,rechazada,pendiente',
                'idUsuario' => 'required|int',
                'idMateria'=> 'required|int',
            ]);
            $inscripcion = Inscripcion::find($id);
            if (!$inscripcion) {
                return response()->json(['error' => 'Materia no encontrada'], 404);
            }
            $inscripcion->update($request->all());
            return response()->json($inscripcion, 200);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['error' => 'Error de validación', 'detalle' => $ve->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar inscripcion', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $inscripcion = Inscripcion::find($id);
            if (!$inscripcion) {
                return response()->json(['error' => 'Inscripcion no encontrada'], 404);
            }
            $inscripcion->delete();
            return response()->json(['mensaje' => 'Inscripcion eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar inscripcion', 'detalle' => $e->getMessage()], 500);
        }
    }

    public function inscripcionesPendientes() {
        try {
            $estado = 'pendiente';
            $inscripciones = Inscripcion::where('estadoInscrip', $estado)->with(['usuario', 'materia'])->get();
            return response()->json($inscripciones);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener inscripciones', 'detalle' => $e->getMessage()], 500);
        }
    }
}
