<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\comentarios;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    public function comentariosUsuario(Request $request) {
        $id = $request->id_usuario;
        $comentarios_encontrados = comentarios::where('id_usuario', $id)->get();
        return json_encode($comentarios_encontrados);
    }

    public function comentariosReceta(Request $request) { //le pasamos por request un objeto receta
        $id = $request->id_Receta;
        $comentarios_encontrados = comentarios::where('id_receta', $id)->get();
        return json_encode($comentarios_encontrados);
    }

    public function nuevoComentario(Request $request) {

        $comentario = new comentarios();

        $comentario->id_receta = $request->id_receta;
        $comentario->id_usuario = $request->id_usuario;
        $comentario->contenido = $request->contenido;
        
        $comentario->save();

    }
}
