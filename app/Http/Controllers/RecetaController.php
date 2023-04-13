<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;

class RecetaController extends Controller
{
    public function create(Request $request) {
        $receta = new Receta();
        $receta -> nombre = $request -> nombre;
        $receta -> precio = $request -> precio;
        $receta -> save();
        return json_encode($receta);
    }

    public function getAll() {
        $recetas = Receta::all();
        return json_encode($recetas);
    }

    public function get($id) {
        $receta = Receta::find($id);
        return json_encode($receta);
    }

    public function delete($id) {
        $receta = Receta::find($id);
        $receta->delete();
        return json_encode($receta);
    }

    //NUEVAS FUNCIONES

    public function comentarios($id) {
        $receta = Receta::find($id);
        $comentarios = $receta->comentarios;
        return json_encode($comentarios);
    }

    public function nuevoComentario($id, $comentario) {
        $receta = Receta::find($id);
        $receta->comentarios()->create([
            'Comentario' => $comentario
        ]);
        return json_encode($receta);
    }

    
}
