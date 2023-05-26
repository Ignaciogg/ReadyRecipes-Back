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

            $recetas=Receta::query();

            /*if($request->categoria){
                $recetas= $recetas->where('categoria', $request->categoria);
            }

            if($request->nutriscore){
                $recetas=$recetas->where('nutriscore', '>=', $request->nutriscore);
            }

            if($request->ingredientes){
            
                $recetas=$recetas->whereHas('ingredientes', function($query) use ($request){
                    $query->whereIn('id_alimento', $request->ingredientes);}, '=', count($request->ingredientes));
            }

            if($request->favorito){
                $favorito=$request->favorito;
                if($favorito==true){
                    $recetas = $recetas->whereHas('favoritos', fn($query) => $query->where('id_usuario', $request->id_usuario));
                    }
            }*/

            //$recetas=$recetas->get();

            if($request->precio){

                foreach($recetas as $receta){
                    $receta->precio=$receta->calcularPrecio();
                    if($receta->precio > $request->precio){
                        $recetas->except($receta->id);
                    }
                }
            }

            if($recetas->count()==0){
                return response()->json([
                    'message' => 'No existe la receta'
                ], 404);
            }


            return json_encode($recetas->get());
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
