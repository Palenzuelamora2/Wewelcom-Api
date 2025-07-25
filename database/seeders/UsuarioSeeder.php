<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'), // Siempre hashea la contraseña
            ],
            [
                'name' => 'Juan Pérez',
                'email' => 'juan@example.com',
                'password' => Hash::make('secret123'),
            ],
            [
                'name' => 'Ana García',
                'email' => 'ana@example.com',
                'password' => Hash::make('clave456'),
            ],
        ]);
    }
}
