<?php

namespace Database\Seeders;
use App\Models\Etiqueta;
use App\Models\EtiquetaArticulo;
use App\Models\Articulo;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Category::factory(60)->create();

        \App\Models\User::factory()->create([
            'usucod' => '001',
            'name' => 'mluisa',
            'email' => 'marialuisa@redesycomponentes.com',
            'password' => 'Admin1234',
            'usugrucod' => 'admin',
            'usuclicod' => '430000000',
            'usucencod' => '0000'
        ]);
        // \App\Models\User::factory()->create([
        //     'usucod' => '001',
        //     'name' => 'user',
        //     'email' => 'user@test.com',
        //     'password' => 'user',
        //     'usugrucod' => 'User',
        //     'usuclicod' => '430000001',
        //     'usucencod' => '0001'
        // ]);
        // \App\Models\Articulo::create([
        //     'artcod' => '22395',
        //     'artnom' => 'LECHERITAS CACAO GLASS S/EN 2KG',
        //     'artobs' => 'muy ricas',  
        //     'artivacod' => '123',
        //     'artcatcod' => '001', 
        //     'artsit' => 'B',
        //     'artbarcod' => '123', 
        //     'artima1' => 'lecherita2.jpg',
        //     'artima2' => 'lecherita1.jpg',
        //     'artima3' => '',
        //     'artima4' => '',
        //     'artdocaso' => '1232123', 
        //     'artstock' => 24 
        // ]);
        // \App\Models\Articulo::create([
        //     'artcod' => '227703',
        //     'artnom' => 'CUADRADITO 2 KG',
        //     'artobs' => 'descripcion aqui',  
        //     'artivacod' => '231',
        //     'artcatcod' => '002', 
        //     'artsit' => 'B',
        //     'artbarcod' => '123', 
        //     'artima1' => 'cuadradito.jpg',
        //     'artima2' => '',
        //     'artima3' => '',
        //     'artima4' => '',
        //     'artdocaso' => '1232123', 
        //     'artstock' => 0
        // ]);
        // \App\Models\Articulo::create([
        //     'artcod' => '210407',
        //     'artnom' => 'MAGDALENAS VALENCIANAS ENV 1X1 1.6KG',
        //     'artobs' => 'descripcion aqui',  
        //     'artivacod' => '123',
        //     'artcatcod' => '003', 
        //     'artsit' => 'B',
        //     'artbarcod' => '321', 
        //     'artima1' => 'magdalena.jpg',
        //     'artima2' => 'magdalena2.jpg',
        //     'artima3' => '',
        //     'artima4' => '',
        //     'artdocaso' => '2123133', 
        //     'artstock' => 232 
        // ]);
        // \App\Models\Articulo::create([
        //     'artcod' => '28302',
        //     'artnom' => 'CRUJIBOM-WAFER 36 UND',
        //     'artobs' => 'descripcion aqui',  
        //     'artivacod' => '123',
        //     'artcatcod' => '002', 
        //     'artsit' => 'B',
        //     'artbarcod' => '321', 
        //     'artima1' => 'crujibom1.jpg',
        //     'artima2' => 'crujibom2.jpg',
        //     'artima3' => '',
        //     'artima4' => '',
        //     'artdocaso' => '2123133',
        //     'artstock' => -1
        // ]);
        // \App\Models\Articulo::create([
        //     'artcod' => '227401',
        //     'artnom' => 'ROSCOS BAÑADOS 2KG GRANEL',
        //     'artobs' => 'descripcion aqui',  
        //     'artivacod' => '123',
        //     'artcatcod' => '002', 
        //     'artsit' => 'B',
        //     'artbarcod' => '321', 
        //     'artima1' => 'rosco.jpg',
        //     'artima2' => '',
        //     'artima3' => '',
        //     'artima4' => '',
        //     'artdocaso' => '2123133',
        //     'artstock' => 42
        // ]);
        // \App\Models\Precio::create([
        //     'precod' => '006',
        //     'preartcod' => '211113',
        //     'pretarcod' => '001',  
        //     'preimp' => '12.3'
        // ]);
        // \App\Models\Precio::create([
        //     'precod' => '007',
        //     'preartcod' => '213418',
        //     'pretarcod' => '001',  
        //     'preimp' => '12.3'
        // ]);
        // \App\Models\Precio::create([
        //     'precod' => '007',
        //     'preartcod' => '28302',
        //     'pretarcod' => '001',  
        //     'preimp' => '12.3'
        // ]);


        
        // \App\Models\Precio::create([
        //     'precod' => '001',
        //     'preartcod' => '210407',
        //     'pretarcod' => '001',  
        //     'preimp' => '12.3'
        // ]);
        // \App\Models\Precio::create([
        //     'precod' => '002',
        //     'preartcod' => '22395',
        //     'pretarcod' => '002',  
        //     'preimp' => '8.95'
        // ]);
        // \App\Models\Precio::create([
        //     'precod' => '003',
        //     'preartcod' => '227703',
        //     'pretarcod' => '003',  
        //     'preimp' => '4.95'
        // ]);
        // \App\Models\Precio::create([
        //     'precod' => '004',
        //     'preartcod' => '28302',
        //     'pretarcod' => '004',  
        //     'preimp' => '10.95'
        // ]);

        // \App\Models\Alergeno::create([
        //     'alergcod' => '001',
        //     'alergartcod' => '28302',
        //     'alergima' => 'gluten.ico',  
        // ]);
        // \App\Models\Alergeno::create([
        //     'alergcod' => '002',
        //     'alergartcod' => '28302',
        //     'alergima' => 'huevo.ico',  
        // ]);
        // \App\Models\Alergeno::create([
        //     'alergcod' => '003',
        //     'alergartcod' => '28302',
        //     'alergima' => 'lacteos.ico',  
        // ]);
        // \App\Models\Alergeno::create([
        //     'alergcod' => '004',
        //     'alergartcod' => '28302',
        //     'alergima' => 'frutosCascara.ico',  
        // ]);
        // \App\Models\Alergeno::create([
        //     'alergcod' => '005',
        //     'alergartcod' => '210407',
        //     'alergima' => 'gluten.ico',  
        // ]);
        // \App\Models\Alergeno::create([
        //     'alergcod' => '006',
        //     'alergartcod' => '210407',
        //     'alergima' => 'huevo.ico',  
        // ]);
        // \App\Models\Alergeno::create([
        //     'alergcod' => '007',
        //     'alergartcod' => '227703',
        //     'alergima' => 'lacteos.ico',  
        // ]);
        // \App\Models\Alergeno::create([
        //     'alergcod' => '008',
        //     'alergartcod' => '227703',
        //     'alergima' => 'frutosCascara.ico',  
        // ]);
        // \App\Models\Alergeno::create([
        //     'alergcod' => '009',
        //     'alergartcod' => '227703',
        //     'alergima' => 'huevo.ico',  
        // ]);
        
        // Etiqueta::create(['tagnom' => 'chocholate']);
        // Etiqueta::create(['tagnom' => 'blanco']);
        // Etiqueta::create(['tagnom' => 'negro']);
        // Etiqueta::create(['tagnom' => 'crema']);
        // Etiqueta::create(['tagnom' => 'avellana']);

        // $etiqueta1 = Etiqueta::where('tagnom', 'chocholate')->first();
        // $etiqueta1 = Etiqueta::where('tagnom', 'avellana')->first();
        // $etiqueta2 = Etiqueta::where('tagnom', 'blanco')->first();
        // $etiqueta2 = Etiqueta::where('tagnom', 'negro')->first();
        // $etiqueta2 = Etiqueta::where('tagnom', 'crema')->first();

        // $articulo1 = Articulo::where('artcod', '227703')->first();
        // $articulo2 = Articulo::where('artcod', '210407')->first();
        // // // el primer tagcod es para la tabla de relaciones
        // EtiquetaArticulo::create(['tagcod' => $etiqueta1->tagcod, 'artcod' => $articulo1->artcod]);
        // EtiquetaArticulo::create(['tagcod' => $etiqueta1->tagcod, 'artcod' => $articulo1->artcod]);
        // EtiquetaArticulo::create(['tagcod' => $etiqueta2->tagcod, 'artcod' => $articulo2->artcod]);
    }
}
