<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Precio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'precios';

    public function calcular_precio_alimentos($alimentos){
        $precio=0;
        $alimentos_div=explode(',', $alimentos);
        foreach($alimentos_div as $alimento){
            $precio+=DB::table('precios')
                    ->join('alimentos', 'precios.id_alimento', '=', 'alimentos.id')
                    ->where('alimentos.id', $alimento)
                    ->first()->precio;
        }
        return $precio;
    }
}
