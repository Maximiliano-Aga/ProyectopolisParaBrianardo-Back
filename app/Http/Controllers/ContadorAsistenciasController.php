<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\asistencias;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ContadorAsistenciasController extends Controller
{
    /**
     * Obtiene el resumen consolidado de asistencias, faltas y tardanzas 
     * para un alumno (usuario) específico, opcionalmente filtrado por materia.
     * * @param Request $request La solicitud que contiene 'userId' y opcionalmente 'materiaId'.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSummary($userId, $materiaId)
{
    try {
        $user = User::findOrFail($userId);

        $inscripcionesQuery = $user->inscripciones()
            ->where('estadoInscrip', 'aprobada');

        if ($materiaId) {
            $inscripcionesQuery->where('idMateria', $materiaId);
        }

        $inscripcionIds = $inscripcionesQuery->pluck('idInscripciones');

        if ($inscripcionIds->isEmpty()) {
            return response()->json([
                'alumno_id' => $userId,
                'nombre' => $user->usNombre . ' ' . $user->usApellido,
                'mensaje' => 'No tiene registros de asistencia.',
                'resumen_asistencias' => [
                    'presente' => 0,
                    'faltas' => 0,
                    'tardanzas' => 0,
                    'total_registros' => 0,
                ]
            ], 200);
        }

        $stats = asistencias::whereIn('idInscripcion', $inscripcionIds)
            ->selectRaw('
                COUNT(CASE WHEN estadoAsistencia = "Presente" THEN 1 END) as presente,
                COUNT(CASE WHEN estadoAsistencia = "Ausente" THEN 1 END) as faltas,
                COUNT(CASE WHEN estadoAsistencia = "Llegada Tarde" THEN 1 END) as tardanzas,
                COUNT(*) as total_registros
            ')
            ->first();

        return response()->json([
            'alumno_id' => $userId,
            'nombre' => $user->usNombre . ' ' . $user->usApellido,
            'resumen_asistencias' => [
                'presente' => (int) $stats->presente,
                'faltas' => (int) $stats->faltas,
                'tardanzas' => (int) $stats->tardanzas,
                'total_registros' => (int) $stats->total_registros,
            ]
        ], 200);

    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Usuario no encontrado.'], 404);
    } catch (Exception $e) {
        return response()->json([
            'error' => 'Error al obtener el contador de asistencia',
            'detalle' => $e->getMessage()
        ], 500);
    }
}

}