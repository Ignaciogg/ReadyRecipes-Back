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

    public function alimento()
    {
        return $this->belongsTo(Alimento::class, 'id_Alimento');
    }
}
