<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;

class RecetaController extends Controller
{
    public function crear(Request $request) {
        $content = $request->getContent();
        $receta_json = json_decode($content);

        $receta = new Receta();
        $receta->url = $receta_json->url;
        $receta->titulo = $receta_json->titulo;
        $receta->texto = $receta_json->texto;
        $receta->categoria = $receta_json->categoria;
        $receta->nutriscore = $receta_json->nutriscore;
        $receta->comentarios = $receta_json->comentarios;
        $receta->sentimiento = $receta_json->sentimiento;
        $receta->comentarios_positivos = $receta_json->comentarios_positivos;
        $receta->comentarios_neutros= $receta_json->comentarios_neutros;
        $receta->comentarios_negativos = $receta_json->comentarios_negativos;
        $receta->save();
        echo $receta;
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
