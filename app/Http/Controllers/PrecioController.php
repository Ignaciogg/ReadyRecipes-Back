<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrecioController extends Controller
{
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
