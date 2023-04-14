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

    public function saludo(Request $request) {
        return json_encode("HOLA, ".$request->nombre);
    }

    public function saludo2(Request $nombre) {
        return json_encode("HOLAAAAAA, ".$nombre->nombre);
    }

    public function bienvenida(Request $nombre, $edad) {
        if($edad < 18) {
            return json_encode("No eres mayor de edad, ".$nombre->nombre);
        } else {
            return json_encode("Bienvenido, ".$nombre->nombre);
        }
    }

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

    // categoria es varchar, ingredientes es array, nutriscore es number, precio es number, favorito es boolean
    public function buscador($categoria, $ingredientes, $nutriscore, $precio, $favorito,$id_usuario) {
        $precio=$this->calcularprecio($ingredientes);

        $results = DB::table('recetas')
            ->join('ingredientes', 'recetas.id', '=', 'ingredientes.id')
            ->join('alimentos', 'alimento.id', '=', 'ingredientes.id')
            ->select('recetas.id','recetas.nombre','recetas.categoria','recetas.nutriscore','recetas.precio', 'alimentos.nombre')
            ->where('recetas.categoria', '=', $categoria)
            ->where('recetas.nutriscore', '=', $nutriscore)
            ->where('recetas.precio', '<=', $precio);

        if ($favorito) {
            $results->join('favoritos', 'favoritos.id_Receta', '=', 'recetas.id')
                    ->join('usuarios', 'favoritos.id_Usuario', '=', $id_usuario)

        }
    
        // Agrega las condiciones para los ingredientes
        foreach ($ingredientes as $ingrediente) {
            $results->where('alimentos.nombre', '=', $ingrediente);
        }
    
        // Ejecuta la consulta y devuelve los resultados
        $results2 = $results->get();
        return json_encode($results2);
    

    }

    

    // Cerrar sesion
    public function logout() {

    }


    // Obtener lista de todos los ingredientes para el buscador
    public function ingredientes() {
        $nombres_ingredientes = DB::table('alimentos')->pluck('nombre');
        return $nombres_ingredientes;
    }
}
