<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorito extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'favoritos';

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'id_Receta');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_Usuario');
    }
}
