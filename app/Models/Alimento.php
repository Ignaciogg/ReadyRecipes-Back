<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alimento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alimentos';

    public function ingredientes(){
        return $this->hasMany(Ingrediente::class, 'id_Alimento');
    }

    public function precios()
    {
        return $this->hasMany(Precio::class, 'id_Alimento');
    }
}