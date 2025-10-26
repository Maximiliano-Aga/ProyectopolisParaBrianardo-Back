<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'usMail' => 'required|string|email|unique:users',
                'usPassword' => 'required|string|min:8',
                'rol' => 'required|in:admin,profesor,estudiante',
                'usDocumento' => 'required|string|unique:users',
                'usApellido' => 'required|string',
                'usNombre' => 'required|string',
                'usTelefono' => 'required|string',
                'usDomicilio' => 'required|string',
                'usLocalidad' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $user = User::create([
                'usDocumento' => $request->usDocumento,
                'usApellido' => $request->usApellido,
                'usNombre' => $request->usNombre,
                'usTelefono' => $request->usTelefono,
                'usDomicilio' => $request->usDomicilio,
                'usLocalidad' => $request->usLocalidad,
                'usMail' => $request->usMail,
                'usPassword' => Hash::make($request->usPassword),
            ]);

            $user->assignRole($request->rol);

            return response()->json([
                'token' => $user->createToken('API Token')->plainTextToken,
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usMail' => 'required|string|email',
            'usPassword' => 'required|string|min:8',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::where('usMail', $request->usMail)->with('roles')->first();

        if (!$user || !Hash::check($request->usPassword, $user->usPassword)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Obtén solo los nombres de los roles

       // Revoke old tokens to ensure only one active token per login for simplicity
$user->tokens()->delete();
$token = $user->createToken('auth_token')->plainTextToken;
return response()->json([
'access_token' => $token,
'token_type' => 'Bearer',
'user' => $user,
'roles' => $user->getRoleNames(), // Get roles
]);

}

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);

    }
}