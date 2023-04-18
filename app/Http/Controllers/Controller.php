<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Precio;
use App\Models\favoritos;
use App\Models\Ingredientes;
use Hamcrest\Arrays\IsArray;
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

    

    // categoria es varchar, ingredientes es array con los ids de los alimentos, nutriscore es varchar, precio es number, favorito es boolean
    public function buscarReceta(Request $request)
        {
            $query=Receta::query();

            if($request->categoria){
                $query= $query->where('recetas.categoria', $request->categoria);
            }

            if($request->nutriscore){
                $query=$query->where('recetas.nutriscore', '>=', $request->nutriscore);
            }
            
            if($request->ingredientes){
                $ids_alimentos = $request->ingredientes;
                $query= $query->select('recetas.id','recetas.titulo','recetas.categoria','recetas.nutriscore')
                        ->join('ingredientes as i', 'recetas.id', '=', 'i.id_receta')
                        ->whereIn('i.id_alimento', $ids_alimentos)
                        ->groupBy('recetas.id','recetas.titulo','recetas.categoria','recetas.nutriscore')
                        ->havingRaw('COUNT(DISTINCT i.id_alimento) = ?', [count($ids_alimentos)]);
            }

            if($request->precio){
                //$precio = new Precio();

                //$precio_alimentos=$precio->calcular_precio_alimentos($request->ingredientes);

                $subquery = $query->join('ingredientes as i2', 'recetas.id', '=', 'i2.id_receta')
                            ->join('alimentos as a', 'i2.id_alimento', '=', 'a.id')
                            ->join('precios as p', 'a.id', '=', 'p.id_alimento')
                            ->whereIn('a.id', explode(',',$request->ingredientes))
                            ->groupBy('recetas.id')
                            ->havingRaw('SUM(p.precio) <= ?', [$request->precio])
                            ->pluck('recetas.id');

                $query->whereIn('recetas.id', $subquery)
                        ->select('recetas.id','recetas.titulo','recetas.categoria','recetas.nutriscore');

            }

            if($request->favorito){
                $favorito=$request->favorito;
                if($favorito==true){
                    $query=$query->join('favoritos', 'favoritos.id_receta', '=', 'recetas.id')
                            ->join('usuarios', 'favoritos.id_usuario', '=', 'usuarios.id')
                            ->where('favoritos.id_usuario', $request->id_usuario)
                            ->select('recetas.id','recetas.titulo','recetas.categoria','recetas.nutriscore');
                    }
                
            }

            if($query->count()==0){
                return response()->json([
                    'message' => 'No existe la receta'
                ], 404);
            }

            return json_encode($query->get('id'));
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