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
        Schema::table('pedidos_lineas', function (Blueprint $table) {
            $table->double('iva');
            $table->double('iva_porcentaje');
            $table->double('recargo');
            $table->double('recargo_porcentaje');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos_lineas', function (Blueprint $table) {
            $table->dropColumn('iva');
            $table->dropColumn('iva_porcentaje');
            $table->dropColumn('recargo_porcentaje');
            $table->dropColumn('recargo');
        });
    }
};
