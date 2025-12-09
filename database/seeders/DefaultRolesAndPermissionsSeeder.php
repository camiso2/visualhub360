<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class DefaultRolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Evita errores si ejecutas varias veces el seeder
        DB::beginTransaction();

        try {
            // 🔹 Lista base de permisos del sistema
            $permissions = [
                // Usuarios
                'ver_usuarios',
                'crear_usuarios',
                'editar_usuarios',
                'eliminar_usuarios',

                // Clientes
                'ver_clientes',
                'crear_clientes',
                'editar_clientes',
                'eliminar_clientes',

                // Productos
                'ver_productos',
                'crear_productos',
                'editar_productos',
                'eliminar_productos',

                // Reportes
                'ver_reportes',
                'exportar_reportes',
            ];

            // 🔹 Roles base que toda empresa debe tener
            $roles = [
                'Administrador General',
                'Administrador Sucursal',
                'Asesor Interno',
                'Asesor Externo',
                'Auditor',
                'Supervisor',
            ];

            // 🔹 Recorremos todas las empresas existentes
            $companies = Company::all();

            foreach ($companies as $company) {

                // Creamos permisos sin duplicar (firstOrCreate)
                foreach ($permissions as $perm) {
                    Permission::firstOrCreate(
                        [
                            'name' => $perm,
                            'guard_name' => 'api',
                            'company_id' => $company->id,
                        ],
                        [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                // Creamos roles sin duplicar (firstOrCreate)
                foreach ($roles as $roleName) {
                    $role = Role::firstOrCreate(
                        [
                            'name' => $roleName,
                            'guard_name' => 'api',
                            'company_id' => $company->id,
                        ],
                        [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );

                    // 🔸 Asigna permisos base a los roles más altos
                    if ($roleName === 'Administrador General') {
                        $role->syncPermissions(
                            Permission::where('company_id', $company->id)->pluck('name')->toArray()
                        );
                    }

                    if ($roleName === 'Administrador Sucursal') {
                        $role->syncPermissions([
                            'ver_clientes',
                            'crear_clientes',
                            'editar_clientes',
                            'ver_usuarios',
                            'ver_reportes',
                        ]);
                    }
                }
            }

            DB::commit();

            echo "✅ Roles y permisos creados o actualizados correctamente.\n";
        } catch (\Exception $e) {
            DB::rollBack();
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
