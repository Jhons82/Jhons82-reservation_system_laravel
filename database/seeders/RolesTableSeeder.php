<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Corrige el nombre mal escrito en el registro existente
        /* Role::where('name', 'Administador')->update(['name' => 'Administrador']); */
        
        $roles = ['Administrador','Asesor', 'Usuario'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}
