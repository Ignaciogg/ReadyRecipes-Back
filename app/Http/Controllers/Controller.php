<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\favoritos;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /////////////////// READY RECIPES //////////////////////

    // Recuperar info de una receta (nº de comentarios de YT (positivos, negativos, neutros)), nutriscore, precio
    public function receta($id) {
        $receta = Receta::find($id);
        return json_encode($receta);
    }

    public function calcular_precio($alimentos){
        $precio=0;
        foreach($alimentos as $alimento){
            $precio+=$alimento->precio;
        }
        return $precio;
    }

    // categoria es varchar, ingredientes es array con los ids de los alimentos, nutriscore es varchar, precio es number, favorito es boolean
    public function buscarReceta(Request $request) {
            $categoria = $request->categoria;
            $nutriscore = $request->nutriscore;
            $ingredientes = $request->ingredientes;
            $precio = $request->precio;
            $favorito = $request->favorito;


            // Crear la consulta base
            $query = Receta::query()->where('categoria', $categoria)->where('nutriscore', $nutriscore);


            // Filtrar por los ingredientes
            /*foreach ($ingredientes as $id_alimento) {
                $query->whereHas('ingredientes', function ($q) use ($id_alimento) {
                    $q->where('id_alimento', $id_alimento);
                });
            }*/

            // Filtrar por el precio
            /*$query->with('ingredientes.alimento');
            $precioTotal = 0;
            foreach ($query->get() as $receta) {
                $precioTotal = $receta->ingredientes->sum(function ($ingrediente) {
                    return $ingrediente->cantidad * $ingrediente->alimento->precio;
                });
                if ($precioTotal <= $precio) {
                    $query = $query->where('id', $receta->id);
                    break;
                }
            }

            // Filtrar por si es favorita
            if ($favorito) {
                $query->whereHas('favoritos', function ($q) {
                    $q->where('id_usuario', auth()->id());
                });
            }*/
            

            // Obtener la receta
            $receta = $query->get();
            
            return $receta;
    }
    
    // Cerrar sesion
    public function logout() {

    }

    // Obtener lista de todos los ingredientes para el buscador
    public function ingredientes() {
        $nombres_ingredientes = DB::table('alimentos')->select('id', 'nombre', 'nutriscore')->get();
        return json_encode($nombres_ingredientes);
    }
}