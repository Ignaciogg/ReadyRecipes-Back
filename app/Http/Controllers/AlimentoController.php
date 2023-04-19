<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alimento;

class AlimentoController extends Controller
{
    public function crear(Request $request) {
        $content = $request->getContent();
        $alimento_json = json_decode($content);

        $alimento = new Alimento();
        $alimento->nombre = $alimento_json->nombre;
        $alimento->nutriscore = $alimento_json->nutriscore;
        $alimento->save();
        echo $alimento;
    }
}