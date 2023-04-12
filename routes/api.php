<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RecetaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("saludo", [Controller::class, "saludo"]);
Route::get("saludo2/{nombre}", [Controller::class, "saludo2"]);
Route::post("bienvenida/{edad}", [Controller::class, "bienvenida"]);

Route::post('recetas/create', [RecetaController::class , 'create']);
Route::get('recetas/getAll', [RecetaController::class , 'getAll']);
// Route::get('receta/{id}', [RecetaController::class , 'get']);
Route::delete('receta/{id}', [RecetaController::class , 'delete']);

///////////////////// READY RECIPES //////////////////////

Route::get('receta/{id}', [Controller::class, 'receta']);
Route::get('comentarios/{id}', [Controller::class, 'comentarios']);
Route::post('nuevoComentario/{id}/{comentario}', [Controller::class, 'nuevoComentario']);
Route::get('buscador/{categoria}/{ingredientes}/{nutriscore}/{precio}/{favorito}', [Controller::class, 'buscador']);
Route::post('login', [UsuarioController::class, 'login']); //hecho
Route::get('logout', [Controller::class, 'logout']);
Route::post('registro', [UsuarioController::class, 'registrar']); //hecho
Route::get('addFavoritos/{id}', [Controller::class, 'addFavoritos']);
Route::get('removeFavoritos/{id}', [Controller::class, 'removeFavoritos']);
Route::get('ingredientes', [Controller::class, 'ingredientes']);
