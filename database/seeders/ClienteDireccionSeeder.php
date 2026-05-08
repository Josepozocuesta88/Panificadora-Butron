<?php

namespace Database\Seeders;

use App\Models\ClienteDireccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteDireccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClienteDireccion::factory(10)->create();
    }
}
