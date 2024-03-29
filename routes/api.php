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
use App\Http\Controllers\OpcionesAdminController;
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
Route::get('receta/{id}', [RecetaController::class, 'obtenerReceta']);
Route::post('buscador', [RecetaController::class, 'buscarReceta']);
Route::post('nuevaReceta', [RecetaController::class, 'crear']); // hecho
Route::get('recetas/getAll', [RecetaController::class , 'getAll']);
Route::middleware('admin')->post('modificarReceta', [RecetaController::class, 'modificarReceta']);
Route::middleware('admin')->post('recetasPorCategoria', [RecetaController::class, 'recetasPorCategoria']);
Route::middleware('admin')->post('recetasPorNutriscore', [RecetaController::class, 'recetasPorNutriscore']);
Route::get('actualizarPrecios', [RecetaController::class, 'actualizarPrecios']); // hecho

//COMENTARIOS
Route::get('comentariosUsuario/{id}', [ComentariosController::class, 'comentariosUsuario']);
Route::middleware('auth')->post('nuevoComentario', [ComentariosController::class, 'nuevoComentario']);
Route::get('comentariosReceta/{id}', [ComentariosController::class, 'comentariosReceta']);
Route::middleware('admin')->get('numeroComentarios', [ComentariosController::class, 'numeroComentarios']);

//USUARIOS
Route::post('login', [UsuarioController::class, 'login']); // hecho
Route::get('logout', [UsuarioController::class, 'logout']);
Route::post('registro', [UsuarioController::class, 'registrar']); // hecho
Route::get('infoUsuario/{id}', [UsuarioController::class, 'infoUsuario']);
Route::middleware('admin')->post('eliminarUsuario', [UsuarioController::class, 'eliminarUsuario']);
Route::middleware('admin')->get('numeroUsuarios', [UsuarioController::class, 'numeroUsuarios']); //hecho
Route::get('refresh', [UsuarioController::class, 'refresh']); //hecho
Route::post('me', [UsuarioController::class, 'me']); //hecho

//FAVORITOS
Route::middleware('auth')->get('addFavoritos/{id_receta}', [FavoritoController::class, 'addFavoritos']); // hecho
Route::middleware('auth')->delete('removeFavoritos/{id_receta}',[FavoritoController::class, 'removeFavoritos']); // hecho
Route::middleware('auth')->get('esFavorito/{id_receta}', [FavoritoController::class, 'esFavorito']); // hecho

//INGREDIENTES
Route::get('ingredientes', [IngredienteController::class, 'ingredientes']); // hecho
Route::post('nuevoIngrediente', [IngredienteController::class, 'crear']); // hecho

//ALIMENTOS
Route::post('nuevoAlimento', [AlimentoController::class, 'crear']); // hecho
Route::get('alimentos', [AlimentoController::class, 'getAll']);

//PRECIOS
Route::post('nuevoPrecio', [PrecioController::class, 'crear']); // hecho


//ADMIN
Route::get('getColores', [OpcionesAdminController::class, 'getColores']); //hecho
Route::middleware('admin')->post('setPrincipal', [OpcionesAdminController::class, 'setPrincipal']); //hecho
Route::middleware('admin')->post('setClaro', [OpcionesAdminController::class, 'setClaro']); //hecho
Route::middleware('admin')->post('setSecundario', [OpcionesAdminController::class, 'setSecundario']); //hecho


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

