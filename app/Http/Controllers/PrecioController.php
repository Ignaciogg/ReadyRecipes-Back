<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Precio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrecioController extends Controller
{
    public function crear(Request $request){
        $content = $request->getContent();
        $precio_json = json_decode($content);
        $precio = new Precio();
        $precio->id_Alimento = $precio_json->id_Alimento;
        $precio->precio = $precio_json->precio;
        $precio->supermercado = $precio_json->supermercado;
        $precio->save();
        echo $precio;
    }
    //

    /*public function calcular_precio_receta($receta){
        $precio = DB::table('recetas')
                    ->join('ingredientes', 'recetas.id', '=', 'ingredientes.id_receta')
                    ->join('alimentos', 'ingredientes.id_alimento', '=', 'alimentos.id')
                    ->join('precios', 'alimentos.id', '=', 'precios.id_alimento')
                    ->where('ingredientes.id_receta', $receta->id)
                    ->where('alimentos.id','ingredientes.id_alimento')
                    ->where('alimentos.id', 'precios.id_alimento')
                    ->havingRaw('SUM(precios.precio)')->first()->precio;

        return $precio;
    }*/
}
