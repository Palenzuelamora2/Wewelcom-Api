<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    //Añadimos los seeders para agregar datos durante el desarrollo
    public function run(): void
    {
        $this->call([
            RestauranteSeeder::class,
            UsuarioSeeder::class,
        ]);
    }
}
