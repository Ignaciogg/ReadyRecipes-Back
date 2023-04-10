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
        Schema::create('ingrediente', function (Blueprint $table) {
            $table->increments('id_Ingediente');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('id_Receta')->references('id_Receta')->on('receta');
            $table->foreignId('id_Alimento')->references('id_Alimento')->on('alimento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingrediente');
    }
};
