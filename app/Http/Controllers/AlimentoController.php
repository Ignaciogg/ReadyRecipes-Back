<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alimento;

class AlimentoController extends Controller
{
    public function crear(Request $request) {
        /*$content = $request->getContent();*/
        /*$alimento_json = json_decode($content);*/

        $alimento = new Alimento();
        $alimento->nombre = $request->nombre;
        $alimento->nutriscore = $request->nutriscore;
        $alimento->save();
    }
    public function getAll() {
        $alimentos = Alimento::all();
        return json_encode($alimentos);
    }
}
