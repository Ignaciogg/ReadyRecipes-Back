<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\favoritos;
use App\Models\Ingredientes;
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
    public function buscarReceta(Request $request)
        {
            $categoria = $request->categoria;
            $nutriscore = $request->nutriscore;
            $ingredientes = $request->ingredientes;
            $id_alimentos = explode(',', $ingredientes);
            $precio = $request->precio;
            $favorito = $request->favorito;

            $query = DB::table('recetas')
                ->select('recetas.*')
                ->where('categoria', $categoria)
                ->where('nutriscore', $nutriscore);

            // Filtrar por los ingredientes
            foreach ($id_alimentos as $id_alimento) {
                $query->join('ingredientes', 'ingredientes.id_receta', '=', 'recetas.id')
                    ->join('alimentos', 'alimentos.id', '=', 'ingredientes.id_alimento')
                    ->where('alimentos.id', $id_alimento);
            }

            // Filtrar por el precio
            $query->join('ingredientes', 'ingredientes.id_receta', '=', 'recetas.id')
                ->join('alimentos', 'alimentos.id', '=', 'ingredientes.id_alimento')
                ->groupBy('recetas.id')
                ->havingRaw('SUM(alimentos.precio) <= ?', [$precio]);

            // Filtrar por si es favorita
            if ($favorito) {
                $query->join('favoritos', 'favoritos.id_receta', '=', 'recetas.id')
                    ->where('favoritos.id_usuario', auth()->id());
            }

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