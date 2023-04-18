<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function registrar(Request $request){
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->pass = $request->pass;
        $usuario->administrador = $request->administrador;
        $usuario->save();
        return json_encode($usuario);
    }

    public function login(Request $request){
        $email = $request->email;
        $pass = $request->pass;

        // Busca el usuario con el email dado
        $usuario = Usuario::where('email', $email)->first();

        // Si no se encontró un usuario con el email dado, regresa un mensaje de error
        if (!$usuario) {
            return response()->json(['mensaje' => 'El usuario no existe'], 401);
        }

        // Verifica si la contraseña dada coincide con la contraseña del usuario
        if ($pass == $usuario->pass) {
            // Si la contraseña es correcta, devuelve el id_usuario
            //quiero devolver el id del usuario y la variable administrador
            return response()->json([
                'id_usuario' => $usuario->id_Usuario,
                'administrador' => $usuario->administrador,
                'nombre' => $usuario->nombre,
                'apellidos' => $usuario->apellidos
            ], 200);
        } else {
            // Si la contraseña no coincide, regresa un mensaje de error
            return response()->json(['mensaje' => 'La contraseña es incorrecta'], 401);
        }
    }

}
