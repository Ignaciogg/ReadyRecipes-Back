<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->increments('id_Comentario');
            $table->string('contenido');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('id_Receta')->references('id_Receta')->on('receta');
            $table->foreignId('id_Usuario')->references('id_Usuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario');
    }
};
