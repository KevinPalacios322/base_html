<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::updateOrCreate(
        ['email' => 'admin@clase.test'],
        [
        'name' => 'Administrador de práctica',
        'password' => Hash::make('Clase2026!'),
        ]
        );


    }
}
