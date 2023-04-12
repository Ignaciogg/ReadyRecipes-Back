<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saludo(Request $request) {
        return json_encode("HOLA, ".$request->nombre);
    }

    public function saludo2(Request $nombre) {
        return json_encode("HOLAAAAAA, ".$nombre->nombre);
    }

    public function bienvenida(Request $nombre, $edad) {
        if($edad < 18) {
            return json_encode("No eres mayor de edad, ".$nombre->nombre);
        } else {
            return json_encode("Bienvenido, ".$nombre->nombre);
        }
    }

    /////////////////// READY RECIPES //////////////////////

    // Recuperar info de una receta (nº de comentarios de YT (positivos, negativos, neutros)), nutriscore, precio
    public function receta($id) {
        $receta = Receta::find($id);
        return json_encode($receta);
    }

    // Recuperar los comentarios de una receta (escritos por nuestros usuarios)
    public function comentarios($id) {

    }

    // Añadir un comentario a una receta
    public function nuevoComentario($id, $comentario) {

    }

    // categoria es number, ingredientes es array, nutriscore es number, precio es number, favorito es boolean
    public function buscador($categoria, $ingredientes, $nutriscore, $precio, $favorito) {

    }

    // Cerrar sesion
    public function logout() {

    }

    // Añadir la receta a favoritos
    public function addFavoritos($id) {
        // El que haga esta, que haga tambien removeFavoritos()
    }

    // Eliminar la receta de favoritos
    public function removeFavoritos($id) {

    }

    // Obtener lista de todos los ingredientes para el buscador
    public function ingredientes() {

    }
}
