<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingrediente extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ingredientes';

    public function receta()
    {
        return $this->belongsTo(Receta::class, 'id_Receta');
    }

    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'id_Alimento');
    }
}
