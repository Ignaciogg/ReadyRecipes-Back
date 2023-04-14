<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\favoritos;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    // Añadir la receta a favoritos
    public function addFavoritos($id_receta, $id_usuario) {
        $favorito=new favoritos();

        $favorito->id_receta=$id_receta;
        $favorito->id_usuario=$id_usuario;

        $favorito->save();
        
    }

    // Eliminar la receta de favoritos
    public function removeFavoritos($id_receta, $id_usuario) {
        $favorito=favoritos::where('id_receta',$id_receta)->where('id_usuario',$id_usuario)->first();
        $favorito->delete();

    }
}
