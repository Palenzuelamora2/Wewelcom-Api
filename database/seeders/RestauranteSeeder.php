<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurante;

class RestauranteSeeder extends Seeder
{
    public function run(): void
    {
        Restaurante::insert([
            [
                'nombre_restaurante' => 'La Parrilla Argentina',
                'direccion_restaurante' => 'Av. Libertador 123',
                'telefono_restaurante' => '123456789',
            ],
            [
                'nombre_restaurante' => 'Sushi Express',
                'direccion_restaurante' => 'Calle Sake 88',
                'telefono_restaurante' => '987654321',
            ],
            [
                'nombre_restaurante' => 'Pasta Mia',
                'direccion_restaurante' => 'Via Roma 456',
                'telefono_restaurante' => '555666777',
            ],
        ]);
    }
}
