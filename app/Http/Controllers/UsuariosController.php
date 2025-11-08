<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $usuarios = User::all()->map(function ($usuario) {
                return [
                    'usDocumento' => $usuario->usDocumento,
                    'usApellido' => $usuario->usApellido,
                    'usNombre' => $usuario->usNombre,
                    'usTelefono' => $usuario->usTelefono,
                    'usDomicilio' => $usuario->usDomicilio,
                    'usLocalidad' => $usuario->usLocalidad,
                    'usMail' => $usuario->usMail,
                    "rol" => $usuario->getRoleNames(),
                ];
            });
            return response()->json($usuarios, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener usuarios', 'detalle' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $usuario = User::findOrFail($id);
            return response()->json([
                'usuario' => [
                    'usDocumento' => $usuario->usDocumento,
                    'usApellido' => $usuario->usApellido,
                    'usNombre' => $usuario->usNombre,
                    'usTelefono' => $usuario->usTelefono,
                    'usDomicilio' => $usuario->usDomicilio,
                    'usLocalidad' => $usuario->usLocalidad,
                    'usMail' => $usuario->usMail,
                    "rol" => $usuario->getRoleNames(),
                ],
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El usuario no existe', 'detalle' => $e->getMessage()], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al mostrar usuario', 'detalle' => $e->getMessage()], 500);
        }
    }
}
