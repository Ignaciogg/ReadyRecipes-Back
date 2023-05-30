<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{ 
    // Añadir la receta a favoritos
    public function addFavoritos($id_receta) {
        if(Auth::check()){
            $favorito=new Favorito();
            $favorito->id_receta=$id_receta;
            $user = Auth::user();
            $favorito->id_usuario=$user->id;
            $favorito->save();
            return response()->json([
                'message' => 'Favorito añadido correctamente'
            ], 200);
        }else{
            return response()->json([
                'message' => 'No se ha podido añadir el favorito'
            ], 404);
        }
    }

    // Eliminar la receta de favoritos
    public function removeFavoritos($id_receta) {
        if(Auth::check()){
            $user = Auth::user();
            $favorito=Favorito::where('id_receta', $id_receta)->where('id_usuario', $user->id)->first();

            if(!$favorito){ 
                return response()->json([
                    'message' => 'No existe el favorito'
                ], 404);
            }else{
                $favorito->delete();
                return response()->json([
                    'message' => 'Favorito eliminado correctamente'
                ], 200);
            }
        }else{
            return response()->json([
                'message' => 'No se ha podido eliminar el favorito'
            ], 404);
        }
    }

    public function esFavorito($id_receta) {
        $user = Auth::user();
        $favorito = Favorito::where('id_receta', $id_receta)->where('id_usuario', $user->id)->exists();
        return $favorito ? "1" : "0";
    }
}
