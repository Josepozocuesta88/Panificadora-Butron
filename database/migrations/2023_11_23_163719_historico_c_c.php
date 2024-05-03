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
        Schema::create('albarancc', function (Blueprint $table) {
            // $table->id();
            $table->string('accser', 5);
            $table->string('acceje', 4);
            $table->float('accnum');
            $table->string('acccod')->virtualAs('accser + acceje + accnum');
            $table->string('accclicod', 15);  
            $table->string('acccencod', 4); 
            $table->string('aclartcod', 10); // codigo del artículo (está en albarancl)
            $table->string('aclcan', 4); //cantidad (está en albarancl)
            $table->string('aclpretot', 4); //total (está en albarancl) 
            $table->datetime('accfec'); // fecha de creacion del albaran
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
