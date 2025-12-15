<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Inscripcion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Symfony\Polyfill\Intl\Idn\Idn;
use App\Models\User;
use Exception;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $materias = Materia::with('carrera')->get(); // Load related carrera
            return response()->json($materias);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener materias', 'detalle' => $e->getMessage()], 500);
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
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'matNombre' => [
                    'required',
                    'string',
                    'max:255',
                     // Solo letras y espacios
                ],
                'carrera_id' => 'required|exists:carreras,id',
            ]);
            $materia = Materia::create($request->all());
            return response()->json($materia, 201);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['error' => 'Error de validación', 'detalle' => $ve->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear materia', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $materia = Materia::findOrFail($id);
            return response()->json($materia);
        
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'La materia no existe', 'detalle' => $e->getMessage()], 404);
        
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al mostrar materia', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materia $materia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'nombre' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[\pL\s]+$/u' // Solo letras y espacios
                ],
                'carrera_id' => 'sometimes|required|exists:carreras,id',
            ]);
            $myMateria = Materia::find($id);
            if (!$myMateria) {
                return response()->json(['error' => 'Materia no encontrada'], 404);
            }
            if ($request->has('nombre')) {
                $myMateria->nombre = $request->nombre;
            }
            if ($request->has('carrera_id')) {
                $myMateria->carrera_id = $request->carrera_id;
            }
            $myMateria->save();
            return response()->json($myMateria, 200);
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return response()->json(['error' => 'Error de validación', 'detalle' => $ve->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar materia', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $myMateria = Materia::find($id);
            if (!$myMateria) {
                return response()->json(['error' => 'Materia no encontrada'], 404);
            }
            $myMateria->delete();
            return response()->json(['mensaje' => 'Materia eliminada'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar materia', 'detalle' => $e->getMessage()], 500);
        }
    }

    public function getMateriasPorUsuario($userId)
    {
        try {
            // Verificar que el usuario exista
            User::findOrFail($userId);
        
            // Obtener materias a las que está inscripto
            $materias = Materia::whereIn('id', function ($query) use ($userId) {
                    $query->select('idMateria')
                            ->from('inscripciones')
                            ->where('idUsuario', $userId)
                          ->where('estadoInscrip', 'aprobada'); // opcional
                })
                ->select([
                    'id',
                    'matNombre',
                    'carrera_id',
                    'created_at',
                    'updated_at'
                ])
                ->get();
                
            return response()->json($materias, 200);
                
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Usuario no encontrado.'
            ], 404);
        
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al obtener las materias',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}

