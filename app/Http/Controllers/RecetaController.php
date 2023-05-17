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
    }

    public function getAll(){
        $recetas = Receta::all();
        return json_encode($recetas);
    }

    public function obtenerReceta($id){
        $receta = Receta::find($id);
        $ingredientes=$receta->ingredientes;

        if ($receta) {
            $receta->ingredientes = $ingredientes;
            $receta->precio = $receta->calcularPrecio();
            $alimentos = [];
            foreach($ingredientes as $ingrediente){
                array_push($alimentos, $ingrediente->alimento->nombre);
            }
            unset($receta->ingredientes);
            $receta->ingredientes = $alimentos;
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

            if($request->favorito){
                $favorito=$request->favorito;
                if($favorito==true){
                    $query=$query->join('favoritos', 'favoritos.id_receta', '=', 'recetas.id')
                            ->join('usuarios', 'favoritos.id_usuario', '=', 'usuarios.id')
                            ->where('favoritos.id_usuario', $request->id_usuario)
                            ->select('recetas.id','recetas.titulo','recetas.categoria','recetas.nutriscore');
                    }

            }


            $recetas=$query->get();


            if($request->precio){
                foreach($recetas as $receta){
                    if ($receta->precio > $request->precio){
                        unset($recetas[$receta->id]);
                    }
                }

                /*$id_recetas=Receta::pluck('id');

                for ($i=0; $i < count($id_recetas); $i++) {
                    $precio_total = DB::table('recetas')->join('ingredientes as i', 'recetas.id', '=', 'i.id_Receta')
                    ->join('alimentos as a', 'i.id_Alimento', '=', 'a.id')
                    ->join('precios as p', 'a.id', '=', 'p.id_Alimento')
                    ->where('recetas.id', $id_recetas[$i])
                    ->sum('p.precio');


                    if($precio_total>$request->precio){
                        unset($id_recetas[$i]);
                    }
                }

                $query=$query->whereIn('recetas.id', $id_recetas)
                        ->select('recetas.id','recetas.titulo','recetas.categoria','recetas.nutriscore');
                        //->take(10);*/

            }



            if($recetas->count()==0){
                return response()->json([
                    'message' => 'No existe la receta'
                ], 404);
            }


            return json_encode($recetas);
        }

    public function modificarReceta(Request $request) {
        $actual = Receta::find($request->id);
        if($request->titulo != $actual->titulo && $request->titulo != "" && $request->titulo != null) {
            $actual->titulo = $request->titulo;
        }
        if($request->texto != $actual->texto && $request->texto != "" && $request->texto != null) {
            $actual->texto = $request->texto;
        }
        if($request->categoria != $actual->categoria && $request->categoria != "" && $request->categoria != null) {
            $actual->categoria = $request->categoria;
        }
        // $receta->url = $receta_json->url; // No se modifica en el front
        // $receta->nutriscore = $receta_json->nutriscore; // No se modifica en el front
        // $receta->comentarios = $receta_json->comentarios; // No se modifica en el front
        // $receta->sentimiento = $receta_json->sentimiento; // No se modifica en el front
        // $receta->comentarios_positivos = $receta_json->comentarios_positivos; // No se modifica en el front
        // $receta->comentarios_neutros= $receta_json->comentarios_neutros; // No se modifica en el front
        // $receta->comentarios_negativos = $receta_json->comentarios_negativos; // No se modifica en el front
        $actual->save();
    }

    public function recetasPorCategoria()
    {
        $recetasPorCategoria = DB::table('recetas')
            ->select('categoria', DB::raw('count(*) as total'))
            ->groupBy('categoria')
            ->get();
        return response()->json($recetasPorCategoria);
    }

    public function recetasPorNutriscore() {
        $recetasPorPrecio = DB::table('recetas')
        ->select(DB::raw('ROUND(nutriscore, 1) AS nutriscore_rounded'), DB::raw('COUNT(*) as total'))
            ->groupBy('nutriscore')
            ->having('total', '>', 2)
            ->get();
        return response()->json($recetasPorPrecio);
    }
}
