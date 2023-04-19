<?php

namespace App\Http\Controllers;

use App\Models\Alimento;
use Illuminate\Http\Request;
use App\Models\Ingrediente;

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
}
