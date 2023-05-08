<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\AlimentoController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\PrecioController;
use App\Http\Controllers\UsuarioController;
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


//Route::post('recetas/create', [RecetaController::class , 'create']);
// Route::get('receta/{id}', [RecetaController::class , 'get']);
//Route::delete('receta/{id}', [RecetaController::class , 'delete']);

///////////////////// READY RECIPES //////////////////////

//RECETAS
Route::post('receta', [RecetaController::class, 'obtenerReceta']);
Route::post('buscador', [RecetaController::class, 'buscarReceta']);
Route::post('nuevaReceta', [RecetaController::class, 'crear']); // hecho
Route::get('recetas/getAll', [RecetaController::class , 'getAll']);
Route::post('modificarReceta', [RecetaController::class, 'modificarReceta']);
Route::post('recetasPorCategoria', [RecetaController::class, 'recetasPorCategoria']);
Route::post('recetasPorNutriscore', [RecetaController::class, 'recetasPorNutriscore']);

//COMENTARIOS
Route::post('comentariosUsuario', [ComentariosController::class, 'comentariosUsuario']);
Route::post('nuevoComentario', [ComentariosController::class, 'nuevoComentario']);
Route::post('comentariosReceta', [ComentariosController::class, 'comentariosReceta']);
Route::post('numeroComentarios', [ComentariosController::class, 'numeroComentarios']); //hecho

//USUARIOS
Route::post('login', [UsuarioController::class, 'login']); // hecho
Route::get('logout', [UsuarioController::class, 'logout']);
Route::post('registro', [UsuarioController::class, 'registrar']); // hecho
Route::post('infoUsuario', [UsuarioController::class, 'infoUsuario']);
Route::post('eliminarUsuario', [UsuarioController::class, 'eliminarUsuario']);
Route::post('numeroUsuarios', [UsuarioController::class, 'numeroUsuarios']); //hecho
Route::post('me', [UsuarioController::class, 'me']); //hecho

//FAVORITOS
Route::post('addFavoritos', [FavoritoController::class, 'addFavoritos']); // hecho
Route::delete('removeFavoritos/{id_receta}/{id_usuario}',[FavoritoController::class, 'removeFavoritos']); // hecho

//INGREDIENTES
Route::post('ingredientes', [IngredienteController::class, 'ingredientes']); // hecho
Route::post('nuevoIngrediente', [IngredienteController::class, 'crear']); // hecho

//ALIMENTOS
Route::post('nuevoAlimento', [AlimentoController::class, 'crear']); // hecho
Route::get('alimentos', [AlimentoController::class, 'getAll']);

//PRECIOS
Route::post('nuevoPrecio', [PrecioController::class, 'crear']); // hecho

//Cifrar passwords
Route::post('actualizarPasswords', [UsuarioController::class, 'actualizarPasswords']); //hecho

Route::middleware('auth')->get('/dashboard', function () {
    return view('dashboard');
});

//test para middleware que me devuelve el usuario logeado
Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

//test para middlewrare que me devuelve si el usuario es admin
Route::middleware('admin')->get('/admin', function (Request $request) {
    return "El usuario es admin";
});
