<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;
use App\Models\Ingrediente;
use Illuminate\Support\Facades\DB;

class IngredienteController extends Controller
{
    public function crear(Request $request)
    {
        $content = $request->getContent();
        $ingrediente_json = json_decode($content);
        $id_Alimento = Alimento::select('id')->where('nombre', $ingrediente_json->nombre)->first()->id;
        $ingrediente = new Ingrediente();
        $ingrediente->id_Receta = $ingrediente_json->id_Receta;
        $ingrediente->id_Alimento = $id_Alimento;
        $ingrediente->save();
        echo $ingrediente;
    }
    public function ingredientes() {
        $nombres_ingredientes = DB::table('alimentos')->select('id', 'nombre', 'nutriscore')->get();
        return json_encode($nombres_ingredientes);
    }
}
