<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingrediente;

class IngredienteController extends Controller
{
    public function crear(Request $request)
    {
        $content = $request->getContent();
        $ingrediente_json = json_decode($content);

        $ingrediente = new Ingrediente();
        $ingrediente->id_Receta = $ingrediente_json->id_Receta;
        $ingrediente->id_Alimento = $ingrediente_json->id_Alimento;
        $ingrediente->save();
        echo $ingrediente;
    }
}