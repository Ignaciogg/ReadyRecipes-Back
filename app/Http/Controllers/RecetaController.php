<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;
use Illuminate\Support\Facades\DB;

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

    public function getAll(){
        $recetas = DB::table('recetas')->select('id','url','titulo','texto','categoria','nutriscore','comentarios','sentimiento','comentarios_positivos','comentarios_neutros','comentarios_negativos')->get();
        return json_encode($recetas);
    }

    public function obtenerReceta(Request $request){
        $id=$request->id_receta;
        $receta = Receta::find($id);

        $ingredientes=$receta->join('ingredientes as i', 'recetas.id', '=', 'i.id_receta')
                            ->join('alimentos as a', 'i.id_alimento', '=', 'a.id')
                            ->where('i.id_receta', $id)
                            ->select('i.id_alimento','a.nombre')->get();

        $precio_total = $receta->join('ingredientes as i', 'recetas.id', '=', 'i.id_receta')
                        ->join('alimentos as a', 'i.id_alimento', '=', 'a.id')
                        ->join('precios as p', 'a.id', '=', 'p.id_alimento')
                        ->where('i.id_receta', $id)
                        ->sum('p.precio');
                        

        if ($receta) {
            $receta->ingredientes = $ingredientes;
            $receta->precio = $precio_total;

            return json_encode($receta);
        } else {

            return json_encode(['error' => 'No se encontraron registros']);
        }
    }

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

                $subquery = $query->join('ingredientes as i2', 'recetas.id', '=', 'i2.id_receta')
                            ->join('alimentos as a', 'i2.id_alimento', '=', 'a.id')
                            ->join('precios as p', 'a.id', '=', 'p.id_alimento')
                            ->groupBy('recetas.id','recetas.id','recetas.titulo','recetas.categoria','recetas.nutriscore')
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

            return json_encode($query->get());
        }

}
