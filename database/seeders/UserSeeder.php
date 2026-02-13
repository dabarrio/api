<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin principal
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@cms.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Editor activo
        User::create([
            'name' => 'Editor User',
            'email' => 'editor@cms.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
        ]);

        // Editor inactivo
        User::create([
            'name' => 'Editor Inactivo',
            'email' => 'inactive@cms.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => false,
        ]);

        // Usuarios adicionales
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@cms.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'María García',
            'email' => 'maria@cms.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'is_active' => true,
        ]);
    }
}
