<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\comentarios;
use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    public function comentarios(Request $request) {
        $id = $request->id;
        $comentario_encontrado = comentarios::find($id);
        $comentario_contenido = $comentario_encontrado->contenido;
        return json_encode($comentario_contenido);
    }

    public function nuevoComentario(Request $request) {

        $comentario = new comentarios();

        $comentario->id_receta = $request->id_receta;
        $comentario->id_usuario = $request->id_usuario;
        $comentario->contenido = $request->contenido;
        
        $comentario->save();

    }
}
