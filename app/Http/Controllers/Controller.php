<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Precio;
use App\Models\favoritos;
use App\Models\Ingredientes;
use Hamcrest\Arrays\IsArray;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

}