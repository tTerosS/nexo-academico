<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cuenta Maestra Propietaria: GRUPO OSALVAC SRL
        User::updateOrCreate(
            ['email' => 'admin@osalvac.pe'],
            [
                'name' => 'GRUPO OSALVAC SRL',
                'role' => 'administrador',
                'password' => Hash::make('AdminOsalvac2026*'),
            ]
        );

        // Docente de prueba
        User::updateOrCreate(
            ['email' => 'docente@osalvac.pe'],
            [
                'name' => 'Profesor de Prueba',
                'role' => 'docente',
                'password' => Hash::make('Docente2026*'),
            ]
        );

        // Alumno de prueba
        User::updateOrCreate(
            ['email' => 'alumno@osalvac.pe'],
            [
                'name' => 'Alumno de Prueba',
                'role' => 'alumno',
                'password' => Hash::make('Alumno2026*'),
            ]
        );
    }
}