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
        //
        Schema::create('articulo_etiqueta', function (Blueprint $table) {
            $table->id();
            $table->string('artcod',10);
            $table->foreign('artcod')->references('artcod')->on('articulo')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tagcod');
            $table->foreign('tagcod')->references('tagcod')->on('etiquetas')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
        
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //

    }
};
