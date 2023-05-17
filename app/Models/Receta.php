<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recetas';

    public function ingredientes()
    {
        return $this->hasMany(Ingrediente::class, 'id_Receta');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_Receta');
    }

    public function favoritos()
    {
        return $this->hasMany(Favorito::class, 'id_Receta');
    }

    public function calcularPrecio(){
        $precio_total=0;
        foreach($this->ingredientes as $ingrediente){
            $precio_total += $ingrediente->alimento->precios[0]->precio;
        }
        return $precio_total;
    }

}
