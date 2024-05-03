<?php

namespace Database\Seeders;
use App\Models\Etiqueta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtiquetasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Etiqueta::create(['tagnom' => 'chocholate']);
        Etiqueta::create(['tagnom' => 'blanco']);
        Etiqueta::create(['tagnom' => 'negro']);
        Etiqueta::create(['tagnom' => 'crema']);
    }
}
