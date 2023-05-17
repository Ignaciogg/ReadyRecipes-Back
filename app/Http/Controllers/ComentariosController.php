<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Receta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentariosController extends Controller
{
    public function comentariosUsuario($id) {
        $comentarios_encontrados = Comentario::where('id_usuario', $id)->get();
        return json_encode($comentarios_encontrados);
    }

    public function comentariosReceta($id) { //le pasamos por request un objeto receta
        $receta = Receta::find($id);

        $comentarios_encontrados = $receta->comentarios;

        /*$resultado = DB::table('comentarios')
            ->join('recetas', 'recetas.id', '=', 'comentarios.id_Receta')
            ->join('usuarios', 'usuarios.id', '=', 'comentarios.id_Usuario')
            ->select('usuarios.nombre', 'usuarios.apellidos', 'comentarios.contenido')
            ->where('comentarios.id_Receta', $id_receta)
            ->get();*/
        

        return json_encode($comentarios_encontrados);
    }

    public function nuevoComentario(Request $request) {

        $comentario = new Comentario();

        $comentario->id_Receta = $request->id_receta;
        $comentario->id_Usuario = $request->id_usuario;
        $comentario->contenido = $request->contenido;
        
        $comentario->save();

    }
}
