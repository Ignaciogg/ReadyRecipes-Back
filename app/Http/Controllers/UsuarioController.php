<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller
{
    public function registrar(Request $request)
    {
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->pass = hash('sha256', $request->pass);
        $usuario->administrador = $request->administrador;
        $usuario->save();
        return json_encode($usuario);
    }

    public function login(Request $request)
    {

        $email = $request->email;
        $pass = hash('sha256', $request->pass);

        // Busca el usuario con el email dado
        $usuario = Usuario::where('email', $email)->first();

        // Si no se encontró un usuario con el email dado, regresa un mensaje de error
        if (!$usuario) {
            return response()->json(['mensaje' => 'El usuario no existe'], 401);
        }

        // Verifica si la contraseña dada coincide con la contraseña del usuario
        if ($pass == $usuario->pass) {
            // Si la contraseña es correcta, devuelve el token
            $token = auth()->login($usuario);
        } else {
            // Si la contraseña no coincide, regresa un mensaje de error
            return response()->json(['mensaje' => 'La contraseña es incorrecta'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function actualizarPasswords()
    {
        $usuarios = Usuario::all();
        foreach ($usuarios as $usuario) {
            $usuario->pass = hash('sha256', $usuario->pass);
            $usuario->save();
        }
    }
}
