<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\opcionesAdmin;
use Illuminate\Http\Request;

class OpcionesAdminController extends Controller
{
    public function getColores(){
        $colores = opcionesAdmin::all();
        return json_encode($colores);
    }

    public function setPrincipal(Request $request){
        $color = $request->color;
        $colorprincipal = opcionesAdmin::where('id', 1)->first();
        $colorprincipal->colorPrincipal = $color;
        $colorprincipal->save();
    }
    public function setClaro(Request $request){
        $color = $request->color;
        $colorprincipal = opcionesAdmin::where('id', 1)->first();
        $colorprincipal->colorPrincipalClaro = $color;
        $colorprincipal->save();
    }
    public function setSecundario(Request $request){
        $color = $request->color;
        $colorprincipal = opcionesAdmin::where('id', 1)->first();
        $colorprincipal->colorSecundario = $color;
        $colorprincipal->save();
    }

}
