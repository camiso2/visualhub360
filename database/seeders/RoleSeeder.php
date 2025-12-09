<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Asesor Interno', 'description' => 'Usuario que asesora clientes desde la oficina central.'],
            ['name' => 'Asesor Externo', 'description' => 'Usuario que asesora clientes en campo.'],
            ['name' => 'Administrador General', 'description' => 'Usuario con control total sobre el sistema.'],
            ['name' => 'Administrador Sucursal', 'description' => 'Usuario que administra una sucursal específica.'],
            ['name' => 'Auditor', 'description' => 'Usuario encargado de verificar procesos y registros.'],
            ['name' => 'Supervisor', 'description' => 'Usuario que supervisa a otros usuarios en el sistema.'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']]
            );
        }
    }
}
