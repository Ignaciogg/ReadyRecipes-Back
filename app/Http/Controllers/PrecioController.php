<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Precio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrecioController extends Controller
{
    public function crear(Request $request){
        $content = $request->getContent();
        $precio_json = json_decode($content);

        $precio = new Precio();
        $precio->id_Alimento = $precio_json->id_Alimento;
        $precio->precio = $precio_json->precio;
        $precio->supermercado = $precio_json->supermercado;
        $precio->save();
    }
}
