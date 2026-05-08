<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articulo', function (Blueprint $table) {
            // $table->id();
            $table->string('artcod',10)->primary();
            $table->string('artnom', 50);
            $table->string('artobs', 1000); //descripcion 
            $table->string('artivacod', 3); //iva
            $table->string('artcatcod', 3); //id_categoria
            $table->string('artsit', 1); //situacion del articulo, visibilidad hiden (baja, valor en bd='b') o visible (comercializable'C') 
            $table->string('artbarcod', 30); //codigo de barra
            $table->string('artima1'); //img
            $table->string('artima2');
            $table->string('artima3');
            $table->string('artima4');
            $table->string('artdocaso'); //documento asociado pdf para ver ficha técnica
            $table->float('artstock'); //stock
            $table->string('artest4', 1000); //descripcion larga del articulo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulo');
    }
};
