<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Permisos globales (sin company_id)
        $globalPermissions = [
            'ver_usuarios',
            'crear_usuarios',
            'editar_usuarios',
            'eliminar_usuarios',
            'ver_roles',
            'crear_roles',
            'editar_roles',
            'eliminar_roles',
            'ver_reportes',
        ];

        foreach ($globalPermissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'api',
                'company_id' => null
            ]);
        }

        // 🔹 Ejemplo: permisos específicos para una empresa (opcional)
        // Supongamos que la empresa con ID = 1 tiene permisos personalizados
        $empresa1Permissions = [
            'ver_clientes',
            'crear_clientes',
            'editar_clientes',
            'eliminar_clientes'
        ];

        foreach ($empresa1Permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'api',
                'company_id' => 15
            ]);
        }

        // Si quieres agregar más empresas, puedes duplicar el bloque anterior
        // y cambiar el company_id correspondiente
    }
}
