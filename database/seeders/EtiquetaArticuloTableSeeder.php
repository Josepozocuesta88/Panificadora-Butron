<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use App\Models\Articulo;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtiquetaArticuloTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $etiqueta1 = Etiqueta::where('tagnom', 'chocholate')->first();
        $etiqueta2 = Etiqueta::where('tagnom', 'blanco')->first();
        $etiqueta2 = Etiqueta::where('tagnom', 'negro')->first();
        $etiqueta2 = Etiqueta::where('tagnom', 'crema')->first();

        $articulo1 = Articulo::where('artcod', '210407')->first();
        $articulo2 = Articulo::where('artcod', '22395')->first();
        // el primer tagcod es para la tabla de relaciones
        EtiquetaArticulo::create(['tagcod' => $etiqueta1->tagcod, 'artcod' => $articulo1->artcod]);
        EtiquetaArticulo::create(['tagcod' => $etiqueta2->tagcod, 'artcod' => $articulo2->artcod]);
    }
}
